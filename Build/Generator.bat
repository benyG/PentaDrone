echo off
PowerShell.exe -Exec Bypass -NoL .\generator.ps1
del .\note.txt /S /Q
del .\pad.txt /S /Q
