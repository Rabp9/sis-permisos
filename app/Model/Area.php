<?php
App::uses('AppModel', 'Model');
/**
 * Motivo Model
 *
 */
class Area extends AppModel { 
    public $primaryKey = "Are_Codigo";
    public $useDbConfig = 'rh';
    public $useTable = "Area";
    public $displayField = "Are_Descripcion";
}