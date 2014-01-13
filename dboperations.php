<?php
class dboperations
{
 public function fetchOneRecord($dbHandle,$tablename,$param,$condition,$extrawhere)
 {
 	$options = implode(',',$param);
 	$i=0;
 	$j=0;
 	$where = ''; 	
 	foreach($condition AS $key => $value)
 	{
 	if($j!=$i)
 		{
 		$where .= " AND ";
 		$j=0;
 		}
 		$where .= $key ."='".$value."'";
 		$j = $i+1;
 		 		
 	}
 	$stmt = $dbHandle->prepare("SELECT {$options} FROM {$tablename} where {$where} {$extrawhere}");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
 }
 public function fetchAllRecord($dbHandle,$tablename,$param,$condition,$extrawhere,$orderby)
 {
 	$options = implode(',',$param);
 	$i=0;
 	$j=0;
 	$key = '';
 	$value = '';
 	$where = '';
 	foreach($condition AS $key => $value)
 	{
 	if($j!=$i)
 		{
 		$where .= " AND ";
 		$j=0;
 		}
 		$where .= $key ."='".$value."'";
 		$j = $i+1;
 		 		
 	} 	
 	$stmt = $dbHandle->prepare("SELECT {$options} FROM {$tablename} where {$where} {$extrawhere} {$orderby}");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
 }
 public function updateRecord($dbHandle,$tablename,$param,$condition)
 {
 	$i=0;
 	$j=0;
 	$key = '';
 	$value = '';
 	$where = '';
 	foreach($condition AS $key => $value)
 	{
 	if($j!=$i)
 		{
 		$where .= " AND ";
 		$j=0;
 		}
 		$where .= $key ."='".$value."'";
 		$j = $i+1;
 		 		
 	}
 	$options = implode(',',$param);
 	try {
		$stmt = $dbHandle->prepare("UPDATE $tablename SET {$options} WHERE {$where}");		
	    
	    $stmt->execute();
	   } catch(PDOExecption $e) {
	       print "Error!: " . $e->getMessage() . "</br>";
	    }
 }
 public function insertRecord($dbHandle,$tablename,$columns,$values)
 {
 	$columns = implode(',',$columns);
 	$values = "'".implode("','",$values)."'";
 	echo "INSERT INTO {$tablename} ({$columns}) VALUES($values)";
 	$stmt = $dbHandle->prepare("INSERT INTO {$tablename} ({$columns}) VALUES($values)");
	    try {
	       $stmt->execute();
	    } catch(PDOExecption $e) {
	        print "Error!: " . $e->getMessage() . "</br>";
	    }
 }
}
?>
