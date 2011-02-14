<?

require_once('fpdf.php');

class TablaCompPDF extends FPDF
{

		
	function tablaGruposEtiquetaDato ( $arrayDatos, $x, $y, $ancho) {
		
		$this->SetY($y);
		
		$contador = 0;		
		foreach ( $arrayDatos as $datosGrupo ) {
			$this -> _grupoEtiquetaDato ($x, $ancho, $datosGrupo, $contador == 0);
			$contador ++;			
		}
		
		
		$alturaRect = $this->GetY() - $y;
		$anchoRect = $ancho;
		$this->RoundedRect($x, $y, $anchoRect, $alturaRect, 4 );
		return $this->GetY();
	}

	function _grupoEtiquetaDato ($x, $ancho, $arrayCampos , $primero = false) {
		
		$altura = 6; // Expresado en mm
		$anchosCalculados = array();
		$borde = ($primero ? '' : 'T');
		
		$anchoLinea = 0;
		foreach ($arrayCampos as $etiqueta => $valor) {
			$this->SetFont('Arial','B',8);
			$anchoLinea += max ($this->_dameAncho($valor) , $this->_dameAncho($etiqueta));
		}
		
		$proporcion = ($ancho / $anchoLinea);
		
		
		$this->SetX($x);
		$contador = 0;
		foreach ($arrayCampos as $etiqueta => $valor ) {
			$this->SetTextColor(0);
			$this->SetFont('Arial','B',8);
			$miAncho =  $proporcion * max ($this->_dameAncho($valor) , $this->_dameAncho($etiqueta));
			$anchosCalculados[$etiqueta] = $miAncho;
			
			$this->Cell($miAncho, $altura, utf8_decode($etiqueta), ($contador > 0 ? "L${borde}" : $borde) ,0,'C');
			$contador ++;
		}
		
		$this->Ln($altura);
		
		$this->SetX($x);
		$borde = 'T';
		$contador = 0;
		foreach ($arrayCampos as $etiqueta => $valor) {
			
			$this->SetTextColor(127, 127, 127);
			$this->SetFont('Arial','',8);
			$miAncho = $anchosCalculados[$etiqueta];
			$this->Cell($miAncho, $altura, utf8_decode($valor), ($contador > 0 ? "L${borde}" : $borde) , 0,'C');
			$contador ++;
		}
		$this->Ln($altura);
	}


	function tablaEtiquetaDato ( $arrayDatos , $x , $y, $ancho, $alto = 0, $alineado = 'L')
	{
		$this->SetY($y);
		$longitudes = array ();
		foreach ($arrayDatos as $etiqueta => $dato) {
			$this->_lineaEtiquetaDato($x, $longitudes, $ancho, 
						  $etiqueta,  $dato, $alineado);	
			
		}
		
		
		$alturaRect = $this->GetY() - $y;
		
		if ($alto != 0) {
			$alturaRect = $alto;
		}
		$anchoRect = $ancho ;
		$this->RoundedRect($x, $y, $anchoRect, $alturaRect, 4 );
		
		return $this->GetY();
	}


	function _lineaEtiquetaDato ($x, &$longitudes, $ancho,  $etiqueta, $dato, $alineado) {
		
		$altura = 6; 
		$interlineado = 5;
		$anchoEtiqueta = 27;
		$anchoDatos = $ancho - $anchoEtiqueta;
		if ($alineado == 'R') {
			$anchoDatos = 16;
		}
		
		$this->SetX($x + 1);
		$this->SetTextColor(0);
		$this->SetFont('Arial','B',8);
		$this->Cell($anchoEtiqueta, $altura, utf8_decode($etiqueta),0,0,'R');
		$this->SetTextColor(127, 127, 127);
		$this->SetFont('Arial','',8);
		$this->Cell( $anchoDatos, $altura , utf8_decode($dato) , 0, 0, $alineado);
		array_push($longitudes, ($this->_dameAncho($dato) + $anchoEtiqueta));
		$this->Ln($interlineado);
		
	}

	
	
