Function ModReconCommand {
			function registry_values($regkey, $regvalue,$child) 
			{ 
			if ($child -eq "no"){$key = get-item $regkey} 
			else{$key = get-childitem $regkey} 
			$key | 
			ForEach-Object { 
			$values = Get-ItemProperty $_.PSPath 
			ForEach ($value in $_.Property) 
			{ 
			if ($regvalue -eq "all") {$values.$value} 
			elseif ($regvalue -eq "allname"){$value} 
			else {$values.$regvalue;break} 
			}}}
			$output = "------------------ Computer -----------------------------`r`n"
			echo "0%"
			$output = $output + "`n`n Hostname:`n" + ((hostname)  -join "`r`n")
			$output = $output + "`n`n IP Address:`n" + ((ipconfig /all)  -join "`r`n")		
			$output = $output + "`n`n Domain Name:`n" + ((registry_values "hklm:\SOFTWARE\Microsoft\Windows\CurrentVersion\Group Policy\History\" "all" "no")  -join "`r`n") 
			$output = $output + "`n`n System:`n" + (((Get-WmiObject -class Win32_OperatingSystem).Caption)  -join "`r`n")
			$output_tmp = Get-WmiObject -Class Win32_Volume | Select DriveLetter,@{Label="FreeSpace (In GB)";Expression={$_.Freespace/1gb}},@{Label="Capacity (In GB)";Expression={$_.Capacity/1gb}},DeviceID,Label |Format-Table -AutoSize		
			$output = $output + "`n`n Disk:`n" + $output_tmp 
			echo "10%"
			$output = $output + "`n`n ------------------ Users -------------------------------`r`n"
			$output = $output + "`n`n Logged in users:`n" + ((registry_values "hklm:\software\microsoft\windows nt\currentversion\profilelist" "profileimagepath") -join "`r`n") 
			$output = $output + "`n`n Account Policy:`n" + ((net accounts)  -join "`r`n") 
			$output = $output + "`n`n Local users:`n" + ((net user)  -join "`r`n") 
			$output = $output + "`n`n Local Groups:`n" + ((net localgroup)  -join "`r`n") 
			echo "20%"
			$output = $output + "`n`n ------------------ Network ------------------------------`r`n"
			$output = $output + "`n`n Network config:`n" + ((ipconfig -all)  -join "`r`n")
			$output = $output + "`n`n ARP Cache:`n" + ((arp -a)  -join "`r`n")
			echo "25%"
			$output = $output + "`n`n Open connections:`n" + ((netstat -b -o 5)  -join "`r`n")
			$output = $output + "`n`n Running Services:`n" + ((net start) -join "`r`n")
			$output = $output + "`n`n WLAN Info:`n" + ((netsh wlan show all)  -join "`r`n") 
			echo "30%"
			$output = $output + "`n`n ------------------ Shares -------------------------------`r`n"
			$output = $output + "`n`n Computers:`n" + ((net view)  -join "`r`n")
			$output = $output + "`n`n Shared folder:`n" + ((net share)  -join "`r`n") 
			$output = $output + "`n`n Shares on the machine:`n" + ((registry_values "hklm:\SYSTEM\CurrentControlSet\services\LanmanServer\Shares" "all" "no")  -join "`r`n") 
			echo "50%"
			$output = $output + "`n`n ------------------ Softwares & downloads ---------------`r`n"
			$output = $output + "`n`n Applications:`n" + ((Get-WmiObject -Class Win32_Product | Select-Object -Property Name| out-string)  -join "`r`n")
			$output = $output + "`n`n Downloads:`n" + ((dir C:\Users\*\Downloads\* -Recurse | Select Name, CreationTime, LastAccessTime, Attributes )  -join "`r`n") 
			echo "70%"
			$output = $output + "`n`n ------------------ Security ----------------------------`r`n"
			$output = $output + "`n`n Firewall:`n" + ((netsh firewall show state)  -join "`r`n") 
			$output = $output + "`n`n Antivirus:`n" + ((Get-WmiObject -Namespace root\SecurityCenter2 -Class AntiVirusProduct | out-string)  -join "`r`n") 
			echo "100%"
			
			$output
			}
ModReconCommand 