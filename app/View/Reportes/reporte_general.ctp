<?php
    $pdf->SetTopMargin(45);
    $pdf->AddPage();
    
    $pdf->AddFont("Georgia");
    $pdf->AddFont("Georgia", "B");
    
    $pdf->SetFont("Georgia", "BU", 14);
    $pdf->title("Reporte de Permisos");
    
    $pdf->SetFont("Georgia", "", 9);
    $pdf->Cell(19, 10, "Permisos registrados entre el" . $this->Time->format($fecha_inicio, "%e de %B del %Y") . " y el " . $this->Time->format($fecha_cierre, "%e de %B del %Y"));
    
    $pdf->ln();
    
    $pdf->SetFont("Georgia", "B", 9);
    
    $pdf->SetFillColor(28, 63, 119);
    $pdf->SetTextColor(255, 255, 255);
    
    $pdf->Cell(29, 8, utf8_decode("DNI"), 1, 0, "C", true);
    $pdf->Cell(78, 8, utf8_decode("Nomobre Completo"), 1, 0, "C", true);
    //$pdf->Cell(66, 8, utf8_decode("Unidad Orgánica"), 1, 0, "C", true);
    $pdf->Cell(63, 8, utf8_decode("N° Permisos / Tiempo Total"), 1, 0, "C", true);
    $pdf->Cell(94, 8, utf8_decode("N° Permisos (Descuento) / Tiempo Total (Descuento)"), 1, 0, "C", true);
    $pdf->Ln();
    
    $pdf->SetFont("Georgia", "", 9);
    $pdf->SetTextColor(0, 0, 0);
    
    $par = true;
    foreach($permisos as $permiso) {
        if($par) $pdf->SetFillColor(250, 250, 250);
        else $pdf->SetFillColor(228, 238, 248);
        $pdf->Cell(29, 8, utf8_decode($permiso["Trabajador"]["Per_DNI"]), 1, 0, "L", true);
        $pdf->Cell(78, 8, utf8_decode(substr($permiso["Trabajador"]["nombre_completo"], 0, 33)), 1, 0, "L", true);
        //$pdf->Cell(66, 8, utf8_decode(substr($permiso["Permiso"]["Area"]["Are_Descripcion"], 0, 33)), 1, 0, "L", true);
        $pdf->Cell(63, 8, utf8_decode(sizeof($permiso["Permiso"]) . " / " . $permiso["tiempo_total"]), 1, 0, "C", true);
        $pdf->Cell(94, 8, utf8_decode(sizeof($permiso["descuento_detalle"]) . " / " . $permiso["descuento_total"]), 1, 0, "C", true);
        $pdf->Ln();
        $par = !$par;
    }
    
    $pdf->Output("Reporte_general.pdf", "D");
?>