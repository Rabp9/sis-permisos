<?php

/**
 * CakePHP User
 * @author admin
 */

App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {
    public $useDbConfig = 'usuario';
    public $useTable = "Usuarios";
    public $primaryKey = "Usu_Codigo";
    
    public $belongsTo = array(
        "Group",
        "Trabajador" => array(
            "foreignKey" => "Per_DNI"
        )
    );
     
    public $actsAs = array('Acl' => array('type' => 'requester', 'enabled' => false));

    public function beforeSave($options = array()) {
        if (isset($this->data['User']['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data['User']['password'] = $passwordHasher->hash(
                $this->data['User']['password']
            );
        }
        return true;
    }

    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data["User"]["group_id"])) {
            $group_id = $this->data["User"]["group_id"];
        } else {
            $group_id = $this->field("group_id");
        }
        if (!$group_id) {
            return null;
        } else {
            return array('Group' => $group_id);
        }
    }

    public function bindNode($user) {
        return array('model' => "Group", "foreign_key" => $user["User"]["group_id"]);
    }
    
    public $validate = array(
        'group_id' => array(
            'notBlank'
        )
    );
}