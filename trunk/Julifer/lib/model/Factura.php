<?php
class Factura {
	var $id, $fecha, $vehiculo, $servicios, $mecanica, $totalMecanica, $pintura, $totalPintura;
	
	function dump ($arr) {
		
		$this->id = $arr['id'];
		$this->fecha = $arr['fecha'];
		$this->vehiculo = $arr['vehiculo'];
		$this->servicios =  array ();
		$this->mecanica = $arr['mecanica'];
		$this->totalMecanica = $arr['totalMecanica'];
		$this->pintura = $arr['pintura'];
		$this->totalPintura = $arr['totalPintura'];
		
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