	function tablaFilas ( $arrayDatos , $arrayCabeceras , $totalTitulo, $total, $x , $y)
	{
		$this->SetY($y);
	
		$contador = 0;
		$altura = 6;
		
		$this->_filaCabecera ($x, $arrayCabeceras);
		
		foreach ($arrayDatos as $fila) {
			//$this->_filaDato($x, $fila, $arrayCabeceras, $contador == 0, $contador);	
			$this->_filaDato($x, $fila, $arrayCabeceras, $contador);	
			$contador = $contador + 1;
		}
		$alturaRect = $this->GetY() - $y;
		$anchoRect = array_sum($arrayCabeceras) ;
		$this->RoundedRect($x, $y, $anchoRect, $alturaRect, 4 , '' , '124');
		
		
		$this->SetX($x);
		$this->SetTextColor(0, 0, 0);
		$this->SetFont('Arial','B', 8);
		$this->Cell ($anchoRect - 30 , $altura , utf8_decode($totalTitulo), 0 , 0 , 'R');
		$this->SetFont('Arial','', 8);
		$this->Cell (30 , $altura , utf8_decode($total), 'LRTB' , 0 , 'R');
		$this->ln($altura);
		
		return $this->GetY();
	}
	
	
	function _filaCabecera ($x, $cabeceras) {
		
		$altura = 6; // Expresado en mm
		$borde = 'B';
		
		$this->SetX($x);
		$contador = 0;
		foreach ($cabeceras as $etiqueta => $ancho) {
			$this->SetTextColor(0, 0, 0);
			$this->SetFont('Arial','B',8);
			$this->Cell($ancho, $altura, $etiqueta, ($contador > 0 ? "L${borde}" : $borde) , 0,'C');
			$contador ++;
		}
		$this->Ln($altura);
	}
	
	
	
	function _filaDato ($x, $fila, $anchos, $contadorLinea) {
		
		$altura = 6; // Expresado en mm
		$borde = '';
		
		$this->SetX($x);
		$contador = 0;
		foreach ($fila as $etiqueta => $valor) {
			
			$this->SetTextColor(127, 127, 127);
			$this->SetFillColor(177, 177, 177);
			$this->SetFont('Arial','',8);
			$miAncho = $anchos[$etiqueta];
			$this->Cell($miAncho, $altura, utf8_decode($valor), ($contador > 0 ? "${borde}" : $borde) , 0,'C', ($contadorLinea % 2 == 0 ? "F" : "") );
			$contador ++;
		}
		$this->Ln($altura);
		
	}
	
	
	function tablaFilasGrupo ( $titulo, $descripcion, $totales  , $x , $y , $ancho)
	{
		$this->SetY($y);

		$contador = 0;
		$altura = 6;

		$this->SetX($x + 3);
		$this->SetTextColor(0, 0, 0);
		$this->SetFont('Arial','B', 8);
		$this->Cell ($ancho , $altura , utf8_decode($titulo));
		$this->ln($altura);

		$this->SetFont('Arial','', 8);
		$this->SetTextColor(127, 127, 127);
		$this->SetX($x + 2);
		$this->MultiCell ($ancho - 4, $altura , utf8_decode($descripcion));
		$this->ln($altura);
		
		$alturaRect = $this->GetY() - $y;
		$anchoRect = $ancho;
		$this->RoundedRect($x, $y, $anchoRect, $alturaRect, 4 , '' , '124');
		
		
		foreach ($totales as $totalTitulo => $total) {
		
			$this->SetX($x);
			$this->SetTextColor(0, 0, 0);
			$this->SetFont('Arial','B', 8);
			$this->Cell ($ancho - 30 , $altura , utf8_decode($totalTitulo), 0 , 0 , 'R');
			$this->SetFont('Arial','', 8);
			$this->Cell (30 , $altura , utf8_decode($total), 'LRTB' , 0 , 'R');
			$this->ln($altura);
		}
		
		return $this->GetY();
	}
	
	
	
	

