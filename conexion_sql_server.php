<?php
$serverName = '.\SQLEXPRESS';
$connectionInfo = array("Database"=>"C:\MyBusinessDatabase\MyBusinessPOS2012.mdf", "UID"=>"sa", "PWD"=>"12345678", "CharacterSet"=>"UTF-8");
$conn_sis =  sqlsrv_connect($serverName, $connectionInfo);
if(!$conn_sis){
  echo "fallo en la conexion";
  die(print_r(sqlsrv_errors(), true));
}
 ?>
