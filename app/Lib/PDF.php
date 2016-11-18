<?php
/**
 * CakePHP ReportesController
 * @author admin
 */
App::import("Vendor", "Fpdf", array("file" => "fpdf/fpdf.php"));

class PDF extends FPDF {
    private $cabecera_p = array(
        "imagen" => "img/cabecera_p.jpg",
        "left" => 0,
        "top" => 12,
        "width" => "",
        "height" => ""
    );
    
    private $pie_p = array(
        "imagen" => "img/pie_p.jpg",
        "left" => 3,
        "top" => 254,
        "width" => 198,
        "height" => 48
    );
   
    private $cabecera_l = array(
        "imagen" => "img/cabecera_l.jpg",
        "left" => 0,
        "top" => 14,
        "width" => "",
        "height" => ""
    );
    
    private $pie_l = array(
        "imagen" => "img/pie_l.jpg",
        "left" => 3,
        "top" => 165,
        "width" => 285,
        "height" => 48
    );
    
    public $header_n_footer;
    
    public function Header() {
        if($this->h > $this->w) { // Portrait
            $cabecera = $this->cabecera_p;
        } elseif($this->w > $this->h) { // Landscape
            $cabecera = $this->cabecera_l;
        }
        if($this->header_n_footer)
            $this->Image($cabecera["imagen"], 
                $cabecera["left"],
                $cabecera["top"],
                $cabecera["width"],
                $cabecera["height"]
            );
    }
    public function Footer() {
        if($this->h > $this->w) { // Portrait
            $pie = $this->pie_p;
        } elseif($this->w > $this->h) { // Landscape
            $pie = $this->pie_l;
        }
        if($this->header_n_footer)
            $this->Image($pie["imagen"], 
                $pie["left"],
                $pie["top"],
                $pie["width"],
                $pie["height"]
            );
    }
    
    public function title($title) {
        $n = $this->GetStringWidth($title);
        $x = ceil(($this->w - $n) / 2) - 1;
        $this->Text($x,42.5, utf8_decode($title));
    }
    
    public function subtitle($subtitle) {
        $this->SetFont("Georgia", "B", 11);
        $this->SetFillColor(230, 230, 230);
        $this->Cell($this->w - ($this->lMargin + $this->rMargin), 6, utf8_decode($subtitle), 1, 0   , "", true);
        $this->SetFont("Georgia", "", 11);
    }
    
    public function content($content) {
        $content_w = 0;
        $this->SetFont("Georgia", "", 11);
        foreach($content as $i => $dato) {
            if($i == (sizeof($content) - 1) && $i == 0){
                $dato_w = $this->w - ($this->lMargin + $this->rMargin);
                $this->Cell($dato_w, 6, utf8_decode($dato), 1);
            }
            elseif($i == (sizeof($content) - 1)) {
                $dato_w = $this->GetStringWidth($dato) + 2;
                $this->Cell($dato_w, 6, utf8_decode($dato), "TB");
                $content_w += $dato_w;
                $last_dato_w = ($this->w - ($this->lMargin + $this->rMargin)) - $content_w;
                $this->Cell($last_dato_w, 6, "", "TBR");
            } elseif($i == 0) {
                $dato_w = $this->GetStringWidth($dato) + 2;
                $this->Cell($dato_w, 6, utf8_decode($dato), "LTB");
                $this->Cell(10, 6, "", "TB");
                $content_w += $dato_w + 10;
            } else {
                $dato_w = $this->GetStringWidth($dato) + 2;
                $this->Cell($dato_w, 6, utf8_decode($dato), "TB");
                $this->Cell(10, 6, "", "TB");
                $content_w += $dato_w + 10;
            }
        }    
    }
    
    public function table($cabeceras, $info, $columns) {
        $this->SetFont("Georgia", "B", 11);
        $this->SetFillColor(230, 230, 230);
        foreach($cabeceras as $cabecera) {
            $this->Cell($cabecera["width"], 6, utf8_decode($cabecera["descripcion"]), 1, 0, "",true);
        }
        
        $this->ln();
        $this->SetFont("Georgia", "", 11);
        $par_impar = true;
        $n_data = sizeof($info);
        
        foreach($info as $k_data => $data) {
            if($par_impar) $this->SetFillColor(250, 250, 250);
            else $this->SetFillColor(228, 238, 248);
            $borders = $n_data == $k_data + 1 ? "LRB" : "LR";
            
            foreach($columns as $k_column => $column) {
                $this->Cell($cabeceras[$k_column]["width"], 6, utf8_decode($data[$column]), $borders, 0, "", true);
            }
            
            $this->ln();
            $par_impar = !$par_impar;
        }
    }
}
?>