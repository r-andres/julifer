<?php


define('FPDF_FONTPATH',"$ROOT/lib/common/font/");
define ('EURO', chr(128) );

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
	protected $minFilasMateriales = 0;
	
	
	
	function PDF ($empresa, $factura , $orientation='P',$unit='mm',$format='A4') {
   		$this->FPDF($orientation,$unit,$format);
		$this->anclaje_1 =  $this->margenX +  ((($this->anchoPagina - (2 * $this->margenX)) *  1) / 4 );
		$this->anclaje_2 =  $this->margenX +  ((($this->anchoPagina - (2 * $this->margenX)) *  3) / 4 );
		$this->empresa = $empresa;
		$this->factura = $factura;		
	}
	
	function construyeFactura ()
	{
		
		
		$ancho = 95;  // mm 
		$tamannoLetra = 10;
		
		$this->ln(4);
		$y = $this->GetY();
		$yCliente = $this->detalleCliente($this->anclaje_2 -($ancho / 2) , $y , $ancho -3, $tamannoLetra);
		$yFactura = $this->detalleFactura($this->anclaje_1 -($ancho / 2) , $yCliente - 6 * 6 , $ancho -3, $tamannoLetra);
		
		
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
		$er = $this->precalculaEspacioTabla ("Chapa", $this->factura-> mecanica, $totalesMecanica, 6, $ancho);
		
		
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
		$er = $this->precalculaEspacioTabla ("Pintura", $this->factura-> pintura, $totalesPintura, 6 , $ancho);

		
			
		$this->final = true;		

	}

	
	function  precalculaEspacioTabla ($titulo, $texto, $array, $altura, $ancho) {
		$nFilasTeoricas = 5;  //
		$MAX_CARACTERES_LINEA = 114;

		if (strlen($texto) == 0 ) {
			$texto = " ";
		}
		
		$lineas = explode("\n", $texto);
		$lineasAlmacenadas = "";
		$primeraTabla = true;
		
		foreach ($lineas as $linea ) {
			if (strlen($linea) > 0 ) {
				$numfilas = ceil((strlen($linea) + 1) / $MAX_CARACTERES_LINEA);
				$nFilasTeoricas += $numfilas;
				$espacioRequerido =  $nFilasTeoricas * $altura;
				if ($this->GetY() + $espacioRequerido >=   ($this->altoPagina - ( $this->margenPie)) ) {
					$tituloTabla = "";

					if ($primeraTabla) {
						$tituloTabla = $titulo;
					}
					if (strlen($lineasAlmacenadas) > 0) {
					$this->tablaFilasGrupo( $tituloTabla,  $lineasAlmacenadas ,  array() , 10, $this->GetY(), $ancho * 2, $tamannoLetra);
					$primeraTabla = false;
					}
					$this->AddPage();
					$lineasAlmacenadas = $linea . "\n";
					$nFilasTeoricas = $numfilas;
					
				} else {
					$lineasAlmacenadas .= $linea . "\n";
				}
			}
		}

		if ($lineasAlmacenadas != "") {
			$tituloTabla = "";
			if ($primeraTabla) {
				$tituloTabla = $titulo;
			}
			$this->tablaFilasGrupo( $tituloTabla,  $lineasAlmacenadas ,
			$array , 10, $this->GetY(), $ancho * 2, $tamannoLetra);
		}

		return $nFilasTeoricas;
	}

	
	
	function totales ($x , $y, $ancho, $alto, $tamannoLetra)
	{
		
		
		$cliente = $this->factura->cliente;
		$manoDeObra = $this->recalculadoPintura + $this->recalculadoMecanica  ;
		$materiales = $this->totalMateriales;
		$subtotal = $manoDeObra + $materiales;
		$tipoImpositivo = constant("IVA");
		$iva = ($subtotal * $tipoImpositivo) / 100;
		
		$franquicia = $this->factura->franquicia;
		$total = $subtotal + $iva ;
		
		
		$datos = array (
				'MANO DE OBRA' =>  $this->formatoMoneda($manoDeObra) ,
				'MATERIALES'=>   $this->formatoMoneda( $materiales) ,
				'SUBTOTAL'=> $this->formatoMoneda($subtotal), 
				"I.V.A. ($tipoImpositivo %) " =>  $this->formatoMoneda($iva));
		
		$totalFactura = $total;
	
		if ($franquicia != 0) {
			$datos['TOTAL']	= $this->formatoMoneda($total);
			$datos['  ']	= " ";
			$datos['FRANQUICIA']	= $this->formatoMoneda($franquicia);
			
			$totalFactura = $total - $franquicia;
			if ($totalFactura <= 0) {
				$totalFactura = 0;
			}
		} else {
			$datos=array_merge(array("  "=>" "), $datos); 
			$datos['  ']	= " ";
		} 
		
		$datos['TOTAL FACTURA']	= $this->formatoMoneda($totalFactura);
		
		$alineado = 'R';
		
		return $this->tablaEtiquetaDato($datos, $x, $y, $ancho , $tamannoLetra , $alto, $alineado);
	}

	
	function formatoMoneda ($valor) {
		
		return number_format( $valor, 2) .  EURO;
	}


	function detalleFactura ($x, $y, $ancho, $tamannoLetra) {
		
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
		
		return $this->tablaGruposEtiquetaDato($datos, $x, $y, $ancho, $tamannoLetra);
	}


	function detalleCliente($x , $y, $ancho, $tamannoLetra)
	{
	
		
		$cliente = $this->factura->cliente;
		
		$datos = array (
				'Nombre:' => utf8_decode($cliente -> nombre . ' ' . $cliente -> apellidos),
				'Dirección:'=>  utf8_decode($cliente -> direccion),
				'Población:'=>  utf8_decode($cliente -> localidad . ' ' . $cliente-> provincia),
				'Teléfono:'=>  utf8_decode($cliente -> telefono),
				'Email:'=>  utf8_decode($cliente -> correoelectronico));
		
		return $this->tablaEtiquetaDato($datos, $x, $y, $ancho, $tamannoLetra);
	}


	function detalleMateriales ($x, $y, $data) {
		
		$cabecera = array(utf8_decode('Cantidad') => 25,
						  utf8_decode('Descripción') => 80,
					      utf8_decode('Precio por Unidad') => 40,
					      utf8_decode('Descuento') => 20,
						  utf8_decode('Precio')  => 25);
		
		$subtotal = 0;
		$datos = array();
		$espacioDisponible = $this->altoPagina - $this->margenPie - $y;
		
		$maxFilasPorPagina = ceil($espacioDisponible / 7);
		$tamannoLetra = 10;
		$contador = 0;
		$contadorTotal = 0;
		$totalDatos = count ($data);
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
			$contador += 1;
			
			if ($contador == $maxFilasPorPagina ) {
				$muestraTotal = false;
				$yFinal = $this->tablaFilas($datos, $cabecera, "TOTAL MATERIALES", number_format($this->totalMateriales, 2), $muestraTotal , $x, $y, $tamannoLetra);
				$y = $this->finCabecera;
				$datos = array();
				$contador = 0;
				$maxFilasPorPagina = $maxFilasPorPagina + 8;
			}
			
		}

		if ($contador != 0 ) {
			$muestraTotal = true;
			
			if ($contador % 2 == 1) {
				 $fila = array ();
	    		 array_push($datos, $fila);
			}
			
			for ($i = count($datos) ; $i <= $this->minFilasMateriales; $i++) {
	    		 $fila = array ();
	    		 array_push($datos, $fila);
			}
			
			if (count($datos) > 0) {
			
				$yFinal = $this->tablaFilas($datos, $cabecera, "TOTAL MATERIALES", number_format($this->totalMateriales, 2), $muestraTotal , $x, $y, $tamannoLetra);
			
			} else {
				$yFinal = $this->GetY();
			}
		}
		
		return $yFinal; 
	}
	
	
	
	
	function  Header ( )
	{
		$tamannoFuente = 10;
		$anchoImagen = 70;
		//Logo
		$this->Image('images/logo.jpg',  $this->anclaje_1 -($anchoImagen / 2) , 10 , $anchoImagen);
		
		$empresa = $this->empresa;
		
		$lineaLogo1 = $empresa->poblacion . ' - ' . $empresa->direccion . ' - ' . $empresa->codpostal . ' ' .  $empresa->provincia;
		$lineaLogo2 = 'Teléfono ' . $empresa->telefono  . ' - Fax ' . $empresa->fax ;
		$this->SetTextColor(0, 0, 0);
		$this->SetFont('Arial','', $tamannoFuente );
		$xLineaPromo = $this->anclaje_2 ;
		$promos = array ('BANCADA DE CARROCERÍA' , 'CABINA DE PINTADO' , 'MECÁNICA RÁPIDA'  );
		foreach ($promos as $promo) {	
			$this->SetX($xLineaPromo);
			$this->Cell($this->_dameAncho($promo), $tamannoFuente, utf8_decode( $promo),0,0,'L');
			$this->Ln($tamannoFuente / 2);
		}
		
		$this->SetFont('Arial','BI', $tamannoFuente);
		$maxLongitudes = max($this->_dameAncho($lineaLogo1), $this->_dameAncho($lineaLogo2));
		$xLineaLogo = (($this->anchoPagina / 4) * 3) - ($maxLongitudes / 2);
		
		$this->Ln($tamannoFuente / 2);
		$this->SetX($xLineaLogo);
		$this->Cell($maxLongitudes, $tamannoFuente, utf8_decode($lineaLogo1),0,0,'C');
		$this->Ln($tamannoFuente / 2);
		$this->SetX($xLineaLogo);
		$this->Cell($maxLongitudes, $tamannoFuente, utf8_decode($lineaLogo2),0,0,'C');
		$this->Ln(10);	
		
		$this->finCabecera = $this->GetY();
		
        }


	//Pie de página
	function Footer()
	{
		$this->SetTextColor(0, 0, 0);
		$tamannoLetra = 6;
		//Posición: a margenPie del final
		$this->SetY(-1 * $this->margenPie);

		$yPie = $this->GetY();
		$anchoCondiciones = 65;
		$anchoConforme = 35;
		$anchoFirma = 35;
		$anchoTotales = 47;
		$separador = 3;
		$xCondiciones = $this->margenX ;

		$altoDomiciliacion = 10 ;
		$anchoDomiciliacion = $anchoFirma + $separador + $anchoConforme;
		
		if (!$this->final) {
			
			$anchoConforme = 59;
			$anchoFirma = 59;
		}
		
		
		
		$fichero = "lib/common/condiciones.txt";
		$yCondiciones = $this ->  tablaDeFichero('CONDICIONES GENERALES DE REPARACIÓN', $fichero, $xCondiciones, $yPie, $anchoCondiciones);
		$xConforme = $xCondiciones + $anchoCondiciones + $separador;
		$altoMovil = $yCondiciones - $yPie;
		
		if ($this->final && $this->factura->cuenta != '') {
			$altoMovil = $altoMovil - $altoDomiciliacion - 2;
			$yDomiciliacion = $yPie + $altoMovil + 2;
		}
		$this->tablaVacia('Conforme: EL CLIENTE', $xConforme  , $yPie, $anchoConforme, $altoMovil, $tamannoLetra );
		$xFirma = $xConforme + $anchoConforme + $separador;
		$this->tablaVacia('Firma y Sello de la empresa',  $xFirma, $yPie, $anchoFirma, $altoMovil, $tamannoLetra);
		
		$xTotales = $xFirma + $anchoFirma + $separador;
		//$this->tablaVacia('TOTALES',  $xTotales, $yPie, $anchoTotales, $yCondiciones - $yPie);
		if ($this->final) {
			if ($this->factura->cuenta != '') {
			$this->tablaSimple('Domiciliación bancaria',
							 	$this->factura->cuenta,	 
								$xConforme  , $yDomiciliacion, 
								$anchoDomiciliacion, $altoDomiciliacion);
			}
			$tamannoLetra = 8;
			$this->totales($xTotales, $yPie, $anchoTotales, $yCondiciones - $yPie, $tamannoLetra);
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
