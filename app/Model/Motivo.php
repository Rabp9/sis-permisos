<?php
App::uses('AppModel', 'Model');
/**
 * Motivo Model
 *
 */
class Motivo extends AppModel {
    public $virtualFields = array(
        "descuento_view" => "CASE 
                  WHEN descuento = '1' 
                     THEN 'Si'
                  ELSE 'No'
             END"
    );
    public $displayField = "descripcion";
    
    public $validate = array(
        'descripcion' => array(
            'notBlank'
        )
    );
}