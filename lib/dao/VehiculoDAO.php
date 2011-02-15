<?php

class VehiculoDAO  {
	var $conn;
	var $TABLE_NAME = 'vehiculos';

	function VehiculoDAO(&$conn) {
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

		$list = $this->filteredList(" id = '$id' ", "");
		return  $list[0];

	}

	function delete(&$vo) {

		$query = "DELETE FROM  $this->TABLE_NAME WHERE id = $vo->id ";
		$result = mysql_query($query, $this->conn) or db__showError();
	}

	function filteredList ($filter, $orderby) {
		$list =  array () ;
		$query = "SELECT * FROM  $this->TABLE_NAME ";
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
				$element = new Vehiculo ();
				$this->getFromResult($element, $myrow);
				array_push($list,$element);
			} while ($myrow = mysql_fetch_array($result));
		}
		mysql_free_result($result);
		return $list;
	}


	#-- private functions



	function getFromResult(&$vo, $result) {
		$vo->dump($result);
		$vo->cliente = $result['idcliente'];
	}

	function update(&$vo) {
		#execute update statement here
		$fieldsStr = "";
		$counter = 0;
		foreach($vo as $key => $value) {

			if ($key == "cliente") {
				$key = "idcliente";
			}

			if ($counter > 0) {
				$fieldsStr .= ", ";

			}
			$fieldsStr .= "$key = '$value'";
			$counter++;
		}

		$query = "UPDATE $this->TABLE_NAME SET $fieldsStr WHERE id = '$vo->id' ";
		$result = mysql_query($query, $this->conn) or db__showError();
	}

	function insert(&$vo) {
		#generate id (from Oracle sequence or automatically)
		#insert record into db
		#set id on vo
		$fieldsStr = "";
		$valuesStr = "";
			
		$counter = 0;
		foreach($vo as $key => $value) {

			if ($key == "cliente") {
				$key = "idcliente";
			}

			if ( $value != "" ) {

				if ($counter > 0) {
					$fieldsStr .= ", ";
					$valuesStr .= ", ";
				}
					
				$fieldsStr .= "$key";
				$valuesStr .= "'$value'";
				$counter++;
			}
		}

		$query = "INSERT INTO $this->TABLE_NAME ($fieldsStr) VALUES ($valuesStr) ";
		$result = mysql_query($query, $this->conn) or db__showError();
	}

	/**
	 * Searches a list of vehicles fitting the criteria based on client an
	 * vehicle objects.
	 *
	 * @param $vo
	 * @param $client
	 */
	function search($vo, $client) {
		$where = "";

		$vo_prefix = "vehiculos";
		$cliente_prefix = "clientes";

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
			

		// Defining final query
		$list =  array () ;
		$query = "SELECT distinct vehiculos.* FROM  $this->TABLE_NAME, clientes";

		if ($where != "") {
			//Joins
			$where .= " and vehiculos.idcliente=clientes.id";
			$query .= " WHERE $where";
		}
			
		
		$result = mysql_query($query,$this->conn) or db__showError();

		if ($myrow = mysql_fetch_array($result)) {
			do {
				$element = new Vehiculo();
				$this->getFromResult($element, $myrow);
				array_push($list,$element);
			} while ($myrow = mysql_fetch_array($result));
		}

		mysql_free_result($result);
		return $list;
	}
}
?>