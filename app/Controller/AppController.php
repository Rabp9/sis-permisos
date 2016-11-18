<?php

/**
 * CakePHP UsersController
 * @author Roberto Bocanegra Palacios
 */

App::uses('Controller', 'Controller');
App::uses('AuthComponent', 'Controller/Component');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class AppController extends Controller {
    public $components = array(
        "Flash", "Acl", "Session",
        "Auth" => array(
            "authError" => "No tiene los permisos necesarios para realizar esta acción",
            "authenticate" => array(
                "Form" => array(
                    'fields' => array(
                        'username' => 'Usu_Login', //Default is 'username' in the userModel
                        'password' => 'Usu_Password'  //Default is 'password' in the userModel
                    )
                )
            ),
            "authorize" => array(
                "Actions" => array("actionPath" => "controllers")
            )
        )
    );
        
    public function beforeFilter() {
        $this->Auth->loginAction = array(
            'controller' => 'Users',
            'action' => 'login'
        );
        $this->Auth->logoutRedirect = array(
            'controller' => 'Users',
            'action' => 'login'
        );
        $this->Auth->loginRedirect = array(
            "controller" => "Pages",
            "action" => "home"
        );
        $this->Auth->unauthorizedRedirect = array(
            "controller" => "Pages",
            "action" => "home"
        );
        Security::setHash('md5');
    }
}
