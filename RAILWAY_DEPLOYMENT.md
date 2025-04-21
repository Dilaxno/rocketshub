# Deploying to Railway

This guide will walk you through deploying your RocketsHub Domain Sale Page to Railway with PHP support.

## Prerequisites

1. Create a [Railway account](https://railway.app/) if you don't have one
2. Install the [Railway CLI](https://docs.railway.app/develop/cli)
3. Make sure you have Git installed

## Deployment Steps

### 1. Initialize a Git Repository (if not already done)

```bash
git init
git add .
git commit -m "Initial commit"
```

### 2. Log in to Railway

```bash
railway login
```

This will open a browser window where you can authenticate with your Railway account.

### 3. Create a New Project on Railway

```bash
railway init
```

Follow the prompts to create a new project.

### 4. Link Your Local Project to Railway

```bash
railway link
```

This will connect your local project to the Railway project you just created.

### 5. Deploy Your Project

```bash
railway up
```

This will deploy your project to Railway.

### 6. Open Your Deployed Application

```bash
railway open
```

This will open your deployed application in a browser.

## Testing Email Functionality

After deployment, you can test if the email functionality is working:

1. Navigate to your deployed application
2. Add `/test-mail.php?test=1` to the URL
3. This will send a test email to mail.esstafasoufiane@gmail.com
4. Check your email to see if you received the test email

## Troubleshooting

### Email Issues

If emails are not being sent:

1. Check the Railway logs:
   ```bash
   railway logs
   ```

2. Look for any errors related to the `mail()` function

3. Railway might have restrictions on the PHP `mail()` function. In that case, you might need to use an SMTP service like SendGrid, Mailgun, or PHPMailer.

### Deployment Issues

If you encounter issues during deployment:

1. Check the Railway logs:
   ```bash
   railway logs
   ```

2. Make sure your project structure is correct

3. Verify that all required files are included in your Git repository

## Updating Your Deployment

To update your deployment after making changes:

1. Commit your changes:
   ```bash
   git add .
   git commit -m "Update description"
   ```

2. Deploy the changes:
   ```bash
   railway up
   ```

## Additional Resources

- [Railway Documentation](https://docs.railway.app/)
- [PHP on Railway](https://docs.railway.app/deploy/php)
- [Railway CLI Commands](https://docs.railway.app/develop/cli)