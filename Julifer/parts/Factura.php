<?php




require('TablaCompPDF.php');


class Cliente {
	var $nombre, $apellidos, $direccion, $poblacion, $codpostal;

}

class Empresa {
	var $nombre, $telefono, $fax, $direccion, $poblacion, $codpostal;

}

class Factura {
	var $fecha, $numero, $cliente, $servicios;

}

class Servicio {
	var $cantidad, $descripcion, $preciounitario;
}


class PDF extends TablaCompPDF
{

	protected $anchoPagina = 210;
	protected $margenX  = 10;
	protected $margenPie = 55;
	protected $empresa, $factura;
	protected $anclaje_1, $anclaje_2;
	
	protected $totalMateriales = 0;
	protected $totalManoObra = 0;
	
	
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
		$yCliente = $this->detalleCliente($this->anclaje_2 -($ancho / 2) , $y, $ancho);

		
		$this->SetY(max($yFactura, $yCliente));
		$this->ln(5);
		$this->detalleMateriales($this->factura->servicios);
		$this->totales();
		

	}

	



	function detalleFactura ($x, $y, $ancho) {
		
		$datos = array ( array ( 'CIF/NIF' => 'B-36.620.193' ,
				      'fecha' => '01/10/2010' ,
				      ),
				     array ( 'marca' => 'RENAULT' ,
				      'modelo' => 'SCENIC' ,
				      'matricula' => '183-FLW'
				     ),
				     array ( 'kms' => '' ,
				      'color' => 'BOIS M' ,
				      'factura' => '20'
				     ));
		
		return $this->tablaGruposEtiquetaDato($datos, $x, $y, $ancho);
	}


	function detalleCliente($x , $y, $ancho)
	{
		$cliente = $this->factura->cliente;
		
		$datos = array (
				'NOMBRE:' => $cliente -> nombre . ' ' . $cliente -> apellidos,
				'DIRECCIÓN:'=>  $cliente -> direccion,
				'POBLACIÓN:'=>  $cliente -> poblacion,
				'TELÉFONO:'=>  $cliente -> telefono);
		
		return $this->tablaEtiquetaDato($datos, $x, $y, $ancho);
	}



	
	function detalleMateriales ($data)
	{
		//Colores, ancho de línea y fuente en negrita
		$this->SetFillColor(127, 127, 127);
		$this->SetTextColor(255);
		$this->SetDrawColor(64, 64, 64);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');
		//Cabecera
		$w=array(30,95,30,30);
		$header = array(utf8_decode('Cantidad'),
		utf8_decode('Descripción'),
		utf8_decode('Precio por Unidad'),
		utf8_decode('Precio'));

		for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
		$this->Ln();

		//Restauración de colores y fuentes
		$this->SetFillColor(224,224,224);
		$this->SetTextColor(0);
		$this->SetFont('');
		//Datos
		$fill=false;
		$subtotal = 0;
		foreach($data as $row)
		{
			$cantidad = $row->cantidad;
			$descripcion = $row->descripcion;
			$preciounitario = $row->preciounitario;
			$precio =  $cantidad *  $preciounitario;
			$this->Cell($w[0],6, number_format($cantidad, 2),'LR',0,'C',$fill);
			$this->Cell($w[1],6,utf8_decode($descripcion),'LR',0,'L',$fill);
			$this->Cell($w[2],6,number_format($preciounitario, 2),'LR',0,'C',$fill);
			$this->Cell($w[3],6,number_format($precio, 2),'LR',0,'R',$fill);
			$subtotal += $precio;
			$this->Ln();
			$fill=!$fill;
		}

		$this->Cell($w[0], 6,'','T');
		$this->Cell($w[1], 6,'','T');
		$this->Cell($w[2], 6,'TOTAL MATERIALES','T');
		$this->Cell($w[3],6,number_format($subtotal, 2),'TLRB',0,'R',$fill);
		$this->Ln();

		$this->totalMateriales = $subtotal;

	}

	function totales () {
		$tipoImpositivo = 16;
		$subtotal = $this->totalMateriales + $this->totalManoObra;
		
		$primeraCol = 125;
		$segundaCol = 30;
		$terceraCol = 30;
		
		$this->Cell($primeraCol, 0,'','');
		$this->Cell($segundaCol, 6, "MANO DE OBRA ",'');
		$this->Cell($terceraCol,6,  number_format($this->totalManoObra, 2),'LR',0,'R');
		$this->Ln();
		
		$this->Cell($primeraCol, 0,'','');
		$this->Cell($segundaCol, 6, "MATERIALES ",'');
		$this->Cell($terceraCol,6,  number_format($this->totalMateriales, 2),'LR',0,'R');
		$this->Ln();
		
		$this->Cell($primeraCol, 0,'','');
		$this->Cell($segundaCol, 6, " I.V.A: " .number_format( $tipoImpositivo , 2) . "%",'');
		$this->Cell($terceraCol,6,  number_format(($tipoImpositivo * $subtotal) / 100, 2),'LR',0,'R');
		$this->Ln();
		
		$total =  $subtotal + (($tipoImpositivo * $subtotal) / 100);
		$this->Cell($primeraCol, 0,'','');
		$this->Cell($segundaCol, 6,'TOTAL', '', 0 );
		$this->Cell($terceraCol, 6,number_format( $total , 2)  ,'LRB',0,'R');
		$this->Ln();
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
		$anchoCondiciones = 60;
		$anchoConforme = 60;
		$anchoFirma = 60;
		$separador = 3;
		$xCondiciones = $this->margenX ;
		
		
		$fichero = 'condiciones.txt';
		$yCondiciones = $this ->  tablaDeFichero('CONDICIONES GENERALES DE REPARACIÓN', $fichero, $xCondiciones, $yPie, $anchoCondiciones);
		$xConforme = $xCondiciones + $anchoCondiciones + $separador;
		$this->tablaVacia('Conforme: EL CLIENTE', $xConforme  , $yPie, $anchoConforme, $yCondiciones - $yPie);
		$xFirma = $xConforme + $anchoConforme + $separador;
		$this->tablaVacia('Firma y Sello de la empresa',  $xFirma, $yPie, $anchoFirma, $yCondiciones - $yPie);


		$textoPie = file('pie.txt');
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
		$this->Cell(0,7, utf8_decode($pie)  ,0,0,'C');
		$this->Ln(4);
		$this->Cell(0,7, utf8_decode($detallesEmpresa)  ,0,0,'C');

	}


	function generaFactura () {
		
		$this->SetAutoPageBreak(true, $this->margenPie + 5);

		$this->AliasNbPages();
		$this->AddPage();
		$this->construyeFactura();
		$this->Output('factura.pdf', 'f');
	}

}


$empresa = new Empresa();
$empresa->nombre = "Talleres Julifer";
$empresa->poblacion = "BEADE";
$empresa->direccion = "Rúa Chabarras, nº 18 bajo";
$empresa->codpostal = "36312";
$empresa->provincia = "VIGO";
$empresa->telefono = "986 29 94";
$empresa->fax = "986 29 05 67";
$empresa->nif = "99999999-Z";


$cliente = new Cliente();
$cliente->apellidos = "Martín Berdugo";
$cliente->nombre = "Jose María";
$cliente->poblacion = "Trévago";
$cliente->direccion = "Avda. Llamosos";
$cliente->codpostal = "32889";


$servicios = array();
$servicio = new Servicio();
$servicio->cantidad = 4.5;
$servicio->descripcion = 'Aceite sintético';
$servicio->preciounitario = 36.5;
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);
array_push($servicios, $servicio);


$factura = new Factura ();
$factura->fecha = "14/10/2010";
$factura->numero = "00034/2010";
$factura->cliente = $cliente;
$factura->servicios = $servicios;


$pdf=new PDF($empresa, $factura);
$pdf->generaFactura();


?>
