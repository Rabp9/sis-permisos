<?php

/**
 * CakePHP PermisosController
 * @author Roberto Bocanegra Palacios
 */

App::uses('AppController', 'Controller');

class PermisosController extends AppController {
    public $uses = array("Permiso", "User", "Config");
    public $components = array('Paginator');
    public $paginate = [
        "limit" => 10,
        "order" => [
            "Permiso.id" => "desc"
        ]
    ];
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow("supervizar", "retorno", "cierre");
    }
    
    public function index() {
        $this->layout = "main";
        
        $user = $this->Auth->user();
        $this->paginate["conditions"] = array("Permiso.Per_DNI" => $user["Per_DNI"]);
        $this->Paginator->settings = $this->paginate;
        $permisos = $this->Paginator->paginate();
        $this->set('permisos', $this->paginate());
    }
    
    public function lista() {
        $this->layout = "main";
        
        $user = $this->Auth->user();
        $group = $this->User->Group->findById($user["group_id"]);
        if($group["Group"]["descripcion"] == "Aprobador" || $group["Group"]["descripcion"] == "GAFS") {
            $this->paginate["findType"] = "hijos";
            $this->paginate["Per_DNI"] = $user["Per_DNI"];
        }
        
        
        // FILTRO
        if($this->request->is("get")) {
            $filtro = $this->Session->read('filtro');
            if($filtro != null ) {
                $this->paginate["conditions"]["Permiso.estado"] = $filtro;
                $this->Session->write('filtro', $filtro);
                $this->set('filtro', $filtro);
            }
        }
        if($this->request->is("post")) {
            $busqueda = $this->request->data["Permiso"]["busqueda"];
            if($busqueda != "") {
                $this->paginate["conditions"]["Permiso.nro_boleta"] = $busqueda;
                $this->request->data["Permiso"]["busqueda"] = "";
                $this->request->data["Permiso"]["filtro"] = "";
                $this->set("respuesta", "Resultados de la búsqueda: N° de Boleta " . $busqueda);
            }
            if(!empty($this->request->data["Permiso"]["filtro"])) {
                $filtro = $this->request->data["Permiso"]["filtro"];
                $this->paginate["conditions"]["Permiso.estado"] = $filtro;
                $this->Session->write('filtro', $filtro);
                $this->set('filtro', $filtro);
            } else {
                $this->Session->write('filtro', null);
            }
        }
        // FIN FILTRO
        
        $this->Paginator->settings = $this->paginate;
        $permisos = $this->Paginator->paginate();
        
        $hora_entrada = $this->Config->findByClave("hora_entrada");
        $hora_salida = $this->Config->findByClave("hora_salida");
        
        $this->set('permisos', $this->paginate());
        $this->set(compact("hora_entrada", "hora_salida"));
    }

    public function view($id = null) {
        $this->layout = "main";
        
        if (!$this->Permiso->exists($id)) {
            throw new NotFoundException(__('El Permiso no existe'));
        }
        $this->Permiso->recursive = 3;
        $permiso = $this->Permiso->findById($id);
        $admin = $this->Auth->user()["Group"]["descripcion"] == "Administrador";
        $this->set(compact("permiso", "admin"));
    }
    
    public function viewlista($id = null) {
        $this->layout = "main";
        
        if (!$this->Permiso->exists($id)) {
            throw new NotFoundException(__('El Permiso no existe'));
        }
        $this->Permiso->recursive = 3;
        $permiso = $this->Permiso->findById($id);
        $admin = $this->Auth->user()["Group"]["descripcion"] == "Administrador";
        $this->set(compact("permiso", "admin"));
    }
       
    public function register($Per_DNI = null) {
        $this->layout = "main";
        
        $this->Permiso->create();
        if ($this->request->is('post')) {
            $trabajador = $this->Permiso->Trabajador->findByPerDni($this->request->data["Permiso"]["Per_DNI"]);
            $this->request->data["Permiso"]["Are_Codigo"] = $trabajador["Historico_Cargo"]["Are_Codigo"];
            if($this->Permiso->save($this->request->data)) {
                $this->Session->setFlash(__('El Permiso ha sido registrado correctamente'), "flash_bootstrap");
                return $this->redirect(['action' => 'index']);
            } else {
            $this->Session->setFlash(__("No fue posible registrar al Permiso."), "flash_bootstrap");
            }
        }
        $this->Permiso->Trabajador->recursive = -1;
        if($Per_DNI == null) {
            $Per_DNI = $this->Auth->user()["Per_DNI"];
        }
        $trabajador = $this->Permiso->Trabajador->findByPerDni($Per_DNI);
        $this->Session->write("Trabajador.DNI", $Per_DNI);
        $motivos = $this->Permiso->Motivo->find("list", array(
           "conditions" => array("Motivo.estado" => 1) 
        ));
        $hora_entrada = $this->Config->findByClave("hora_entrada");
        $hora_salida = $this->Config->findByClave("hora_salida");
        $this->set(compact("permiso", "motivos", "trabajador", "hora_entrada", "hora_salida"));
    }
    
    public function aprobar($id) {
        if ($this->request->is("get")) {
            throw new MethodNotAllowedException();
        }
        $this->Permiso->id = $id;
        $data = array(
            "Permiso" => array(
                "hora_registro_aprobacion" => date("Y-m-d H:i:s"),
                "estado" => 2,
                "Usu_Codigo_aprobacion" => $this->Auth->user()["Usu_Codigo"]
            )
        );
        if ($this->Permiso->save($data)) {
            $this->Session->setFlash(__("El Permiso de código: %s ha sido Aprobado.", h($id)), "flash_bootstrap");
            return $this->redirect(array("action" => "lista"));
        }
    }
    
    public function denegar($id) {
        if ($this->request->is("get")) {
            throw new MethodNotAllowedException();
        }
        $this->Permiso->id = $id;
        $data = array(
            "Permiso" => array(
                "hora_registro_aprobacion" => date("Y-m-d H:i:s"),
                "estado" => 3,
                "Usu_Codigo_aprobacion" => $this->Auth->user()["Usu_Codigo"]
            )
        );
        if ($this->Permiso->save($data)) {
            $this->Session->setFlash(__("El Permiso de código: %s ha sido denegado.", h($id)), "flash_bootstrap");
            return $this->redirect(array("action" => "lista"));
        }
    }
    
    public function retorno() {
        $id = $this->request->data["Permiso"]["id"];
        $modo = $this->request->data["Permiso"]["modo"] == "" ? "lista" : "supervizar";
        $this->Permiso->id = $id;
        $data = array(
            "Permiso" => array(
                "hora_registro_retorno" => date("Y-m-d H:i:s"),
                "estado" => 4,
                "Usu_Codigo_retorno" => $this->Auth->user()["Usu_Codigo"],
                "nro_boleta" => $this->Permiso->nextNroBoleta()
            )
        );
        $data = Set::pushDiff($data, $this->request->data);
        if ($this->Permiso->save($data)) {
            $this->Session->setFlash(__("Se registró la hora de retorno correctamente en el Permiso de código: %s.", h($id)), "flash_bootstrap_link", array(
                "link_text" => "Generar Boleta",
                "link_url" => array(
                    "controller" => "Reportes",
                    "action" => "boleta", $id, "descarga"
                )
            ));
            return $this->redirect(array("action" => $modo));
        }
    }
    
    public function permisosPendientes() {
        if (empty($this->request->params['requested'])) {
            throw new ForbiddenException();
        }
        $user = $this->Auth->user();
        $group = $this->User->Group->findById($user["group_id"]);
        $permisos = null;
        if($group["Group"]["descripcion"] == "Aprobador") {
            $permisos = $this->Permiso->find("hijos", array(
                "Per_DNI" => $user["Per_DNI"],
                "conditions" => array("Permiso.estado" => 1),
                "order" => array("Permiso.fecha_permiso" => "DESC")
            ));
        }
        return $permisos;
    }
    
    public function supervizar() {
        $this->layout = "supervizar";
        
        $hora_entrada = $this->Config->findByClave("hora_entrada");
        $hora_salida = $this->Config->findByClave("hora_salida");
        
        $this->paginate["conditions"]["Permiso.fecha_permiso"] = date("Y-m-d");
        $this->Paginator->settings = $this->paginate;
        $permisos = $this->Paginator->paginate();
        $this->set('permisos', $this->paginate());
        $this->set(compact("hora_entrada", "hora_salida"));
    }
    
    public function cierre() {
        $permisos = $this->Permiso->find("all", array(
           "conditions" => array("Permiso.estado" => 2) 
        ));
        $r = true;
        $ds = $this->Permiso->getDataSource();
        $nro_boleta = $this->Permiso->nextNroBoleta();
        $ds->begin();
        foreach($permisos as $permiso) {
            $id = $permiso["Permiso"]["id"];
            $this->Permiso->id = $id;
            $data = array(
                "Permiso" => array(
                    "hora_retorno" => "16:30",
                    "hora_registro_retorno" => date("Y-m-d H:i:s"),
                    "estado" => 4,
                    "Usu_Codigo_retorno" => null,
                    "nro_boleta" => $nro_boleta
                )
            );
            if(!$this->Permiso->save($data)) {
                $r = false;
            }
            $nro_boleta++;
        }
        if($r) {
            $ds->commit();
        }
        return $this->redirect(array("action" => "supervizar"));
    }
    
    public function delete_retorno($id) {
        if ($this->request->is("get")) {
            throw new MethodNotAllowedException();
        }
        // $this->Permiso->id = $id;
        $data = array(
            "nro_boleta" => null,
            "hora_retorno" => null,
            "hora_registro_retorno" => null,
            "Usu_Codigo_retorno" => null,
            "estado" => 2
        );
        if($this->Permiso->updateAll($data, array("id" => $id))) {
            $this->Session->setFlash(__("El registro de retorno del Permiso de código: %s ha sido eliminado.", h($id)), "flash_bootstrap");
            return $this->redirect(array("action" => "lista"));
        }
        $this->Session->setFlash(__("El registro de retorno del Permiso de código: %s no ha sido eliminado.", h($id)), "flash_bootstrap");
        return $this->redirect(array("action" => "lista"));
    }
}