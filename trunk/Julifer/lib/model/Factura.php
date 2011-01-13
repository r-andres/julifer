<?php
class Factura {
	var $id, $fecha, $estado, $vehiculo, $servicios, $mecanica, $totalMecanica, $descuentoMecanica,  $pintura, $totalPintura, $descuentoPintura, $franquicia, $pagado;
	var $IVA = 18.0;
	const TIPO_FACTURA = "FACTURA";
	const TIPO_PRESUPUESTO = "PRESUPUESTO";
	const ESTADO_PAGADO = "PAGADO";
	const ESTADO_PENDIENTE = "PENDIENTE";
	
	function dump ($arr) {
		
		$this->id = $arr['id'];
		$this->fecha = $arr['fecha'];
		$this->tipo = $arr['tipo'];
		$this->vehiculo = $arr['vehiculo'];
		$this->servicios =  array ();
		$this->mecanica = $arr['mecanica'];
		$this->totalMecanica = $arr['totalMecanica'];
		$this->descuentoMecanica = $arr['descuentoMecanica'];
		
		$this->pintura = $arr['pintura'];
		$this->totalPintura = $arr['totalPintura'];
		$this->descuentoPintura = $arr['descuentoPintura'];
		
		$this->pagado = $arr['pagado'];
		$this->franquicia = $arr['franquicia'];
		
		$keys = array_keys($arr); 
//		usort($keys, "Factura::cmp" );
		usort($keys, array( $this, 'cmp' ) );
		foreach ($keys as $key) {
			
			$keyComponents = explode("_", $key);
			$keyName = $keyComponents[0];
			if ( strcmp($keyName, "cantidad") == 0) {
				$keyCounter = $keyComponents[1];
				$cantidad = $arr["cantidad_$keyCounter"];
				$material = $arr["material_$keyCounter"];
				$precio = $arr["precio_$keyCounter"];
				$descuento = $arr["descuento_$keyCounter"];
				$serv = new materialfacturado();
				$serv->cantidad = $cantidad;
				$serv->material = $material;
				$serv->precio = $precio;
				$serv->descuento = $descuento;
				array_push($this->servicios, $serv);
			}
			
		}
	}
	
	
	function cmp ($a, $b) {
		$aComponents = explode("_", $a);
		$aName = $aComponents[0];
		$aCounter = $aComponents[1];
		$bComponents = explode("_", $b);
		$bName = $bComponents[0];
		$bCounter = $bComponents[1];
		
//		echo ("a $a $aName $aCounter <br>");
//		echo ("b $b $bName $bCounter <br>");
		
		if ( strcmp ($aName, $bName) != 0 ) {
			return strcmp ($aName, $bName);
		} else {
			if ($aCounter > $bCounter) {
				return 1;
			} elseif ($aCounter < $bCounter) {
				return -1;
			} else {
				return 0;
			}
		}
	}
	
	
	function totalPintura () {
		$totalPintura = $this->totalPintura; 
		if ($this->descuentoPintura != 0) {
			$totalPintura -= ( $totalPintura * $this->descuentoPintura) / 100; 
		}
		return $totalPintura;
	}
	
	function totalChapa () {
		$totalChapa = $this->totalMecanica; 
		if ($this->descuentoMecanica != 0) {
			$totalChapa -=  ( $totalChapa * $this->descuentoMecanica) / 100; 
		}
		return $totalChapa;
	}
	
	function totalMateriales () {
		$total = 0; 
		foreach ($this->servicios as $material) {
			$cantidad = $material->cantidad;
			$preciounitario = $material->precio;
			$descuento = $material->descuento;
			$preciodescuento = $preciounitario - (( $preciounitario *  $descuento) / 100) ;
			$precio =  $cantidad *  $preciodescuento;
			$total += $precio;
		}	
		return $total;
		
	}
	
	
	function total() {
		$total = 0; 
		
		
		$total += $this->totalMateriales();
		$total += $this->totalChapa();
		$total += $this->totalPintura();

		$total += ($total * $this->IVA) / 100;
		
		$total -= $this->franquicia;
		
		return $total;
	}
}
?>