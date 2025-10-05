<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Setup - Transcript System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 5px 5px;
        }
        .button {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background-color: #218838;
        }
        .info-box {
            background-color: #e9ecef;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Transcript System</h1>
        <p>Password Setup Required</p>
    </div>
    
    <div class="content">
        <h2>Hello {{ $student->first_name }} {{ $student->surname }},</h2>
        
        <p>You have successfully verified your identity in our transcript system. To complete the process and access your account, you need to set up a password.</p>
        
        <div class="info-box">
            <strong>Your Login Details:</strong><br>
            <strong>Username:</strong> {{ $username }}<br>
            <strong>Email:</strong> {{ $student->email }}
        </div>
        
        <p>Click the button below to set up your password:</p>
        
        <a href="{{ $resetUrl }}" class="button">Set Up Password</a>
        
        <p>If the button doesn't work, you can copy and paste this link into your browser:</p>
        <p style="word-break: break-all; color: #007bff;">{{ $resetUrl }}</p>
        
        <div class="info-box">
            <strong>Important:</strong>
            <ul>
                <li>This link will expire in 24 hours</li>
                <li>You can only use this link once</li>
                <li>Your password must be at least 8 characters long</li>
                <li>After setting up your password, you can log in using your username and password</li>
            </ul>
        </div>
        
        <p>If you didn't request this password setup, please ignore this email or contact our support team.</p>
        
        <p>Best regards,<br>
        Transcript System Team</p>
    </div>
    
    <div class="footer">
        <p>This is an automated email. Please do not reply to this email address.</p>
        <p>If you need assistance, please contact our support team.</p>
    </div>
</body>
</html>