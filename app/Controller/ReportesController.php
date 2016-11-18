<?php

/**
 * CakePHP ReportesController
 * @author Roberto Bocanegra Palacios
 */

App::import("Lib", "PDF");

class ReportesController extends AppController {
    public $uses = array("Permiso", "Trabajador");
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow("boleta");
    }
    
    public function general() {
        $this->layout = "main";
        
        if ($this->request->is('post')) {
            $this->layout = 'pdf'; //this will use the pdf.ctp layout
        
            $pdf = new PDF("L");
            $pdf->header_n_footer = true;

            // Inicialización de variables
            $this->Permiso->recursive = 3;
            $fecha_inicio = $this->request->data["Reporte"]["fecha_inicio"];
            $fecha_cierre = $this->request->data["Reporte"]["fecha_cierre"];
            $categoria_laboral = $this->request->data["Reporte"]["categoria_laboral"];
            
            // Recuperación de información
            $permisos = $this->Trabajador->find("reporte", array(
                "fecha_inicio" => $fecha_inicio,
                "fecha_cierre" => $fecha_cierre,
                "categoria_laboral" => $categoria_laboral
            ));
            // Salida de la Información
            $this->set(compact("permisos", "pdf", "fecha_inicio", "fecha_cierre"));

            $this->response->type("application/pdf");
            
            return $this->render("reporte_general");
        }
    }
    
    public function porTrabajador() {
        $this->layout = "main";
        
        if ($this->request->is('post')) {
            $this->layout = 'pdf'; //this will use the pdf.ctp layout
        
            $pdf = new PDF("P");
            $pdf->header_n_footer = true;

            // Inicialización de variables
            $this->Permiso->recursive = 3;
            $fecha_inicio = $this->request->data["Reporte"]["fecha_inicio"];
            $fecha_cierre = $this->request->data["Reporte"]["fecha_cierre"];
            $Per_DNI = $this->request->data["Reporte"]["Per_DNI"];
            $tipo = $this->request->data["Reporte"]["tipo"];
            // Recuperación de información
            $permisos = $this->Permiso->find("all", array(
                "conditions" => array(
                    "Permiso.estado" => 4,
                    "Permiso.Per_DNI" => $Per_DNI,
                    "Permiso.fecha_permiso between ? and ?" => array($fecha_inicio, $fecha_cierre)
                ),
                "order" => array("Permiso.nro_boleta ASC")
            ));
            $this->Trabajador->recursive = 2;
            $trabajador = $this->Trabajador->findByPerDni($Per_DNI);
            // Salida de la Información
            $this->set(compact("permisos", "pdf", "fecha_inicio", "fecha_cierre", "trabajador"));

            $this->response->type("application/pdf");
            $render = "";
            if($tipo == "detallado")
                $render = "reporte_por_trabajador_detallado";
            else
                $render = "reporte_por_trabajador_generico";
            return $this->render($render);
        }
        $trabajadores = $this->Trabajador->find("list_disponibles");
        $this->set(compact("trabajadores"));
    }

    public function boleta($id, $modo) {
        $this->layout = 'pdf'; //this will use the pdf.ctp layout
        
        $pdf = new PDF("L");
        $pdf->header_n_footer = false;
        
        // Inicialización de variables
        $this->Permiso->recursive = 3;
        // Recuperación de información
        $permiso = $this->Permiso->findById($id);
        // Salida de la Información
        $this->set(compact("permiso", "pdf", "modo"));
        
        $this->response->type("application/pdf");
    }
}
