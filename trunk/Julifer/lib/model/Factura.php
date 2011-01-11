<?php
class Factura {
	var $id, $fecha, $estado, $vehiculo, $servicios, $mecanica, $totalMecanica, $descuentoMecanica,  $pintura, $totalPintura, $descuentoPintura, $franquicia, $pagado;
	
	function dump ($arr) {
		
		$this->id = $arr['id'];
		$this->fecha = $arr['fecha'];
		$this->estado = $arr['estado'];
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
				$servicioId = $arr["servicio_$keyCounter"];
				$serv = new materialfacturado();
				$serv->cantidad = $cantidad;
				$serv->servicio = $servicioId;
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
	
	
	
}
?>