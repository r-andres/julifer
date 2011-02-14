<?php


define('FPDF_FONTPATH',"$ROOT/lib/common/font/");
require_once("$ROOT/lib/common/fpdf.php");
require_once("$ROOT/lib/common/TablaCompPDF.php");



class PDF extends TablaCompPDF
{
	protected $altoPagina = 297;
	protected $anchoPagina = 210;
	protected $margenX  = 10;
	protected $margenPie = 55;
	protected $empresa, $factura;
	protected $anclaje_1, $anclaje_2;
	protected $final = false;
	protected $totalMateriales = 0;

	
	
	
	
	function PDF ($empresa, $factura , $orientation='P',$unit='mm',$format='A4') {
   		$this->FPDF($orientation,$unit,$format);
		$this->anclaje_1 =  $this->margenX +  ((($this->anchoPagina - (2 * $this->margenX)) *  1) / 4 );
		$this->anclaje_2 =  $this->margenX +  ((($this->anchoPagina - (2 * $this->margenX)) *  3) / 4 );
		$this->empresa = $empresa;
		$this->factura = $factura;		
	}
	
	function construyeFactura ()
	{
		
		
		$ancho = 93;  // mm 
		$y = $this->GetY();
		$yFactura = $this->detalleFactura($this->anclaje_1 -($ancho / 2) , $y , $ancho);
		$yCliente = $this->detalleCliente($this->anclaje_2 -($ancho / 2) , $y + 6, $ancho);

		
		$this->SetY(max($yFactura, $yCliente));
		$this->ln(5);
		$this->detalleMateriales( 10 , $this->GetY(), $this->factura->servicios);
		
		$this->ln(5);
		
		$totalesMecanica = array ( "Importe Chapa" => number_format($this->factura->totalMecanica, 2)  );
		$totalMecanica = $this->factura->totalMecanica; 
		if ($this->factura->descuentoMecanica != 0) {
			$totalesMecanica["Descuento"] = number_format($this->factura->descuentoMecanica, 2);
			$totalMecanica =  $this->factura->totalMecanica - (( $this->factura->totalMecanica * $this->factura->descuentoMecanica) / 100); 
			$totalesMecanica["Total Chapa"] = number_format( $totalMecanica , 2);
		}
		$er = $this->precalculaEspacioTabla ($this->factura-> mecanica, $totalesMecanica, 6);
		$this->tablaFilasGrupo( "Chapa",  $this->factura-> mecanica , 
								$totalesMecanica , 10, $this->GetY(), $ancho * 2 );
		
		$this->recalculadoMecanica	= $totalMecanica;					
								
		$this->ln(5);
		
		$totalesPintura = array ( "Importe Pintura" => number_format($this->factura->totalPintura, 2)  );
		$totalPintura = $this->factura->totalPintura;
		if ($this->factura->descuentoPintura != 0) {
			$totalesPintura["Descuento"] = number_format($this->factura->descuentoPintura, 2);
			$totalPintura =  $this->factura->totalPintura - (( $this->factura->totalPintura * $this->factura->descuentoPintura) / 100); 
			$totalesPintura["Total pintura"] = number_format( $totalPintura , 2);
		}
		$this->recalculadoPintura = $totalPintura;
		$er = $this->precalculaEspacioTabla ($this->factura-> pintura, $totalesPintura, 6);
		$this->tablaFilasGrupo( "Pintura",  $this->factura-> pintura, 
								$totalesPintura , 10, $this->GetY(), $ancho * 2 );
		
			
		$this->final = true;		

	}

	
	function  precalculaEspacioTabla ($texto, $array, $altura) {
		$nFilasTeoricas = 2;  //
		
		$nFilasTeoricas += substr_count($texto, "\n") + 1;
		
		$nFilasTeoricas +=  count($array);
		
		$espacioRequerido =  $nFilasTeoricas * $altura;
		
		if ($this->GetY() + $espacioRequerido >=   ($this->altoPagina - ( $this->margenPie)) ) {
			$this->AddPage();
		}
		
		return $nFilasTeoricas;
	}
	
	
	
