<?php # default cmd for every new computers.include("conn.php");if(isset($_GET['pc'])) {	$pc=addslashes(html_entity_decode($_GET['pc'])); 	$test = mysqli_query($bdd, "SELECT pc FROM computer WHERE pc='$pc'");		while($tabl=mysqli_fetch_array($test)){   		$valid = $tabl['pc'];			}			if(empty($valid)){		echo 'nothing';	}else {		echo 'fine';	}}mysqli_close($bdd); ?>