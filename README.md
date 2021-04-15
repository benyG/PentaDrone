---- STILL IN DEV !!! ----

# PentaDrone
Asynchronous PowerShell Post-exploitation agent based on Mitre Att&ck framework.
Able to automate its post-exploitation process with autopilot mode. Can be used for redteaming and pentesting operations in several ways.
<img src="https://github.com/benyG/PentaDrone/raw/master/pnt2.PNG" width="400"></a></p>
DISCLAIMER !!!!!

This project should be used for authorized testing or educational purposes only.
The main objective behind creating this offensive project was to aid security researchers
and to enhance the understanding of HTTP loader style botnets . 
I hope this project helps to contribute to the malware research community and people can develop efficient counter mesures.
It is the final user's responsibility to obey all applicable local, state and federal laws. 
Authors assume no liability and are not responsible for any misuse or damage caused by this program.


<b>HOW TO</b>
---------

- 01- set parameter in config.ini (see exemple below)
- 02- run generator.exe  (it's simply a batch file converted into an EXE with BATCH2EXE so it can trigger AV alert)
- 03- Follow the generator instructions 
- 04- open Package folder 
- 05- The content of folder named "Server" must be uploaded as is on the root of your c2 server (REPLACE EVERYTHING IF NECESSARY)
- 06- The folder named "Client" content various version of your agent so that you can execute it on your victim in many ways
- 07- Execute agent on a test machine and connect to your C2 Server Connect :  http://127.0.0.1/src    login: admin@pnt.com  -  password:  test@123
enjoy !


config.ini parameters:
====  ====  ====  ====  ====  ====  ====  ====  
  
- [getC2] 
URL used by zombies to get and decrypt C2 server URL  (example: Pastebin URL OR http://127.0.0.1/pnt/src/c2.txt )

- [keyreadgetC2]
Key used to decrypt C2 server URL
(example: keyreadgetC2=g0EcufhM3lnJTxRXNAz/oERhiX05JSzBjTkyQUtmYsM= )

- [rootfolder] 
Name of root folder of your C2 server (default=pnt)
You can change it

- [linkfolder]
Name of link folder of your C2 server (default=link)

- [ops]
Name of operation for agents generated will be linked (You must create Operation first (or use Default)
(example: ops=Default )

- [upgradepshell] 
upgradepshell=yes

- [offlinemode] 
offlinemode=yes

- [usbspreading] 
Want to spread the zombie via USB ? 
default is "OFF"
(example: usbspreading=off )

- [autopersist] 
Activate persistence automaticaly when agent touch the zombie for the first time 
(example : autopersist=on  OR   autopersist=off  )

- [defaultpersist] 
Default persistence method to be used (reg or wmi)
(example:  defaultpersist=reg    OR  defaultpersist=wmi    )

- [sleeptime1] 
one of the random time used by the agent before pulling commands from C2
(example: sleeptime1=5)

- [sleeptime2]
one of the random time used by the agent before pulling commands from C2
(example: sleeptime2=10)

- [sleeptime3] 
one of the random time used by the agent before pulling commands from C2
(example: sleeptime3=15)

- [lnkicon] 
Icon for the malicious link generated
exemple: lnkicon=%SystemRoot%\system32\SHELL32.dll, 8

- [exeicon] 
exeicon=

- [evilimage] 
evilimage=

- [lnkname] 
Name of the malicious link that can execute the payload
lnkname=boot.scr

- [passcrypt] 
Encryption key used by the agents generated with that config file
(example: passcrypt=pntMagic@2016 )

- [salt] 
Salt used by the agents generated with that config file
(example: salt=R1284S2dZFj )

- [enddate] 
End date of the operation (the agent will uninstall itself)
(example: enddate=2035-12-31 )

- [workstart]
The hour from which agent activate itself 
(example: workstart=08:00 )

- [workend] 
The hour from which agent de-activate itself 
(example workend=23:00)

- [keyupload]
keyupload=12:00

- [keyupload2]
keyupload2=12:30

- [regkey]
Name of the registry key - can be created for operation
regkey=javafx

- [wmikey] 
Name of the WMI key - can be created for operation
wmikey=winUpdate

- [c2channel] 
C2 Channel (example c2channel=http )

- [obfuscationToken]
Obfuscation command used during the generation of agents with a specific config file
(example:  obfuscationToken=Token\All\1,Encoding\5,Launcher\*\234,Out )


------ CREDITS ----------------------------------

			
			
			
	