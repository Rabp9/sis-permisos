<?php
/**
 * CakePHP ReportesController
 * @author admin
 */
class Calculos {
    public static function calcularSumaTotal($suma) {
        $suma_horas = 0;
        $suma_minutos = 0;
        foreach($suma as $i_suma) {
            $horas = date("H", strtotime($i_suma));
            $minutos = date("i", strtotime($i_suma));
            $suma_horas += $horas;
            $suma_minutos += $minutos;
        }
        $suma_horas += intval($suma_minutos / 60);
        $suma_minutos = $suma_minutos % 60;
        return $suma_horas . " horas y " . $suma_minutos . " minutos";
    }
    
    public static function calcularDescuentoSoles($suma, $sueldo) {
        $suma_horas = 0;
        $suma_minutos = 0;
        foreach($suma as $i_suma) {
            $horas = date("H", strtotime($i_suma));
            $minutos = date("i", strtotime($i_suma));
            $suma_horas += $horas;
            $suma_minutos += $minutos;
        }
        $suma_horas += intval($suma_minutos / 60);
        $suma_minutos = $suma_minutos % 60;

        $descuento_minutos = $suma_horas * 60 + $suma_minutos;
        
        $costo_minuto = $sueldo / (60 * 8 * 30);
        $monto = $costo_minuto * $descuento_minutos;
        return 'S/. ' . number_format($monto, 2);
    }
    
    public static function iniciales($nombre) {
	$notocar = Array('del','de');
	$trozos = explode(' ',$nombre);
	$iniciales = '';
	for($i=0;$i<count($trozos);$i++){
		if(in_array($trozos[$i],$notocar)) $iniciales .= $trozos[$i]." ";
		else $iniciales .= substr($trozos[$i],0,1).". ";
	}
	return $iniciales;
    }
}
?>