	function  tablaDeFichero ($titulo, $fichero, $x , $y, $ancho )
	{
		

		
		$this->SetY($y);
		$this->SetX($x + 1);
		$this->SetFont('Arial','B',5);
		$this->Cell ($ancho , 4 , utf8_decode($titulo));
		$this->Ln(4);
		$this->SetFont('Arial','B',4);
		$lineas=file($fichero);
		$data=array();
		foreach($lineas as $linea) {
		    $this->SetX($x);	
		    $this->MultiCell ($ancho , 4 , utf8_decode($linea));
		}

		$alturaRect = $this->GetY() - $y;
		$anchoRect = $ancho + 1;
		$this->RoundedRect($x - 1, $y, $anchoRect, $alturaRect, 4 );
		return $this->GetY();
        }


        function  tablaVacia ($titulo, $x , $y, $ancho, $altura )
	   {
		

		$this->SetFont('Arial','B', 4);
		$this->SetY($y);
		$this->SetX($x + 1);	
		$this->Cell ($ancho , 4 , utf8_decode($titulo));
		$this->Ln(4);

		$alturaRect = $altura;
		$anchoRect = $ancho + 1;
		$this->RoundedRect($x, $y, $anchoRect, $alturaRect, 4 );
		return $this->GetY();
        }
        
       function  tablaSimple ($titulo, $texto,  $x , $y, $ancho, $altura )
	   {
		

		$this->SetFont('Arial','B', 4);
		$this->SetY($y);
		$this->SetX($x + 1);	
		$this->Cell ($ancho , 4 , utf8_decode($titulo));
		$this->Ln(4);
		$this->SetFont('Arial','B', 10);
		$this->SetX($x + 1);	
		$this->Cell ($ancho , 4 , utf8_decode($texto), 0, 0, 'C');
		$alturaRect = $altura;
		$anchoRect = $ancho + 1;
		$this->RoundedRect($x, $y, $anchoRect, $alturaRect, 4 );
		return $this->GetY();
        }

	function _dameAncho ($texto) {
		return $this->GetStringWidth($texto) * 1.10;
	}
	

	function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234')
	{
		$this->SetDrawColor(0,0,0);
	    $k = $this->k;
	    $hp = $this->h;
	    if($style=='F')
		$op='f';
	    elseif($style=='FD' or $style=='DF')
		$op='B';
	    else
		$op='S';
	    $MyArc = 4/3 * (sqrt(2) - 1);
	    $this->_out(sprintf('%.2f %.2f m', ($x+$r)*$k, ($hp-$y)*$k ));
    
	    $xc = $x+$w-$r;
	    $yc = $y+$r;
	    $this->_out(sprintf('%.2f %.2f l', $xc*$k, ($hp-$y)*$k ));
	    if (strpos($angle, '2')===false)
		$this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k, ($hp-$y)*$k ));
	    else
		$this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
    
	    $xc = $x+$w-$r;
	    $yc = $y+$h-$r;
	    $this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k, ($hp-$yc)*$k));
	    if (strpos($angle, '3')===false)
		$this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k, ($hp-($y+$h))*$k));
	    else
		$this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
    
	    $xc = $x+$r;
	    $yc = $y+$h-$r;
	    $this->_out(sprintf('%.2f %.2f l', $xc*$k, ($hp-($y+$h))*$k));
	    if (strpos($angle, '4')===false)
		$this->_out(sprintf('%.2f %.2f l', ($x)*$k, ($hp-($y+$h))*$k));
	    else
		$this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
    
	    $xc = $x+$r ;
	    $yc = $y+$r;
	    $this->_out(sprintf('%.2f %.2f l', ($x)*$k, ($hp-$yc)*$k ));
	    if (strpos($angle, '1')===false)
	    {
		$this->_out(sprintf('%.2f %.2f l', ($x)*$k, ($hp-$y)*$k ));
		$this->_out(sprintf('%.2f %.2f l', ($x+$r)*$k, ($hp-$y)*$k ));
	    }
	    else
		$this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
	    $this->_out($op);
	}
    
	function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
	{
	    $h = $this->h;
	    $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
		$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
	}
}
?>