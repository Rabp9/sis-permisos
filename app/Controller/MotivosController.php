<?php
App::uses('AppController', 'Controller');

/**
 * CakePHP MotivosController
 * @author Roberto Bocanegra Palacios
 */

class MotivosController extends AppController {
    public $components = array('Paginator');
    
    public $paginate = [
        "limit" => 10,
        "order" => [
            "Motivo.id" => "asc"
        ],
        "conditions" => [
            "Motivo.estado" => 1
        ]
    ];
    
    public function index() {
        $this->layout = "main";
        
        $this->Paginator->settings = $this->paginate;
        $motivos = $this->Paginator->paginate();
        $this->set(compact("motivos"));
    }

    public function view($id = null) {
        $this->layout = "main";
        
        if (!$this->Motivo->exists($id)) {
            throw new NotFoundException(__('El Motivo no existe'));
        }
        
        $this->set('motivo', $this->Motivo->findById($id));
    }

    public function add() {
        $this->layout = "main";
        
        if ($this->request->is('post')) {
            $this->Motivo->create();
            if ($this->Motivo->save($this->request->data)) {
                $this->Session->setFlash(__("El Motivo ha sido registrado correctamente."), "flash_bootstrap");
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__("El motivo no pudo ser registrado correctamente."), "flash_bootstrap");
            }
        }
    }

    public function edit($id = null) {
        $this->layout = "main";
        
        if (!$id) {
            throw new NotFoundException(__("Motivo inválido"));
        }
        $motivo = $this->Motivo->findById($id);
        
        if (!$motivo) {
            throw new NotFoundException(__("Motivo inválido"));
        }
          
        if ($this->request->is(array("post", "put"))) {
            $this->Motivo->id = $id;
            if ($this->Motivo->save($this->request->data)) {
                $this->Session->setFlash(__("El Motivo ha sido actualizado."), "flash_bootstrap");
                return $this->redirect(array("action" => "index"));
            }
            $this->Session->setFlash(__("No es posible actualizar el Motivo."), "flash_bootstrap");
        }
        if (!$this->request->data) {
            $this->request->data = $motivo;
        }
    }

    public function delete($id = null) {
        if ($this->request->is("get")) {
            throw new MethodNotAllowedException();
        }
        $this->Motivo->id = $id;
        if ($this->Motivo->saveField("estado", 2)) {
            $this->Session->setFlash(__("El Motivo de código: %s ha sido eliminado.", h($id)), "flash_bootstrap");
            return $this->redirect(array("action" => "index"));
        }
    }
}
