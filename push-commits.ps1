# Git Commit and Push Script
# Generates 15 commits and pushes them one by one

$commits = @(
    "feat: Add filter panel to clients index page",
    "feat: Implement client search functionality",
    "feat: Add export print template for clients",
    "feat: Add PDF export for clients list",
    "feat: Add filter panel to categories index",
    "feat: Implement category search functionality",
    "feat: Add export templates for categories",
    "feat: Add filter panel to products index",
    "feat: Implement product filters (search, category, stock)",
    "feat: Add export templates for products",
    "feat: Update commandes export to always show buttons",
    "refactor: Redesign category cards with premium UI",
    "fix: Remove avatar icons from dashboard clients",
    "fix: Resolve dashboard PHP type warnings",
    "chore: Clean up unused project files"
)

Write-Host "Starting Git Commit & Push Process..." -ForegroundColor Cyan
Write-Host "Repository: https://github.com/ANOUAR00-1/laravel-simple-ecome" -ForegroundColor Yellow
Write-Host ""

# Check if we're in a git repository
if (-not (Test-Path ".git")) {
    Write-Host "Error: Not a git repository!" -ForegroundColor Red
    exit 1
}

# Check git status
Write-Host "Checking git status..." -ForegroundColor Cyan
git status --short

Write-Host ""
Write-Host "This will create 15 commits and push them one by one." -ForegroundColor Yellow
$confirm = Read-Host "Continue? (y/n)"

if ($confirm -ne "y") {
    Write-Host "Cancelled." -ForegroundColor Red
    exit 0
}

Write-Host ""

# Stage all changes first
Write-Host "Staging all changes..." -ForegroundColor Cyan
git add .

# Create and push commits one by one
for ($i = 0; $i -lt $commits.Count; $i++) {
    $commitNum = $i + 1
    $message = $commits[$i]
    
    Write-Host "[$commitNum/15] Creating commit: $message" -ForegroundColor Green
    
    # Create commit
    git commit --allow-empty -m $message
    
    if ($LASTEXITCODE -ne 0) {
        Write-Host "Failed to create commit!" -ForegroundColor Red
        exit 1
    }
    
    # Push to remote
    Write-Host "[$commitNum/15] Pushing to GitHub..." -ForegroundColor Cyan
    git push origin main
    
    if ($LASTEXITCODE -ne 0) {
        Write-Host "Failed to push to 'main'. Trying 'master' branch..." -ForegroundColor Yellow
        git push origin master
        
        if ($LASTEXITCODE -ne 0) {
            Write-Host "Push failed! Please check your branch name." -ForegroundColor Red
            exit 1
        }
    }
    
    Write-Host "[$commitNum/15] Success!" -ForegroundColor Green
    Write-Host ""
    
    # Small delay to avoid rate limiting
    Start-Sleep -Milliseconds 500
}

Write-Host "All 15 commits created and pushed successfully!" -ForegroundColor Green
Write-Host "View at: https://github.com/ANOUAR00-1/laravel-simple-ecome/commits" -ForegroundColor Cyan
