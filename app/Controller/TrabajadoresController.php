<?php
App::uses('AppController', 'Controller');
/**
 * Trabajadores Controller
 *
 * @property Trabajador Trabajador
 * @property PaginatorComponent $Paginator
 */
class TrabajadoresController extends AppController {
    public $components = array('Paginator');
    public $uses = array("Trabajador");
    
    public $paginate = [
        "findType" => "disponibles",
        "limit" => 10,
        "order" => [
            "Trabajador.Per_DNI" => "asc"
        ]
    ];
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->layout = "main";
                
        $this->Trabajador->recursive = 2;
        $this->Paginator->settings = $this->paginate;
        $trabajadores = $this->Paginator->paginate();
        $this->set(compact("trabajadores"));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($Per_DNI = null) {
        $this->layout = "main";
        
        if (!$this->Trabajador->exists($Per_DNI)) {
            throw new NotFoundException(__('El Trabajador no existe'));
        }
        $this->Trabajador->recursive = 2;
        $this->set('trabajador', $this->Trabajador->findByPerDni($Per_DNI));
    }

    /**
     * add method
     *
     * @return void
     */
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

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($Per_DNI = null) {
        $this->layout = "main";
        
        if (!$Per_DNI) {
            throw new NotFoundException(__("Trabajador inválido"));
        }
        if ($this->request->is(array("post", "put"))) {
            $ds = $this->Trabajador->getDataSource();
            $ds->begin();
            $this->Trabajador->User->id = $this->request->data["User"]["Usu_Codigo"];
            if ($this->Trabajador->User->save($this->request->data)) {
                if($this->Trabajador->Trabajadores_Aprobador->save($this->request->data)) {
                    $ds->commit();
                    $this->Session->setFlash(__("El Trabajador ha sido actualizado."), "flash_bootstrap");
                    return $this->redirect(array("action" => "index"));
                }
            }
            $ds->rollback();
            $this->Session->setFlash(__("No es posible actualizar el Trabajador."), "flash_bootstrap");
        }
        $this->Trabajador->recursive = 2;
        $trabajador = $this->Trabajador->findByPerDni($Per_DNI);
        $groups = $this->Trabajador->User->Group->find("list", array(
            "conditions" => array("Group.estado" => 1)
        ));
        $trabajadores = $this->Trabajador->find("list_disponibles");
        if (!$trabajador) {
            throw new NotFoundException(__("Trabajador inválido"));
        }
        if (!$this->request->data) {
            $this->request->data = $trabajador;
        }
        $this->set(compact("trabajador", "groups", "trabajadores"));
    }
}
