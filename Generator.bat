echo off
PowerShell.exe -Exec Bypass -NoL .\generator_v2.ps1
del .\note.txt /S /Q
del .\pad.txt /S /Q