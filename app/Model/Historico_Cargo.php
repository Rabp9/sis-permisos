<?php
App::uses('AppModel', 'Model');
/**
 * Motivo Model
 *
 */
class Historico_Cargo extends AppModel { 
    public $primaryKey = "HisCar_Codigo";
    public $useDbConfig = 'rh';
    public $useTable = "Historico_Cargo";
    public $belongsTo = array(
        "Area" => array(
            "foreignKey" => "Are_Codigo"
        )
    );
}