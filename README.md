# PentaDrone
Asynchronous PowerShell Post-exploitation agent based on Mitre Att&ck framework.
Able to automate its post-exploitation process with autopilot mode. Can be used for redteaming and pentesting operations in several ways.

Disclaimer.

This project should be used for authorized testing or educational purposes only.
The main objective behind creating this offensive project was to aid security researchers
and to enhance the understanding of HTTP loader style botnets . 
I hope this project helps to contribute to the malware research community and people can develop efficient counter mesures.
It is the final user's responsibility to obey all applicable local, state and federal laws. 
Authors assume no liability and are not responsible for any misuse or damage caused by this program.

HOW TO
---------

01- set parameter in config.ini (see exemple below)
02- run generator.exe
03- wait 02 minutes after the execution even if the command prompt disappear,
    the generator still working in the background.
04- open output and enjoy various payloads



config.ini parameters:
----------------------
[c2c] : Zombie-master server URL the or Control Center

[usbspreading] : Want to spread the zombie via USB ? 
default is "OFF"

[sleeptime1] : First random time before a zombie contact the zombie-master server 

[sleeptime2] : Second random time before a zombie contact the zombie-master server

[sleeptime3] : Third random time before a zombie contact the zombie-master server

[lnkicon] : Icon for the malicious link generated
exemple: lnkicon=%SystemRoot%\system32\SHELL32.dll, 8

[lnkname] : Name of the malicious link that can execute the payload

[passcrypt] : password for the encrypted payload

[salt] : Salt to use during the encryption process of the payload