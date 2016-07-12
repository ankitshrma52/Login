<?php 
require_once(ABSPATH.'wp-config.php'); 

//echo $path = '../../../../wp-config.php';

//$table_name = $wpdb->prefix ."Registration";

$table_name = "Registration";

$sql = "create tbale $table_name(
		id int(4) auto_increment,
		first_name varchar(50),
		last_name varchar(50),
		user_name varcahr(50),
		email varchar(50),
		PRIMARY KEY(id)
		);
)";
if($sql){echo "Success";}else{echo "Error";}

//global $wpdb;

//$wpdb->insert($table_name,array('first_name'=>$_POST['first_name'],'last_name'=>$_POST['last_name'],'user_name'=>$_POST['user_name'],'email'=>$_POST['email']))


?>