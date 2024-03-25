# Get all files in the current directory that start with "UFC"
$files = Get-ChildItem -File -Recurse | Where-Object { $_.Name -like 'UFC*' }

# Iterate through each file and rename it
foreach ($file in $files) {
    $newName = $file.Name -replace '^UFC', 'UFC'
    $file | Rename-Item -NewName $newName
}

