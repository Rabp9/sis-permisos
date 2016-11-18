<?php

/**
 * CakePHP Group
 * @author admin
 */

App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Group extends AppModel {
    public $actsAs = array('Acl' => array('type' => 'requester'));
        
    public $hasMany = array("User");
    public $displayField = "descripcion";
    
    public function parentNode() {
        return null;
    }
}