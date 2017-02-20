<?php
    App::import("Lib", "Calculos");
    $pdf->AddPage();
    
    $pdf->AddFont("Georgia");
    $pdf->AddFont("Georgia", "B");
    
    $pdf->Line(148.5,0, 148.5, 210);
    $iniciales = "";
    if(isset($permiso["User_aprobacion"]["Trabajador"]["nombre_completo"]))
        $iniciales = Calculos::iniciales($permiso["User_aprobacion"]["Trabajador"]["nombre_completo"]);
    else
        $iniciales = "Admin.";
    // Original
    // Header
    $pdf->SetFont("Georgia", "B", 14);
    $pdf->Image("img/logo.jpg", 55, 5);    
    $pdf->Cell(128, 20, utf8_decode("BOLETA DE PERMISO N° " . str_pad($permiso["Permiso"]["nro_boleta"], 4, "0", STR_PAD_LEFT)), 0, 1, "C");
    $pdf->Ln(1);
    
    // Body
    $pdf->SetFont("Georgia", "B",10);
    $pdf->Cell(50, 8, utf8_decode("APELLIDOS Y NOMBRES:"), 0);
    $pdf->SetFont("Georgia", "",10);
    $pdf->MultiCell(78, 8, utf8_decode($permiso["Trabajador"]["nombre_completo"]), 0);
    $pdf->Ln(2);
    
    $y_1 = $pdf->GetY();
    $pdf->SetFont("Georgia", "B",10);
    $pdf->Cell(50, 8, utf8_decode("UNIDAD ORGÁNICA:"), 0);
    $pdf->SetFont("Georgia", "",10);
    $pdf->MultiCell(78, 8, utf8_decode($permiso["Area"]["Are_Descripcion"]), 0);
    $pdf->Ln(2);
    
    $y_2 = $pdf->GetY();
    $pdf->SetFont("Georgia", "B",10);
    $pdf->Cell(50, 8, utf8_decode("FECHA DE PERMISO:"), 0);
    $pdf->SetFont("Georgia", "",10);
    $pdf->MultiCell(78, 8, utf8_decode($permiso["Permiso"]["fecha_permiso"]), 0);
    $pdf->Ln(2);
    
    $y_3 = $pdf->GetY();
    $pdf->SetFont("Georgia", "B",10);
    $pdf->Cell(50, 8, utf8_decode("DESTINO:"), 0);
    $pdf->SetFont("Georgia", "",10);
    $pdf->MultiCell(78, 8, utf8_decode($permiso["Permiso"]["destino"]), 0);
    $pdf->Ln(2);
    
    $y_4 = $pdf->GetY();
    $pdf->SetFont("Georgia", "B",10);
    $pdf->Cell(42, 8, utf8_decode("HORA DE SALIDA:"), 0);
    $pdf->SetFont("Georgia", "",10);
    $pdf->Cell(22, 8, utf8_decode($permiso["Permiso"]["hora_salida"]), 0);

    $pdf->SetFont("Georgia", "B",10);
    $pdf->Cell(42, 8, utf8_decode("HORA DE RETORNO:"), 0);
    $pdf->SetFont("Georgia", "",10);
    $pdf->Cell(22, 8, utf8_decode($permiso["Permiso"]["hora_retorno"]), 0);
    $pdf->Ln(10);
    
    $y_5 = $pdf->GetY();
    $pdf->SetFont("Georgia", "B",10);
    $pdf->Cell(50, 8, utf8_decode("MOTIVO:"), 0);
    $pdf->SetFont("Georgia", "",10);
    $pdf->MultiCell(78, 8, utf8_decode($permiso["Motivo"]["descripcion"]), 0);
    $pdf->Ln(24);
    
    // Footer
    $y_6 = $pdf->GetY();
    $pdf->Cell(68, 8, "", 0);
    $pdf->Cell(60, 8, utf8_decode("Trujillo, " . $this->Time->format($permiso["Permiso"]["created"], "%e de %B del %Y")), 0);
    $pdf->Ln(26);
    
    $y_7 = $pdf->GetY();
    $pdf->Cell(4, 2, "", 0, 0, "C");
    $pdf->Cell(34, 2, "", "B", 0, "C");
    $pdf->Cell(8, 2, "", 0, 0, "C");
    $pdf->Cell(34, 2, "", "B", 0, "C");
    $pdf->Cell(8, 2, "", 0, 0, "C");
    $pdf->Cell(34, 2, "", "B", 0, "C");
    $pdf->Cell(4, 2, "", 0, 1, "C");
    
    $pdf->SetFont("Georgia", "", 8);
    $y_8 = $pdf->GetY();
    $pdf->Cell(42, 8, utf8_decode("JEFE QUE AUTORIZA"), 0, 0, "C");
    $pdf->Cell(42, 8, utf8_decode("JEFE DE R.R.H.H."), 0, 0, "C");
    $pdf->Cell(42, 8, utf8_decode("TRABAJADOR"), 0, 1, "C");
    
    $y_9 = $pdf->GetY();
    $pdf->SetFont("Georgia", "", 9);
    $pdf->Cell(42, 8, "SELLO Y FIRMA", 0, 0, "C");
    $pdf->Cell(42, 8, "SELLO Y FIRMA", 0, 0, "C");
    $pdf->Cell(42, 8, "FIRMA", 0, 1, "C");
    /*
    $y_10 = $pdf->GetY();
    $pdf->Cell(42, 8, utf8_decode($iniciales), 0, 1, "C");
    */
    // Copia
    // Header
    $pdf->SetXY(159, 10);
    
    $pdf->SetFont("Georgia", "B", 14);
    $pdf->Image("img/logo.jpg", 204, 5);    
    $pdf->Cell(128, 20, utf8_decode("BOLETA DE PERMISO N° " . str_pad($permiso["Permiso"]["nro_boleta"], 4, "0", STR_PAD_LEFT)), 0, 1, "C");
    $pdf->Ln(1);
    
    // Body
    $pdf->SetFont("Georgia", "", 11);
    
    $pdf->SetXY(159, 31);
    $pdf->SetFont("Georgia", "B",10);
    $pdf->Cell(50, 8, utf8_decode("APELLIDOS Y NOMBRES:"), 0);
    $pdf->SetFont("Georgia", "", 10);
    $pdf->MultiCell(78, 8, utf8_decode($permiso["Trabajador"]["nombre_completo"]), 0);

    $pdf->SetXY(159, $y_1);
    $pdf->SetFont("Georgia", "B",10);
    $pdf->Cell(50, 8, utf8_decode("UNIDAD ORGÁNICA:"), 0);
    $pdf->SetFont("Georgia", "", 10);
    $pdf->MultiCell(78, 8, utf8_decode($permiso["Area"]["Are_Descripcion"]), 0);
  
    $pdf->SetXY(159, $y_2);
    $pdf->SetFont("Georgia", "B",10);
    $pdf->Cell(50, 8, utf8_decode("FECHA DE PERMISO:"), 0);
    $pdf->SetFont("Georgia", "", 10);
    $pdf->MultiCell(78, 8, utf8_decode($permiso["Permiso"]["fecha_permiso"]), 0);
    $pdf->Ln(2);
    
    $pdf->SetXY(159, $y_3);
    $pdf->SetFont("Georgia", "B",10);
    $pdf->Cell(50, 8, utf8_decode("DESTINO:"), 0);
    $pdf->SetFont("Georgia", "", 10);
    $pdf->MultiCell(78, 8, utf8_decode($permiso["Permiso"]["destino"]), 0);
    $pdf->Ln(2);
    
    $pdf->SetXY(159, $y_4);
    $pdf->SetFont("Georgia", "B",10);
    $pdf->Cell(42, 8, utf8_decode("HORA DE SALIDA:"), 0);
    $pdf->SetFont("Georgia", "", 10);
    $pdf->Cell(22, 8, utf8_decode($permiso["Permiso"]["hora_salida"]), 0);

    $pdf->SetFont("Georgia", "B",10);
    $pdf->Cell(42, 8, utf8_decode("HORA DE RETORNO:"), 0);
    $pdf->SetFont("Georgia", "", 10);
    $pdf->Cell(22, 8, utf8_decode($permiso["Permiso"]["hora_retorno"]), 0);
    $pdf->Ln(10);
    
    $pdf->SetXY(159, $y_5);
    $pdf->SetFont("Georgia", "B", 10);
    $pdf->Cell(50, 8, utf8_decode("MOTIVO:"), 0);
    $pdf->SetFont("Georgia", "", 10);
    $pdf->MultiCell(78, 8, utf8_decode($permiso["Motivo"]["descripcion"]), 0);
    $pdf->Ln(26);
    
    // Footer
    $pdf->SetXY(159, $y_6);
    $pdf->Cell(68, 8, "", 0);
    $pdf->Cell(60, 8, utf8_decode("Trujillo, " . $this->Time->format($permiso["Permiso"]["created"], "%e de %B del %Y")), 0);
    $pdf->Ln(28);
    
    $pdf->SetXY(159, $y_7);
    $pdf->Cell(4, 2, "", 0, 0, "C");
    $pdf->Cell(32, 2, "", "B", 0, "C");
    $pdf->Cell(8, 2, "", 0, 0, "C");
    $pdf->Cell(32, 2, "", "B", 0, "C");
    $pdf->Cell(8, 2, "", 0, 0, "C");
    $pdf->Cell(32, 2, "", "B", 0, "C");
    $pdf->Cell(4, 2, "", 0, 1, "C");
    
    $pdf->SetXY(159, $y_8);
    $pdf->Cell(42, 8, utf8_decode("JEFE QUE AUTORIZA"), 0, 0, "C");
    $pdf->Cell(42, 8, utf8_decode("JEFE DE R.R.H.H."), 0, 0, "C");
    $pdf->Cell(42, 8, utf8_decode("TRABAJADOR"), 0, 1, "C");
    
    $pdf->SetXY(159, $y_9);
    $pdf->SetFont("Georgia", "", 9);
    $pdf->Cell(42, 8, "SELLO Y FIRMA", 0, 0, "C");
    $pdf->Cell(42, 8, "SELLO Y FIRMA", 0, 0, "C");
    $pdf->Cell(42, 8, "FIRMA", 0, 1, "C");
    /*
    $pdf->SetXY(159, $y_10);
    $pdf->Cell(42, 8, utf8_decode($iniciales), 0, 1, "C");  
    */
    if($modo == "descarga") {
        $pdf->Output("Boleta_" . str_pad($permiso["Permiso"]["nro_boleta"], 4, "0", STR_PAD_LEFT) . ".pdf", "D");
    } else {
        $pdf->Output("Boleta_" . str_pad($permiso["Permiso"]["nro_boleta"], 4, "0", STR_PAD_LEFT) . ".pdf", "I");
    }
?>