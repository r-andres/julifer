<?php

class FacturaDAO  {
	var $conn;
	var $TABLE_NAME = 'facturas';

	function FacturaDAO(&$conn) {
		$this->conn = $conn;
	}

	function save(&$vo) {
		if ($vo->id == 0) {
			$this->insert($vo);
		} else {
			$this->update($vo);
		}
	}


	function get($id) {
		#execute select statement
		#create new vo and call getFromResult
		#return vo

		$list = $this->filteredList(" $this->TABLE_NAME.id = '$id' ", "");
		return  $list[0];

	}

	/**
	 * Checks the maximun id for facturas/presupuesto.
	 */
	function getNextId($tipo) {
		$query = "select max(numero) as numero from facturas where tipo='$tipo'";
		$result = mysql_query($query,$this->conn) or db__showError();

		$auxNumber = 0;
		if ($myrow = mysql_fetch_array($result)) {
			$auxNumber = $myrow['numero'];
		}
		mysql_free_result($result);
		
		return $auxNumber + 1;
	}
	
	function delete(&$vo) {

		$query = "DELETE FROM  $this->TABLE_NAME WHERE $this->TABLE_NAME.id = $vo->id ";
		$result = mysql_query($query, $this->conn) or db__showError();
	}

	function filteredList ($filter, $orderby) {
		$list =  array () ;
		$query = "SELECT facturas.*, DATE_FORMAT(facturas.fecha,  '%d-%m-%Y') as cfecha FROM  $this->TABLE_NAME";
		if($filter != "")
		{
			$query .= " WHERE $filter ";
		}
		if($orderby != "")
		{
			$query .= " ORDER BY  $orderby ";
		}
		
		$result = mysql_query($query,$this->conn) or db__showError();

		if ($myrow = mysql_fetch_array($result)) {
			do {
				$element = new Factura ();
				$this->getFromResult($element, $myrow);
				array_push($list,$element);
			} while ($myrow = mysql_fetch_array($result));
		}
		mysql_free_result($result);
		return $list;
	}


	#-- private functions



	function getFromResult(&$vo, $result) {
	 $vo->id = $result['id'];
	 $vo->fecha = $result['cfecha'];
	 $vo->tipo = $result['tipo'];
	 $vo->vehiculo = $result['idvehiculo'];
	 $vo->mecanica = $result['mecanica'];
	 $vo->totalMecanica = $result['totalmecanica'];
	 $vo->descuentoMecanica = $result['descuentomecanica'];
	 $vo->pintura = $result['pintura'];
	 $vo->totalPintura = $result['totalpintura'];
	 $vo->descuentoPintura = $result['descuentopintura'];
	 $vo->franquicia = $result['franquicia'];
	 $vo->pagado = $result['pagado'];
	 $vo->numero = $result['numero'];
	 $vo->cuenta = $result['cuenta'];
	 $vo->splitCuenta();
	  
	 $list =  array () ;
	 $query2 = "SELECT * FROM  materialFacturados WHERE idfactura = $vo->id ";
	 $result2 = mysql_query($query2, $this->conn) or db__showError();

	 if ($myrow2 = mysql_fetch_array($result2)) {
	 	do {
	 		$element = new MaterialFacturado ();
	 		$element->cantidad = $myrow2['cantidad'];
	 		$element->id = $myrow2['id'];
	 		$element->material = $myrow2['material'];
	 		$element->precio = $myrow2['precio'];
	 		$element->descuento = $myrow2['descuento'];
	 		array_push($list,$element);
	 	} while ($myrow2 = mysql_fetch_array($result2));
	 }
	 mysql_free_result($result2);
	 $vo->servicios = $list;

	 // Matricula
	 if (!empty($vo->vehiculo)){
		 $query3 = "SELECT matricula FROM  vehiculos WHERE id =$vo->vehiculo ";
		 	
		 $result3 = mysql_query($query3, $this->conn) or db__showError();
		 if ($myrow3 = mysql_fetch_array($result3)) {
		 	do {
		 		$vo->matricula = $myrow3['matricula'];
		 	} while ($myrow3 = mysql_fetch_array($result3));
		 }
		 mysql_free_result($result3);
	 }
	}

