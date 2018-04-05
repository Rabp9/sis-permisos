<?php

/**
 * CakePHP GroupsController
 * @author Roberto Bocanegra Palacios
 */

class GroupsController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow("index", "add");
    }
    
    public function index() {
        $this->layout = "main";
        
        $this->Group->recursive = -1;
        $this->set('groups', $this->paginate());
    }

    public function view($id = null) {
        $this->layout = "admin";

        $this->Group->id = $id;
        if (!$this->Group->exists()) {
            throw new NotFoundException(__('Grupo inválido'));
        }
        $this->set('group', $this->Group->read(null, $id));
    }

    public function add() {
        $this->layout = "main";
        
        if ($this->request->is('post')) {
            $this->Group->create();
            if ($this->Group->save($this->request->data)) {
                $this->Session->setFlash(__('El Grupo ha sido registrado correctamente'), "flash_bootstrap");
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__("No fue posible registrar al Grupo."), "flash_bootstrap");
        }
    }
    
    public function beforeRender() {
        $user = $this->Auth->user();
        CakeLog::write('actividad', "El usuario " . $user['Usu_Login'] . " ingresó a  "
            . $this->request->params['controller'] . "->" . $this->request->params['action']);
        parent::beforeRender();
    }
}