	function totales ($x , $y, $ancho, $alto)
	{
		
		
		$cliente = $this->factura->cliente;
		$manoDeObra = $this->recalculadoPintura + $this->recalculadoMecanica  ;
		$materiales = $this->totalMateriales;
		$subtotal = $manoDeObra + $materiales;
		$tipoImpositivo = 18;
		$iva = ($subtotal * $tipoImpositivo) / 100;
		
		$franquicia = $this->factura->franquicia;
		$total = $subtotal + $iva ;
		
		
		$datos = array (
				'MANO DE OBRA' => number_format($manoDeObra, 2) ,
				'MATERIALES'=>   number_format( $materiales, 2) ,
				'SUBTOTAL'=> number_format($subtotal, 2), 
				"I.V.A. ($tipoImpositivo %) " =>  number_format($iva, 2));
		
		$totalFactura = $total;
	
		if ($franquicia != 0) {
			$datos['TOTAL']	= number_format($total, 2);
			$datos['  ']	= " ";
			$datos['FRANQUICIA']	= number_format($franquicia, 2);
			
			$totalFactura = $total - $franquicia;
			if ($totalFactura <= 0) {
				$totalFactura = 0;
			}
		} else {
			$datos['  ']	= " ";
		} 
		
		$datos['TOTAL FACTURA']	= number_format($totalFactura , 2);
		
		$alineado = 'R';
		
		return $this->tablaEtiquetaDato($datos, $x, $y, $ancho , $alto, $alineado);
	}



	function detalleFactura ($x, $y, $ancho) {
		
		$etiquetaNumero = 'Num. Factura';
		
		if ($this->esPresupuesto() ) {
			$etiquetaNumero = 'Num. Presupuesto';
		}
		
		
		$datos = array ( array ( 'CIF/NIF' => $this->factura->cliente-> nif ,
				      'Fecha' => $this->factura->fecha ,
					  $etiquetaNumero	=> $this->factura->numero
				      ),
				     array ( 'Marca' => $this->factura->vehiculo->marca ,
				      'Modelo' => $this->factura->vehiculo->modelo ,
				      'Matrícula' => $this->factura->vehiculo->matricula
				     ),
				     array ( 'kms' => $this->factura->vehiculo->km ,
				      'Color' => $this->factura->vehiculo->color ,
				      'Num. bastidor' => $this->factura->vehiculo->numerobastidor 
				     ));
		
		return $this->tablaGruposEtiquetaDato($datos, $x, $y, $ancho);
	}


	function detalleCliente($x , $y, $ancho)
	{
		
		
		$cliente = $this->factura->cliente;
		
		$datos = array (
				'NOMBRE:' => $cliente -> nombre . ' ' . $cliente -> apellidos,
				'DIRECCIÓN:'=>  $cliente -> direccion,
				'POBLACIÓN:'=>  $cliente -> localidad . ' ' . $cliente-> provincia ,
				'TELÉFONO:'=>  $cliente -> telefono,
				'C. ELECTRÓNICO:'=>  $cliente -> correoelectronico);
		
		return $this->tablaEtiquetaDato($datos, $x, $y, $ancho);
	}