	function update(&$vo) {
		#execute update statement here
		$query = "UPDATE $this->TABLE_NAME SET tipo = '$vo->tipo' ,fecha = '$vo->fecha' , idvehiculo = '$vo->vehiculo',   ".
   			 " franquicia = '$vo->franquicia' , pagado = '$vo->pagado',  " .
		     " numero = '$vo->numero' , cuenta = '$vo->cuenta',  " .
   			 " mecanica = '$vo->mecanica', totalmecanica = '$vo->totalMecanica', descuentomecanica = '$vo->descuentoMecanica', ".
   			 " pintura= '$vo->pintura', totalpintura= '$vo->totalPintura', descuentopintura= '$vo->descuentoPintura' WHERE id = '$vo->id' ";
		$result = mysql_query($query, $this->conn) or db__showErrorCause($query);
		$this->insertServiciosFacturados($vo->id, $vo->servicios, true);
	}

	function insert(&$vo) {
		$query = "INSERT INTO $this->TABLE_NAME (tipo, fecha, idvehiculo , " .
   											" franquicia, pagado, numero, cuenta, " .
   											" mecanica, totalmecanica, descuentomecanica," .
   											" pintura, totalpintura, descuentopintura) " .
   			 "VALUES ( '$vo->tipo' , '$vo->fecha' , '$vo->vehiculo' , " . 
   					 " '$vo->franquicia', '$vo->pagado', '$vo->numero', '$vo->cuenta', " .
   			     	 " '$vo->mecanica' , '$vo->totalMecanica', '$vo->descuentoMecanica' , " . 
   			     	 " '$vo->pintura' , '$vo->totalPintura', '$vo->descuentoPintura') ";
		$result = mysql_query($query, $this->conn) or db__showErrorCause($query);
		$idFactura = mysql_insert_id($this->conn);
		$this->insertServiciosFacturados($idFactura, $vo->servicios, false);
		$vo->id = $idFactura;
	}


	function insertServiciosFacturados ($idFactura, $servicios, $limpiar) {

		if ($limpiar) {
			$query = "DELETE FROM materialFacturados  " .
   	  		         " WHERE idfactura = $idFactura  ";
			$result = mysql_query($query, $this->conn) or db__showError();
		}

		foreach ( $servicios as $servicioFacturado) {

			$material = $servicioFacturado->material;
			$cantidad = $servicioFacturado->cantidad;
			$precio = $servicioFacturado->precio;
			$descuento = $servicioFacturado->descuento;

			$query = "INSERT INTO materialFacturados (idfactura, material, cantidad, precio, descuento) " .
   	  		         " VALUES ( $idFactura , '$material', $cantidad, $precio, $descuento) ";
			$result = mysql_query($query, $this->conn) or db__showErrorCause($query);
		}
	}

	/**
	 * Searches a list of facturas fitting the criteria based on client an
	 * vehicle objects as well as factura ones.
	 *
	 * @param $vo
	 * @param $vehicle
	 * @param $client
	 */
	function search($vo, $vehicle, $client) {
		$where = "";

		$vo_prefix = "facturas";
		$vehicle_prefix = "vehiculos";
		$cliente_prefix = "clientes";

		// Facturas
		foreach($vo as $key => $value) {
			if ( $value == "" ) {
				continue;
			}

			if (!empty($where)) {
				$where .= " and ";
			}
				
			$where .= "$vo_prefix.$key like '%$value%'";
		}

		// Client
		foreach($client as $key => $value) {
			if ( $value == "" ) {
				continue;
			}

			if (!empty($where)) {
				$where .= " and ";
			}
			$where .= "$cliente_prefix.$key like '%$value%'";
		}

		// Vehicle
		foreach($vehicle as $key => $value) {
			if ( $value == "" ) {
				continue;
			}

			if (!empty($where)) {
				$where .= " and ";
			}

			$where .= "$vehicle_prefix.$key like '%$value%'";
		}

		// Defining final query
		$list =  array () ;
		$query = "SELECT distinct facturas.*, DATE_FORMAT(facturas.fecha,  '%d-%m-%Y') as cfecha FROM  $this->TABLE_NAME, vehiculos, clientes ";
		if ($where != "") {
			// Joins
			$where .= " and vehiculos.idcliente=clientes.id and facturas.idvehiculo=vehiculos.id";
			$query .= " WHERE $where";
		}

		$result = mysql_query($query,$this->conn) or db__showError();

		if ($myrow = mysql_fetch_array($result)) {
			do {
				$element = new Factura ();
				$this->getFromResult($element, $myrow);
				array_push($list,$element);
			} while ($myrow = mysql_fetch_array($result));
		}
		mysql_free_result($result);

		return $list;
	}
}

?>