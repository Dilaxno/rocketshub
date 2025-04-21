# Deploying to Railway via Web Interface

Since you're having issues with the CLI deployment, here's how to deploy using Railway's web interface:

## Step 1: Create a GitHub Repository

1. Create a new GitHub repository
2. Push your code to the repository:
   ```
   git init
   git add .
   git commit -m "Initial commit"
   git branch -M main
   git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO_NAME.git
   git push -u origin main
   ```

## Step 2: Deploy on Railway

1. Go to [Railway Dashboard](https://railway.app/dashboard)
2. Click "New Project"
3. Select "Deploy from GitHub repo"
4. Connect your GitHub account if not already connected
5. Select the repository you just created
6. Railway will automatically detect it's a PHP project
7. Click "Deploy"

## Step 3: Configure Environment Variables (if needed)

1. Go to your project in Railway
2. Click on the "Variables" tab
3. Add any environment variables you need

## Step 4: Access Your Deployed Application

1. Go to your project in Railway
2. Click on the "Settings" tab
3. Find the "Domains" section
4. Click "Generate Domain"
5. Click on the generated domain to access your application

## Testing Email Functionality

1. Navigate to your deployed application
2. Add `/test-mail.php?test=1` to the URL
3. This will send a test email to mail.esstafasoufiane@gmail.com
4. Check your email to see if you received the test email

## Troubleshooting

If you encounter issues:

1. Check the logs in the Railway dashboard
2. Try accessing `/phpinfo.php` to see PHP configuration
3. Make sure all files are properly pushed to GitHub