# PowerShell script to deploy to Railway

Write-Host "Preparing to deploy RocketsHub Domain Sale Page to Railway..." -ForegroundColor Cyan

# Check if Railway CLI is installed
$railwayInstalled = $null
try {
    $railwayInstalled = Get-Command railway -ErrorAction SilentlyContinue
} catch {
    # Command not found
}

if ($null -eq $railwayInstalled) {
    Write-Host "Railway CLI not found. Please install it first:" -ForegroundColor Red
    Write-Host "npm i -g @railway/cli" -ForegroundColor Yellow
    Write-Host "or visit: https://docs.railway.app/develop/cli" -ForegroundColor Yellow
    exit 1
}

# Check if Git is installed
$gitInstalled = $null
try {
    $gitInstalled = Get-Command git -ErrorAction SilentlyContinue
} catch {
    # Command not found
}

if ($null -eq $gitInstalled) {
    Write-Host "Git not found. Please install Git first." -ForegroundColor Red
    Write-Host "Visit: https://git-scm.com/downloads" -ForegroundColor Yellow
    exit 1
}

# Initialize Git repository if not already initialized
if (-not (Test-Path ".git")) {
    Write-Host "Initializing Git repository..." -ForegroundColor Green
    git init
    if ($LASTEXITCODE -ne 0) {
        Write-Host "Failed to initialize Git repository." -ForegroundColor Red
        exit 1
    }
}

# Add all files to Git
Write-Host "Adding files to Git..." -ForegroundColor Green
git add .
if ($LASTEXITCODE -ne 0) {
    Write-Host "Failed to add files to Git." -ForegroundColor Red
    exit 1
}

# Commit changes
Write-Host "Committing changes..." -ForegroundColor Green
git commit -m "Prepare for Railway deployment"
if ($LASTEXITCODE -ne 0) {
    Write-Host "Failed to commit changes. If this is because there are no changes, that's okay." -ForegroundColor Yellow
}

# Login to Railway
Write-Host "Logging in to Railway..." -ForegroundColor Green
railway login
if ($LASTEXITCODE -ne 0) {
    Write-Host "Failed to login to Railway." -ForegroundColor Red
    exit 1
}

# Initialize Railway project if not already linked
$railwayLinked = $false
try {
    $projectInfo = railway status
    if ($projectInfo -match "Project") {
        $railwayLinked = $true
    }
} catch {
    # Not linked
}

if (-not $railwayLinked) {
    Write-Host "Initializing Railway project..." -ForegroundColor Green
    railway init
    if ($LASTEXITCODE -ne 0) {
        Write-Host "Failed to initialize Railway project." -ForegroundColor Red
        exit 1
    }
}

# Deploy to Railway
Write-Host "Deploying to Railway..." -ForegroundColor Green
railway up
if ($LASTEXITCODE -ne 0) {
    Write-Host "Failed to deploy to Railway." -ForegroundColor Red
    exit 1
}

# Open the deployed application
Write-Host "Opening deployed application..." -ForegroundColor Green
railway open
if ($LASTEXITCODE -ne 0) {
    Write-Host "Failed to open deployed application." -ForegroundColor Red
    exit 1
}

Write-Host "Deployment completed successfully!" -ForegroundColor Cyan
Write-Host "To test email functionality, add /test-mail.php?test=1 to your deployed URL." -ForegroundColor Yellow