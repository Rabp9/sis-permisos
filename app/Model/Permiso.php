<?php
App::uses('AppModel', 'Model');
App::import("Lib", "Calculos");
/**
 * Permiso Model
 * Permiso Estados:
 * 1: Pendiente de Aprobación
 * 2: Aprobado
 * 3: No Aprobado
 * 4: Terminado
 */
class Permiso extends AppModel {
    public $belongsTo = array(
        "Motivo",
        "Trabajador" => array(
            "foreignKey" => "Per_DNI"
        ),
        "User_genera" => array(
            "className" => "User",
            "foreignKey" => "Usu_Codigo_registro"
        ),
        "User_aprobacion" => array(
            "className" => "User",
            "foreignKey" => "Usu_Codigo_aprobacion"
        ),
        "User_retorno" => array(
            "className" => "User",
            "foreignKey" => "Usu_Codigo_retorno"
        ),
        "Area" => array(
            "foreignKey" => "Are_Codigo"
        )
    );
    public $findMethods = array(
        "hijos" =>  true,
        "reporte" => true
    );
    
    public $virtualFields = array(
        "estado_view" => "CASE 
                  WHEN Permiso.estado = '1' 
                     THEN '<span class=''e1''>Pendiente</span>'
                  WHEN Permiso.estado = '2' 
                     THEN '<span class=''e2''>Aprobado</span>'
                  WHEN Permiso.estado = '3' 
                     THEN '<span class=''e3''>No Aprobado</span>'
                  WHEN Permiso.estado = '4' 
                     THEN '<span class=''e4''>Terminado</span>'
                  ELSE 'Sin Estado'
             END"
    );
    protected function _findHijos($state, $query, $results = array()) {
        if ($state === "before") {
            $Per_DNI = $query["Per_DNI"];
            $dnis = $this->query("SELECT 
                trabajador_Per_DNI
            FROM 
                Permiso.Trabajadores_Aprobadores
            WHERE
                aprobador_Per_DNI = '" . $Per_DNI . "'");
            $dnis = Hash::extract($dnis, '{n}.0.trabajador_Per_DNI');
            $query["conditions"]["Permiso.Per_DNI"] = $dnis;
            return $query;
        }
        return $results;
    }
    
    protected function _findReporte($state, $query, $results = array()) {
        if ($state === "before") {
            return $query;
        }
        $this->TrabFajador->recursive = 2;
        $trabajadores = $this->Trabajador->find("intervalo", array(
            "fecha_inicio" => $query["fecha_inicio"],
            "fecha_cierre" => $query["fecha_cierre"]
        ));
        foreach($trabajadores as $k_trabajador => $trabajador) {
            foreach($trabajador["Permiso"] as $k_permiso => $permiso) {
                if(strtotime($permiso["fecha_permiso"]) < strtotime($query["fecha_inicio"]) || strtotime($permiso["fecha_permiso"]) > strtotime($query["fecha_cierre"])) {
                    unset($trabajadores[$k_trabajador]["Permiso"][$k_permiso]);
                }
            }
        }
        foreach($trabajadores as $k_trabajador => $trabajador) {
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
            $trabajadores[$k_trabajador]["tiempo_total"] = Calculos::calcularSumaTotal($sumaTotal);
        }
        return $trabajadores;
    }
    
    public $validate = array(
        'hora_salida' => array(
            'notBlank'
        ),
        'hora_retorno' => array(
            'notBlank'
        ),
        'destino' => array(
            'notBlank'
        ),
        "fecha_permiso" => array(
            'notBlank',
            "date" => array(
                "rule" => "date",
                "message" => "Ingrese una fecha"
            )
        ),
        'motivo_id' => array(
            'notBlank'
        )
    );
   
    public function nextNroBoleta() {
        $next_nro_boleta = $this->query("SELECT (SELECT TOP 1 nro_boleta
            from Permiso.Permisos
            order by nro_boleta desc) + 1 AS next_nro_boleta");
        $next_nro_boleta = $next_nro_boleta[0][0]["next_nro_boleta"];
        return $next_nro_boleta;
    }
}
