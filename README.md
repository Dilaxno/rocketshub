# RocketsHub Domain Sale Page

A landing page for selling the RocketsHub.com domain with a bidding form.

## Deployment on Railway

This project is configured to be deployed on Railway with PHP support. Follow these steps to deploy:

### Prerequisites

1. Create a [Railway account](https://railway.app/)
2. Install the [Railway CLI](https://docs.railway.app/develop/cli)

### Deployment Steps

1. Log in to Railway CLI:
   ```
   railway login
   ```

2. Initialize your project:
   ```
   railway init
   ```

3. Link to your Railway project:
   ```
   railway link
   ```

4. Deploy your project:
   ```
   railway up
   ```

5. Open your deployed application:
   ```
   railway open
   ```

### Environment Variables

If needed, you can set environment variables in the Railway dashboard:

1. Go to your project in the Railway dashboard
2. Click on the "Variables" tab
3. Add any required environment variables

## Email Functionality

The website uses PHP's `mail()` function to send form submissions to your email address (mail.esstafasoufiane@gmail.com).

### Troubleshooting Email Issues

If emails are not being received:

1. Check Railway logs for any errors
2. Verify that Railway's PHP environment supports the `mail()` function
3. Consider using an SMTP library like PHPMailer as an alternative

## Local Development

To run this project locally with PHP:

1. Start a PHP server:
   ```
   php -S localhost:8000
   ```

2. Open your browser and navigate to `http://localhost:8000`