<?php
App::uses('AppModel', 'Model');
/**
 * Motivo Model
 *
 */
class Trabajadores_Aprobador extends AppModel { 
    public $useTable = "Trabajadores_Aprobadores";
     
    public $belongsTo = array(
        "Trabajador" => array(
            "foreignKey" => "trabajador_Per_DNI"
        ),
        "Aprobador" => array(
            "className" => "Trabajador",
            "foreignKey" => "aprobador_Per_DNI"
        )
    );
    
    public $validate = array(
        'aprobador_Per_DNI' => array(
            'notBlank'
        )
    );
}