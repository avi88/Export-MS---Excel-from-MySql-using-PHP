<?php
ob_start();
session_start();
require_once('sqlConnection.php');//Your DB Connectivity
$db=new sqlConnection();

$uid = mysql_real_escape_string(htmlspecialchars(trim($_REQUEST['uid']))); //Get UserID

//Check isLoggedIn
if($uid!=''){
$sel="select product,price,tareek from product_added where uid='$uid'";//fetch whatever you want
$qryy=mysql_query($sel);
while($row=mysql_fetch_array($qryy)){
$product=$row['product'];
$price=$row['price'];
$tareek=$row['tareek'];


	$data[]= array(		
				"Product Name" =>$product,
				"Price" =>$price, 
				"Date" =>$tareek		
	         );
	
}
	function filterData(&$str)
	{
		$str = preg_replace("/\t/", "\\t", $str);
		$str = preg_replace("/\r?\n/", "\\n", $str);
		if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
	}
	
	// file name for download
	$fileName = "codexworld_export_data" . date('Ymd') . ".xls";
	
	// headers for download
	header("Content-Disposition: attachment; filename=\"$fileName\"");
	header("Content-Type: application/vnd.ms-excel");
	
	$flag = false;
	foreach($data as $row) {
		if(!$flag) {
			// display column names as first row
			echo implode("\t", array_keys($row)) . "\n";
			$flag = true;
		}
		// filter data
		array_walk($row, 'filterData');
		echo implode("\t", array_values($row)) . "\n";
	}
	
	exit;
}else{
	echo "Error!";
}
?>