	function detalleMateriales ($x, $y, $data) {
		
		$cabecera = array(utf8_decode('Cantidad') => 25,
						  utf8_decode('Descripción') => 85,
					      utf8_decode('Precio por Unidad') => 30,
					      utf8_decode('Descuento') => 20,
						  utf8_decode('Precio')  => 25);
		
		$subtotal = 0;
		$datos = array();
		foreach($data as $row)
		{
			$fila = array ();
			$cantidad = $row->cantidad;
			$descripcion = $row->material;
			$preciounitario = $row->precio;
			$descuento = $row->descuento;
			$preciodescuento = $preciounitario - (( $preciounitario *  $descuento) / 100) ;
			$precio =  $cantidad *  $preciodescuento;
			$fila[utf8_decode('Cantidad')] = number_format($cantidad, 2);
			$fila[utf8_decode('Descripción')] = utf8_decode($descripcion);
			$fila[utf8_decode('Precio por Unidad')] = number_format($preciounitario, 2);
			$fila[utf8_decode('Descuento')] = number_format($descuento, 2) . "%";
			$fila[utf8_decode('Precio')] = number_format($precio, 2);
			$this->totalMateriales += $precio;
			array_push($datos, $fila);
		}

		
		if (count($datos) % 2 == 1) {
			 $fila = array ();
    		 array_push($datos, $fila);
		}
		
		for ($i = count($datos) ; $i <= 6; $i++) {
    		 $fila = array ();
    		 array_push($datos, $fila);
		}
		
		return $this->tablaFilas($datos, $cabecera, "TOTAL MATERIALES", number_format($this->totalMateriales, 2) , $x, $y, $ancho);
	}
	
	
	
	
	function  Header ( )
	{
		$tamannoFuente = 7;
		$anchoImagen = 70;
		//Logo
		$this->Image('images/logo.jpg',  $this->anclaje_1 -($anchoImagen / 2) , 10 , $anchoImagen);
		
		$empresa = $this->empresa;
		
		$lineaLogo1 = $empresa->poblacion . ' - ' . $empresa->direccion . ' - ' . $empresa->codpostal . ' ' .  $empresa->provincia;
		$lineaLogo2 = 'Teléfono ' . $empresa->telefono  . ' - Fax ' . $empresa->fax ;
		
		$this->SetFont('Arial','', $tamannoFuente );
		$xLineaPromo = $this->anclaje_2 ;
		$promos = array ('BANCADA DE CARROCERÍA' , 'CABINA DE PINTADO' , 'MECÁNICA RÁPIDA'  );
		foreach ($promos as $promo) {	
			$this->SetX($xLineaPromo);
			$this->Cell($this->_dameAncho($promo), $tamannoFuente, utf8_decode( $promo),0,0,'L');
			$this->Ln($tamannoFuente / 2);
		}
		
		$this->SetFont('Arial','BI', $tamannoFuente + 2);
		$maxLongitudes = max($this->_dameAncho($lineaLogo1), $this->_dameAncho($lineaLogo2));
		$xLineaLogo = (($this->anchoPagina / 4) * 3) - ($maxLongitudes / 2);
		
		$this->Ln($tamannoFuente / 2);
		$this->SetX($xLineaLogo);
		$this->Cell($maxLongitudes, $tamannoFuente, utf8_decode($lineaLogo1),0,0,'C');
		$this->Ln($tamannoFuente / 2);
		$this->SetX($xLineaLogo);
		$this->Cell($maxLongitudes, $tamannoFuente, utf8_decode($lineaLogo2),0,0,'C');
		$this->Ln(10);	
		
        }


	//Pie de página
	function Footer()
	{
		//Posición: a margenPie del final
		$this->SetY(-1 * $this->margenPie);

		$yPie = $this->GetY();
		$anchoCondiciones = 65;
		$anchoConforme = 35;
		$anchoFirma = 35;
		$anchoTotales = 45;
		$separador = 3;
		$xCondiciones = $this->margenX ;

		$altoDomiciliacion = 10 ;
		$anchoDomiciliacion = $anchoFirma + $separador + $anchoConforme;
		
		if (!$this->final) {
			$anchoConforme = 57;
			$anchoFirma = 57;
		}
		
		
		
		$fichero = "lib/common/condiciones.txt";
		$yCondiciones = $this ->  tablaDeFichero('CONDICIONES GENERALES DE REPARACIÓN', $fichero, $xCondiciones, $yPie, $anchoCondiciones);
		$xConforme = $xCondiciones + $anchoCondiciones + $separador;
		$altoMovil = $yCondiciones - $yPie;
		
		if ($this->final && $this->factura->cuenta != '') {
			$altoMovil = $altoMovil - $altoDomiciliacion - 2;
			$yDomiciliacion = $yPie + $altoMovil + 2;
		}
		$this->tablaVacia('Conforme: EL CLIENTE', $xConforme  , $yPie, $anchoConforme, $altoMovil);
		$xFirma = $xConforme + $anchoConforme + $separador;
		$this->tablaVacia('Firma y Sello de la empresa',  $xFirma, $yPie, $anchoFirma, $altoMovil);
		
		$xTotales = $xFirma + $anchoFirma + $separador;
		//$this->tablaVacia('TOTALES',  $xTotales, $yPie, $anchoTotales, $yCondiciones - $yPie);
		if ($this->final) {
			if ($this->factura->cuenta != '') {
			$this->tablaSimple('Domiciliación bancaria',
							 	$this->factura->cuenta,	 
								$xConforme  , $yDomiciliacion, 
								$anchoDomiciliacion, $altoDomiciliacion);
			}
			$this->totales($xTotales, $yPie, $anchoTotales, $yCondiciones - $yPie);
		} 
		$textoPie = file("lib/common/pie.txt");
		$pie = "";
		foreach ($textoPie as $lineaPie) {
			$pie .= $lineaPie;
		}

		$empresa = $this->empresa;	
		$detallesEmpresa = $empresa->direccion . ' - ' . $empresa->codpostal .
					   ' ' . $empresa->poblacion .
					   '. Teléfono ' . $empresa->telefono  . ' Fax ' . $empresa->fax; 


		$this->SetY($yCondiciones);
		$this->SetFont('Arial','I',7);
		$this->SetTextColor(127, 0, 0);
		$this->Cell(0,7, utf8_decode($pie)  ,0,0,'C');
		$this->Ln(4);
		$this->Cell(0,7, utf8_decode($detallesEmpresa)  ,0,0,'C');
		if ($this->PageNo() > 1  || ! $this->final ) {
			$this->Cell(0,7, utf8_decode($this->PageNo() . " de {nb} ")  ,0,0,'C');
		}
	}


