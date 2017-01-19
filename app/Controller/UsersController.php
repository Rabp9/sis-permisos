<?php

/**
 * CakePHP UsersController
 * @author Roberto Bocanegra Palacios
 */

class UsersController extends AppController {
    public $components = array("Paginator");
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow("initDB", "login", "logout");
    }

    public function initDB() {
        $group = $this->User->Group;

        // Administrador
        $group->id = 1;
        $this->Acl->allow($group, 'controllers');

        // Aprobador
        $group->id = 2;
        $this->Acl->deny($group, 'controllers');
        $this->Acl->allow($group, 'controllers/Pages/home');
        $this->Acl->allow($group, 'controllers/Permisos/');        $this->Acl->allow($group, 'controllers/Permisos/index');        $this->Acl->allow($group, 'controllers/Permisos/lista');        $this->Acl->allow($group, 'controllers/Permisos/view');        $this->Acl->allow($group, 'controllers/Permisos/viewlista');$this->Acl->allow($group, 'controllers/Permisos/register');
        $this->Acl->allow($group, 'controllers/Permisos/aprobar');
        $this->Acl->allow($group, 'controllers/Permisos/denegar');
        $this->Acl->allow($group, 'controllers/Permisos/retorno');
        $this->Acl->allow($group, 'controllers/Permisos/permisosPendientes');

        $this->Acl->allow($group, 'controllers/Reportes/boleta');
        $this->Acl->allow($group, 'controllers/Users/login');
        $this->Acl->allow($group, 'controllers/Users/logout');
        $this->Acl->allow($group, 'controllers/Users/datos');
        
        // RRHH
        $group->id = 3;
        $this->Acl->deny($group, 'controllers');
        $this->Acl->allow($group, 'controllers/Pages/home');
        $this->Acl->allow($group, 'controllers/Permisos/');
        $this->Acl->allow($group, 'controllers/Permisos/index');        $this->Acl->allow($group, 'controllers/Permisos/lista');        $this->Acl->allow($group, 'controllers/Permisos/view');        $this->Acl->allow($group, 'controllers/Permisos/viewlista');$this->Acl->allow($group, 'controllers/Permisos/register');
        $this->Acl->allow($group, 'controllers/Permisos/aprobar');
        $this->Acl->allow($group, 'controllers/Permisos/denegar');
        $this->Acl->allow($group, 'controllers/Permisos/retorno');
        $this->Acl->allow($group, 'controllers/Permisos/permisosPendientes');
        $this->Acl->allow($group, 'controllers/Reportes/');
        $this->Acl->allow($group, 'controllers/Reportes/general');
        $this->Acl->allow($group, 'controllers/Reportes/porTrabajador');$this->Acl->allow($group, 'controllers/Reportes/boleta');
        $this->Acl->allow($group, 'controllers/Users/login');
        $this->Acl->allow($group, 'controllers/Users/logout');
        $this->Acl->allow($group, 'controllers/Users/datos');
        
        // Usuario
        $group->id = 4;
        $this->Acl->deny($group, 'controllers');
        $this->Acl->allow($group, 'controllers/Pages/home');
        $this->Acl->allow($group, 'controllers/Permisos');
        $this->Acl->allow($group, 'controllers/Permisos/index');        $this->Acl->allow($group, 'controllers/Permisos/lista');        $this->Acl->allow($group, 'controllers/Permisos/view');        $this->Acl->allow($group, 'controllers/Permisos/viewlista');$this->Acl->allow($group, 'controllers/Permisos/register');
        $this->Acl->allow($group, 'controllers/Permisos/aprobar');
        $this->Acl->allow($group, 'controllers/Permisos/denegar');
        $this->Acl->allow($group, 'controllers/Permisos/retorno');
        $this->Acl->allow($group, 'controllers/Permisos/permisosPendientes');
        $this->Acl->allow($group, 'controllers/Reportes/boleta');
        $this->Acl->allow($group, 'controllers/Users/login');
        $this->Acl->allow($group, 'controllers/Users/logout');
        $this->Acl->allow($group, 'controllers/Users/datos');

        // GAFS
        $group->id = 5;
        $this->Acl->deny($group, 'controllers');
        $this->Acl->allow($group, 'controllers/Pages/home');
        $this->Acl->allow($group, 'controllers/Permisos');
        $this->Acl->allow($group, 'controllers/Permisos/index');        $this->Acl->allow($group, 'controllers/Permisos/lista');        $this->Acl->allow($group, 'controllers/Permisos/view');        $this->Acl->allow($group, 'controllers/Permisos/viewlista');$this->Acl->allow($group, 'controllers/Permisos/register');
        $this->Acl->allow($group, 'controllers/Permisos/aprobar');
        $this->Acl->allow($group, 'controllers/Permisos/denegar');
        $this->Acl->allow($group, 'controllers/Permisos/retorno');
        $this->Acl->allow($group, 'controllers/Permisos/permisosPendientes');
        $this->Acl->allow($group, 'controllers/Reportes');
        $this->Acl->allow($group, 'controllers/Reportes/general');
        $this->Acl->allow($group, 'controllers/Reportes/porTrabajador');$this->Acl->allow($group, 'controllers/Reportes/boleta');
        $this->Acl->allow($group, 'controllers/Users/login');
        $this->Acl->allow($group, 'controllers/Users/logout');
        $this->Acl->allow($group, 'controllers/Users/datos');
        
        // we add an exit to avoid an ugly "missing views" error message*/
        echo "all done";
        exit;
    }
    
    public function login() {
        $this->layout = false;
        
        if($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        
        if ($this->request->is(array("post", "put"))) {
            if ($this->Auth->login()) {
                $this->Session->delete("Message");
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Session->setFlash(__('Nombre de Usuario o password incorrecto, inténtelo nuevamente'), "flash_bootstrap");
        }
    }

    public function logout() {
        if($this->Auth->user()) {
            $this->redirect($this->Auth->logout());
        }
        else {
            $this->redirect(array("controller" => "users", "action" => "login"));
            $this->Session->setFlash(__('Not logged in'), 'default', array(), 'auth');
        }
    }
    
    public function datos() {
        $this->layout = "main";
        
        $user = $this->Auth->user();
        $this->User->recursive = 3;
        $user = $this->User->findByUsuCodigo($user["Usu_Codigo"]);
        $this->set(compact("user"));
    }
}