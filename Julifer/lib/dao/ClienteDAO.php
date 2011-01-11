<?php

class ClienteDAO  {
   var $conn;
   var $TABLE_NAME = 'clientes';

   function ClienteDAO(&$conn) {
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
                $element = new Cliente ();
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
   }

   function update(&$vo) {
   	#execute update statement here
   	$fieldsStr = "";
   	$counter = 0;
   	foreach($vo as $key => $value) {
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
    * Searches a list of clients fitting the criteria based on client an
    * vehicle objects.
    * 
    * @param $vo
    * @param $client
    */
   function search($vo, $client) {
   	$where = "";

   	$vo_prefix = "clientes";
   	$vehicle_prefix = "vehiculos";
    $counter = 0;
   	foreach($vo as $key => $value) {
   		if ( $value == "" ) {
   			continue;
   		}
   		
   		if ($counter > 0) {
   			$where .= " or ";
   		}
   		$where .= "$vo_prefix.$key like '%$value%'";
   		$counter++;
   	}
   	
   	// Client
    $counter2 = 0;
   	foreach($client as $key => $value) {
   		if ( $value == "" ) {
   			continue;
   		}
   		
   		if ($counter2 > 0 || $counter > 0) {
   			$where .= " or ";
   		}
   		
   		$where .= "$vehicle_prefix.$key like '%$value%'";
   		$counter2++;
   	}
   	
   	if ($counter2 >0){
   		$where .= " and vehiculos.idcliente=clientes.id";
   	}
   	
     $list =  array () ;
     $query = "SELECT distinct clientes.* FROM  $this->TABLE_NAME, vehiculos";
     if ($where != "") {
     	$query .= " WHERE $where";
     }
     
     $result = mysql_query($query,$this->conn) or db__showError();

     if ($myrow = mysql_fetch_array($result)) {
       do {
         $element = new Cliente ();
         $this->getFromResult($element, $myrow);
         array_push($list,$element);
       } while ($myrow = mysql_fetch_array($result));
     }
        
     mysql_free_result($result);
     return $list; 
   }
 }

?>