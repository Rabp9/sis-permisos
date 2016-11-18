<?php
App::uses('AppModel', 'Model');
/**
 * Permiso Model
 *
 */
class Trabajador extends AppModel {
    public $primaryKey = "Per_DNI";
    public $useDbConfig = 'rh';
    public $useTable = "Trabajador";
    public $displayField = "nombre_completo";
    public $virtualFields = array(
        "nombre_completo" => "CONCAT(Per_ApPaterno, ' ', Per_ApMaterno, ', ', Per_Nombre, ' ', Per_Nombre2)"
    );
    public $findMethods = array(
        'disponibles' =>  true,
        'list_disponibles' =>  true,
        'intervalo' => true,
        'reporte' => true
    );
    
    public $hasMany = array(
        "Permiso" => array(
            "foreignKey" => "Per_DNI",
            "conditions" => array("Permiso.estado" => 4)
        )
    );
    public $hasOne = array(
        "User" => array(
            "foreignKey" => "Per_DNI"
        ),
        "Trabajadores_Aprobador" => array(
            "foreignKey" => "trabajador_Per_DNI"
        ),
        "Historico_Cargo" => array(
            "foreignKey" => "Per_DNI",
            "conditions" => array(
                "Historico_Cargo.Hiscar_Estado" => '00'
            )
        )
    );
    
    /*public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->hasOne["Historico_Cargo"]["conditions"]["Historico_Cargo.Anio_Codigo"] = date("Y");
    }*/
    
    protected function _findDisponibles($state, $query, $results = array()) {
        if ($state === "before") {
            $dnis = $this->query("SELECT Per_DNI FROM RRHH.Historico_Cargo WHERE Hiscar_Estado = '00'");
            $dnis = Hash::extract($dnis, '{n}.0.Per_DNI');
            $query["conditions"]["Trabajador.Per_DNI"] = $dnis;
            return $query;
        }
        return $results;
    }
    
    protected function _findList_disponibles($state, $query, $results = array()) {
        if ($state === "before") {
            $dnis = $this->query("SELECT Per_DNI FROM RRHH.Historico_Cargo WHERE Hiscar_Estado = '00'");
            $dnis = Hash::extract($dnis, '{n}.0.Per_DNI');
            $query["recursive"] = -1;
            $query["conditions"]["Trabajador.Per_DNI"] = $dnis;
            $query["fields"] = array("Trabajador.Per_DNI", "Trabajador.nombre_completo");
            return $query;
        }           
        $results = Set::combine($results, '{n}.Trabajador.Per_DNI', '{n}.Trabajador.nombre_completo');
        return $results;
    }
   
    protected function _findIntervalo($state, $query, $results = array()) {
        if ($state === "before") {
            
            $dnis = $this->query("SELECT 
                DISTINCT p.Per_DNI 
            FROM 
                Permiso.Permisos p INNER JOIN
                RRHH.Historico_Cargo hc ON (hc.Per_DNI = p.Per_DNI AND hc.Anio_Codigo = YEAR('" . $query["fecha_cierre"] . "'))
            WHERE
                hc.CatLab_Codigo = '" . $query["categoria_laboral"] . "' AND
                fecha_permiso BETWEEN '" . $query["fecha_inicio"] . "' AND '" . $query["fecha_cierre"] . "'");
            $dnis = Hash::extract($dnis, '{n}.0.Per_DNI');
            $query["conditions"]["Trabajador.Per_DNI"] = $dnis;
            return $query;
        }
        return $results;
    }
    
    protected function _findReporte($state, $query, $results = array()) {
        if ($state === "before") {
            return $query;
        }
        $this->recursive = 2;
        $trabajadores = $this->find("intervalo", array(
            "fecha_inicio" => $query["fecha_inicio"],
            "fecha_cierre" => $query["fecha_cierre"],
            "categoria_laboral" => $query["categoria_laboral"]
        ));
        foreach($trabajadores as $k_trabajador => $trabajador) {
            foreach($trabajador["Permiso"] as $k_permiso => $permiso) {
                if(strtotime($permiso["fecha_permiso"]) < strtotime($query["fecha_inicio"]) || strtotime($permiso["fecha_permiso"]) > strtotime($query["fecha_cierre"])) {
                    unset($trabajadores[$k_trabajador]["Permiso"][$k_permiso]);
                }
            }
        }
        $fecha_cierre = strtotime($query["fecha_cierre"]);
        $anio = date('Y', $fecha_cierre);
        
        foreach($trabajadores as $k_trabajador => $trabajador) {
            $query_exec = "SELECT ConTra_Monto
                FROM RRHH.Concepto_Trabajador
                WHERE Con_Codigo = 2 AND ConTra_InicioAnio = " . $anio . "
                AND Per_DNI = '" . $trabajador["Trabajador"]["Per_DNI"] ."'";
            
            $sueldo = $this->query($query_exec)[0][0]["ConTra_Monto"];
            
            $sumaDescuento = array();
            $sumaTotal = array();
            foreach($trabajador["Permiso"] as $k_permiso => $permiso) {
                $difTotal = date("H:i:s", strtotime("00:00:00") + strtotime($permiso["hora_retorno"]) - strtotime($permiso["hora_salida"]) );
                $sumaTotal[] = $difTotal;
                
                if($permiso["Motivo"]["descuento"]) {
                    $difDescuento = date("H:i:s", strtotime("00:00:00") + strtotime($permiso["hora_retorno"]) - strtotime($permiso["hora_salida"]) );
                    $sumaDescuento[] = $difDescuento;
                } else {
                    $difDescuento = 0;
                }
                $trabajadores[$k_trabajador]["Permiso"][$k_permiso]["minutos_descuento"] = $difDescuento;
            }
            $trabajadores[$k_trabajador]["descuento_detalle"] = $sumaDescuento;
            $trabajadores[$k_trabajador]["descuento_total"] = Calculos::calcularSumaTotal($sumaDescuento);
            $trabajadores[$k_trabajador]["descuento_minutos"] = Calculos::calcularDescuentoSoles($sumaDescuento, $sueldo);
            $trabajadores[$k_trabajador]["sueldo"] = "S/. " . number_format($sueldo, 2);
            $trabajadores[$k_trabajador]["tiempo_total"] = Calculos::calcularSumaTotal($sumaTotal);
        }
        return $trabajadores;
    }
}
