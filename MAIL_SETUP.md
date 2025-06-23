# 📧 DearFuture Mail Setup Guide

## Current Status
✅ **Email system is working!** 
- Currently using `log` mailer (emails are saved to `storage/logs/laravel.log`)
- Beautiful DearFuture-themed email templates are ready
- Test command available: `php artisan mail:test your-email@example.com`

## 🚀 Quick Setup Options

### Option 1: Keep Current Setup (Development)
```bash
# Emails are logged to files - perfect for development
MAIL_MAILER=log
MAIL_FROM_ADDRESS=hello@dearfuture.com
MAIL_FROM_NAME="DearFuture"
```

### Option 2: Mailtrap (Testing)
1. Sign up at [mailtrap.io](https://mailtrap.io)
2. Create a new inbox
3. Get SMTP credentials
4. Update your `.env`:
```bash
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@dearfuture.com
MAIL_FROM_NAME="DearFuture"
```

### Option 3: Gmail (Production)
1. Enable 2-factor authentication on your Gmail account
2. Generate an App Password: Google Account → Security → App Passwords
3. Update your `.env`:
```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="DearFuture"
```

### Option 4: SendGrid (Production)
1. Sign up at [sendgrid.com](https://sendgrid.com)
2. Get your API key
3. Update your `.env`:
```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@yourdomain.com
MAIL_FROM_NAME="DearFuture"
```

## 🧪 Testing

### Test Current Setup
```bash
php artisan mail:test your-email@example.com
```

### Check Logs
```bash
tail -f storage/logs/laravel.log
```

### Test with Real SMTP
After configuring SMTP, test with:
```bash
php artisan mail:test your-email@example.com
```

## 📧 Email Features

### What Gets Sent
- **Capsule Unlock Notifications**: When a time capsule is ready to be viewed
- **Beautiful Design**: Custom DearFuture theme with gradients and branding
- **Responsive**: Works on all devices and email clients

### Email Content
- Personalized greeting
- Capsule title and unlock date
- Direct link to view the capsule
- Beautiful call-to-action button
- Professional footer

## 🔧 Configuration

### Environment Variables
```bash
# Required
MAIL_MAILER=log|smtp|sendmail|mailgun|ses|postmark|resend
MAIL_FROM_ADDRESS=hello@dearfuture.com
MAIL_FROM_NAME="DearFuture"

# For SMTP
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

### Queue Configuration
Emails are queued for better performance. Make sure to run:
```bash
php artisan queue:work
```

## 🎨 Customization

### Email Theme
- Location: `resources/views/vendor/mail/html/themes/dearfuture.css`
- Colors: Indigo to purple gradients
- Font: System fonts for best compatibility

### Email Templates
- Location: `resources/views/vendor/mail/`
- Customizable header, body, and footer
- Markdown support for rich content

## 🚨 Troubleshooting

### Common Issues
1. **Emails not sending**: Check SMTP credentials
2. **Emails in spam**: Configure SPF/DKIM records
3. **Queue not working**: Run `php artisan queue:work`
4. **Template not loading**: Clear cache with `php artisan config:clear`

### Debug Commands
```bash
# Test mail configuration
php artisan mail:test

# Check queue status
php artisan queue:work --verbose

# Clear all caches
php artisan config:clear
php artisan view:clear
php artisan cache:clear
```

## 📋 Next Steps

1. **Choose your mail provider** from the options above
2. **Update your `.env` file** with the chosen configuration
3. **Test the setup** with `php artisan mail:test`
4. **Deploy and enjoy** beautiful time capsule notifications!

---

**Need help?** Check the Laravel documentation or contact support. 