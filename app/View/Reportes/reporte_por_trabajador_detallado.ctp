<?php
    $pdf->SetTopMargin(48);
    $pdf->SetAutoPageBreak(true, 36);
    $pdf->AddPage();
    
    $pdf->AddFont("Georgia");
    $pdf->AddFont("Georgia", "B");
    $pdf->AddFont("Georgia", "BI");
    
    $pdf->SetFont("Georgia", "BU", 14);
    $pdf->title("Reporte de Permisos Detallado");
    
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
    }
    foreach($permisos as $permiso) {
        // Header
        $pdf->SetFont("Georgia", "B", 9);
        $pdf->SetFillColor(28, 63, 119);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(190, 8, utf8_decode("BOLETA DE PERMISO N° " . str_pad($permiso["Permiso"]["nro_boleta"], 4, "0", STR_PAD_LEFT)), 1, 0, "C", true);
        $pdf->Ln();
        
        $pdf->SetTextColor(0, 0, 0);
        
        // Fecha de Permiso
        $pdf->SetFont("Georgia", "B", 9);
        $pdf->Cell(40, 8, utf8_decode("FECHA DE PERMISO:"), "L");
        $pdf->SetFont("Georgia", "", 9);
        $pdf->Cell(150, 8, utf8_decode($permiso["Permiso"]["fecha_permiso"]), "R");
        $pdf->Ln();
        
        // Destino
        $pdf->SetFont("Georgia", "B", 9);
        $pdf->Cell(40, 8, utf8_decode("DESTINO:"), "L");
        $pdf->SetFont("Georgia", "", 9);
        $pdf->Cell(150, 8, utf8_decode($permiso["Permiso"]["destino"]), "R");
        $pdf->Ln();
        
        // Hora de Salida
        $pdf->SetFont("Georgia", "B", 9);
        $pdf->Cell(40, 8, utf8_decode("HORA DE SALIDA:"), "L");
        $pdf->SetFont("Georgia", "", 9);
        $pdf->Cell(150, 8, utf8_decode($permiso["Permiso"]["hora_salida"]), "R");
        $pdf->Ln();
        
        // Hora de Retorno
        $pdf->SetFont("Georgia", "B", 9);
        $pdf->Cell(40, 8, utf8_decode("HORA DE RETORNO:"), "L");
        $pdf->SetFont("Georgia", "", 9);
        $pdf->Cell(150, 8, utf8_decode($permiso["Permiso"]["hora_retorno"]), "R");
        $pdf->Ln();
        
        // Motivo
        $pdf->SetFont("Georgia", "B", 9);
        $pdf->Cell(40, 8, utf8_decode("MOTIVO:"), "L");
        $pdf->SetFont("Georgia", "", 9);
        $pdf->Cell(150, 8, utf8_decode($permiso["Motivo"]["descripcion"]), "R");
        $pdf->Ln();
        
        // Descuento
        $pdf->SetFont("Georgia", "B", 9);
        $pdf->Cell(40, 8, utf8_decode("DESCUENTO:"), "LB");
        $pdf->SetFont("Georgia", "", 9);
        $pdf->Cell(150, 8, utf8_decode($permiso["Motivo"]["descuento_view"]), "RB");

        $pdf->Ln(20);
    }
    
    $pdf->Output("Reporte_Detallado_" . $trabajador["Trabajador"]["Per_DNI"] . ".pdf", "D");
?>