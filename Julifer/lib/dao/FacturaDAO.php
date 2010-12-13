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

     $list = $this->filteredList(" id = '$id' ", "");
     return  $list[0];

   }

   function delete(&$vo) {
 
     $query = "DELETE FROM  $this->TABLE_NAME WHERE id = $vo->id "; 
   	 $result = mysql_query($query, $this->conn) or db__showError();
   }

   function filteredList ($filter, $orderby) {
        $list =  array () ;
        $query = "SELECT * , DATE_FORMAT(fecha,  '%Y-%m-%d') as cfecha  FROM  $this->TABLE_NAME ";
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
     $vo->vehiculo = $result['idvehiculo'];
     $vo->mecanica = $result['mecanica'];
	 $vo->totalMecanica = $result['totalmecanica'];
	 $vo->pintura = $result['pintura'];
	 $vo->totalPintura = $result['totalpintura'];
     
     $list =  array () ;
     $query2 = "SELECT * FROM  materialFacturados WHERE idfactura = $vo->id ";
   	 $result2 = mysql_query($query2, $this->conn) or db__showError();

        if ($myrow2 = mysql_fetch_array($result2)) {
            do {
                $element = new MaterialFacturado ();
                $element->cantidad = $myrow2['cantidad'];
                $element->id = $myrow2['id'];
                $element->servicio = $myrow2['idservicio'];
                array_push($list,$element);
            } while ($myrow2 = mysql_fetch_array($result2));
        }
      mysql_free_result($result2);
      $vo->servicios = $list;
   }

   function update(&$vo) {
   	#execute update statement here
   	$query = "UPDATE $this->TABLE_NAME SET fecha = '$vo->fecha' , idvehiculo = '$vo->vehiculo',   ". 
   			 " mecanica = '$vo->mecanica', totalmecanica = '$vo->totalMecanica', ".
   			 " pintura= '$vo->pintura', totalpintura= '$vo->totalPintura' WHERE id = '$vo->id' ";
   	$result = mysql_query($query, $this->conn) or db__showError();
   	$this->insertServiciosFacturados($vo->id, $vo->servicios, true);
   }

   function insert(&$vo) {

   	$query = "INSERT INTO $this->TABLE_NAME (fecha, idvehiculo , mecanica, totalmecanica, pintura, totalpintura) " .
   			 "VALUES ( '$vo->fecha' , '$vo->vehiculo' , '$vo->mecanica' , '$vo->totalMecanica' , '$vo->pintura' , '$vo->totalPintura') ";
   	$result = mysql_query($query, $this->conn) or db__showError();
    $idFactura = mysql_insert_id($this->conn);
    $this->insertServiciosFacturados($idFactura, $vo->servicios, false);
   
   }
   
   
   function insertServiciosFacturados ($idFactura, $servicios, $limpiar) {
   	    
   		if ($limpiar) {	
   			$query = "DELETE FROM materialFacturados  " . 
   	  		         " WHERE idfactura = $idFactura  ";
   			$result = mysql_query($query, $this->conn) or db__showError();
   	    }
   	    
   		foreach ( $servicios as $servicioFacturado) {
   			
   			$servicioId = $servicioFacturado->servicio;
   			$cantidad = $servicioFacturado->cantidad;
   			
   	  		$query = "INSERT INTO materialFacturados (idfactura, idservicio, cantidad) " . 
   	  		         " VALUES ( $idFactura , '$servicioId', $cantidad) ";
   			$result = mysql_query($query, $this->conn) or db__showError();
   		}
   }
 }

?>