	function generaFactura () {
		
		$this->SetAutoPageBreak(true, $this->margenPie + 5);

		$this->AliasNbPages();
		$this->AddPage();
		$this->marcaAgua();
		$this->construyeFactura();
		$this->Output();
	}

	
	function buscaEnLista ($id, $lista) {
		$buscado = null;
		foreach ($lista as $candidato) {
			if ((int) $candidato->id == (int) $id ) {
				$buscado = $candidato;
			}
		
		}
		return $buscado;
	}

	
	function marcaAgua () {
		if ($this->esPresupuesto()) {
			$this->watermark("PRESUPUESTO");
		}
    }

    function watermark ($texto) {
    	$this->SetFont('Arial','B',70);
		$this->SetTextColor(255,192,203);
		$this->RotatedText(35,190,$texto,45);
		$this->SetTextColor(0,0,0);
    }
    
    function esPresupuesto () {
    	return strcmp($this->factura->tipo, Factura::TIPO_PRESUPUESTO) == 0;
    }
    
    function RotatedText($x, $y, $txt, $angle)
    {
         //Text rotated around its origin
         $this->Rotate($angle,$x,$y);
         $this->Text($x,$y,$txt);
         $this->Rotate(0);
    }

    var $angle=0;
   
    function Rotate($angle,$x=-1,$y=-1)
    {
        if($x==-1)
        $x=$this->x;
        if($y==-1)
        $y=$this->y;
        if($this->angle!=0)
        $this->_out('Q');
        $this->angle=$angle;
        if($angle!=0)
        {
        $angle*=M_PI/180;
        $c=cos($angle);
        $s=sin($angle);
        $cx=$x*$this->k;
        $cy=($this->h-$y)*$this->k;
        $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
        }
    }
   
    function _endpage()
    {
        if($this->angle!=0)
        {
        $this->angle=0;
        $this->_out('Q');
        }
        parent::_endpage();
    }
}



	$controller = new FacturaController();
	$factura= $controller->factura;
	
	$factura->vehiculo = VehiculoLogic::retrieveVehiculo($factura->vehiculo);
	$factura->cliente = ClienteLogic::retrieveCliente($factura->vehiculo->cliente);
	

$empresa = new Empresa();
$empresa->nombre = "Talleres Kulifer";
$empresa->poblacion = "BEADE";
$empresa->direccion = "Rúa Chabarras nº 18 Bajo";
$empresa->codpostal = "36312";
$empresa->telefono = "986 29 94 17";
$empresa->fax = "986 29 05 67";
$empresa->nif = "99999999-Z";



$pdf=new PDF($empresa, $factura);
$pdf->generaFactura();


?>
