<?php
	#$extensions_valides = array('png','bmp','txt','jpeg','jpg','docx','doc','pdf','ppt','pptx','xls','xlsx','zip','pst');
	if(isset($_GET['pc'])) { $pc=addslashes(html_entity_decode($_GET['pc'])); }
	if (!file_exists("exfil/$pc")) {
		mkdir("exfil/$pc", 0777, true);
		}	
	if (isset($_FILES['file']['name'])){
	$size=$_FILES['file']['size'];
	$extension_upload = strtolower( substr( strrchr($_FILES['file']['name'], '.')  ,1)  );
	$nom = basename($_FILES['file']['name']);
	$nom2 = "exfil/$pc/{$nom}.{$extension_upload}";
	move_uploaded_file($_FILES['file']['tmp_name'],$nom2);
	}
?>
ok !