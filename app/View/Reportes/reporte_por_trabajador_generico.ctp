<?php
    $pdf->SetTopMargin(48);
    $pdf->SetAutoPageBreak(true, 36);
    $pdf->AddPage();
    
    $pdf->AddFont("Georgia");
    $pdf->AddFont("Georgia", "B");
    $pdf->AddFont("Georgia", "BI");
    
    $pdf->SetFont("Georgia", "BU", 14);
    $pdf->title("Reporte de Permisos Genérico");
    
    $pdf->SetFont("Georgia", "", 9);
    $pdf->Cell(19, 8, "Permisos registrados entre el " . $this->Time->format($fecha_inicio, "%e de %B del %Y") . " y el " . $this->Time->format($fecha_cierre, "%e de %B del %Y"));
    $pdf->Ln();
    
    // DNI
    $pdf->SetFont("Georgia", "B", 9);
    $pdf->Cell(40, 8, utf8_decode("DNI:"));
    $pdf->SetFont("Georgia", "", 9);
    $pdf->Cell(40, 8, utf8_decode($trabajador["Trabajador"]["Per_DNI"]));
    $pdf->Ln();
    
    // Nombre completo
    $pdf->SetFont("Georgia", "B", 9);
    $pdf->Cell(40, 8, utf8_decode("Nombre Completo:"));
    $pdf->SetFont("Georgia", "", 9);
    $pdf->Cell(50, 8, utf8_decode($trabajador["Trabajador"]["nombre_completo"]));
    $pdf->Ln();
    
    // Unidad Orgánica
    $pdf->SetFont("Georgia", "B", 9);
    $pdf->Cell(40, 8, utf8_decode("Unidad Orgánica:"));
    $pdf->SetFont("Georgia", "", 9);
    $pdf->Cell(50, 8, utf8_decode($trabajador["Historico_Cargo"]["Area"]["Are_Descripcion"]));
    $pdf->Ln();
    
    if(empty($permisos)) {  
        $pdf->Ln();
        $pdf->SetFont("Georgia", "BI", 10);
        $pdf->Cell(190, 8, utf8_decode("Ningún Permiso Registrado"), 0, 0, "C");
    } else {
        $pdf->SetFont("Georgia", "B", 9);

        $pdf->SetFillColor(28, 63, 119);
        $pdf->SetTextColor(255, 255, 255);

        $pdf->Cell(18, 8, utf8_decode("N° Boleta"), 1, 0, "C", true);
        $pdf->Cell(18, 8, utf8_decode("Fecha"), 1, 0, "C", true);
        $pdf->Cell(18, 8, utf8_decode("Salida"), 1, 0, "C", true);
        $pdf->Cell(18, 8, utf8_decode("Retorno"), 1, 0, "C", true);
        $pdf->Cell(86, 8, utf8_decode("Destino"), 1, 0, "C", true);
        $pdf->Cell(32, 8, utf8_decode("Motivo"), 1, 0, "C", true);
        $pdf->Ln();

        $pdf->SetFont("Georgia", "", 9);
        $pdf->SetTextColor(0, 0, 0);
        // nro boleta
        // fecha permiso
        // hora salida
        // hora retorno
        // destino
        // motivo
        $par = true;
        foreach($permisos as $permiso) {
            if($par) $pdf->SetFillColor(250, 250, 250);
            else $pdf->SetFillColor(228, 238, 248);
            $pdf->Cell(18, 8, utf8_decode(str_pad($permiso["Permiso"]["nro_boleta"], 4, "0", STR_PAD_LEFT)), 1, 0, "R", true);
            $pdf->Cell(18, 8, utf8_decode($permiso["Permiso"]["fecha_permiso"]), 1, 0, "C", true);
            $pdf->Cell(18, 8, utf8_decode($permiso["Permiso"]["hora_salida"]), 1, 0, "C", true);
            $pdf->Cell(18, 8, utf8_decode($permiso["Permiso"]["hora_retorno"]), 1, 0, "C", true);
            $pdf->Cell(86, 8, utf8_decode(substr($permiso["Permiso"]["destino"], 0, 45)), 1, 0, "C", true);
            $pdf->Cell(32, 8, utf8_decode(substr($permiso["Motivo"]["descripcion"], 0, 27)), 1, 0, "C", true);
            $pdf->Ln();
            $par = !$par;
        }
    }
    $pdf->Output("Reporte_Generico_" . $trabajador["Trabajador"]["Per_DNI"] . ".pdf", "D");
?>