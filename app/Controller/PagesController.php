<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {
    public $uses = array("Config");
    
    public function home() {
        $this->layout = "main";
    }
    
    public function config() {
        $this->layout = "main";
        
        if($this->request->is(array("post"))) {
            $this->Config->query('TRUNCATE table Permiso.Config');
            if ($this->Config->saveMany($this->request->data)) {
                $this->Session->setFlash(__("La Configuración ha sido registrada correctamente."), "flash_bootstrap");
            } else {
                $this->Session->setFlash(__("La Configuración no pudo ser registrada correctamente."), "flash_bootstrap");
            }
        }
        if (!$this->request->data) {
            $config = $this->Config->find("all");
            // Hora de Entrada
            $this->request->data[0]["Config"]["valor"] = $config[0]["Config"]["valor"];
            // Hora de Salida
            $this->request->data[1]["Config"]["valor"] = $config[1]["Config"]["valor"];
        }
    }
}
