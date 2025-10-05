<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset & Login Credentials</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        .credentials-box {
            background-color: #e3f2fd;
            border: 2px solid #2196f3;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .credentials-title {
            font-size: 18px;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 15px;
            text-align: center;
        }
        .credential-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #bbdefb;
        }
        .credential-item:last-child {
            border-bottom: none;
        }
        .credential-label {
            font-weight: bold;
            color: #424242;
        }
        .credential-value {
            font-family: 'Courier New', monospace;
            background-color: #f5f5f5;
            padding: 4px 8px;
            border-radius: 4px;
            color: #d32f2f;
            font-weight: bold;
        }
        .reset-button {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
            transition: background-color 0.3s;
        }
        .reset-button:hover {
            background-color: #218838;
            color: white;
        }
        .warning-box {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
        .warning-title {
            font-weight: bold;
            color: #856404;
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            font-size: 14px;
            color: #6c757d;
            text-align: center;
        }
        .steps {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 20px;
            margin: 20px 0;
        }
        .step {
            margin: 10px 0;
            padding-left: 20px;
            position: relative;
        }
        .step::before {
            content: counter(step-counter);
            counter-increment: step-counter;
            position: absolute;
            left: 0;
            top: 0;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
        .steps {
            counter-reset: step-counter;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
            <h2 style="color: #333; margin: 0;">Password Reset & Login Credentials</h2>
        </div>

        <p>Hello <strong>{{ $student->first_name }} {{ $student->surname }}</strong>,</p>

        <p>You requested a password reset for your account. Below are your login credentials and a secure link to reset your password.</p>

        <div class="credentials-box">
            <div class="credentials-title">🔐 Your Login Credentials</div>
            <div class="credential-item">
                <span class="credential-label">Email Address:</span>
                <span class="credential-value">{{ $loginEmail }}</span>
            </div>
            <div class="credential-item">
                <span class="credential-label">Matriculation Number:</span>
                <span class="credential-value">{{ $matricNumber }}</span>
            </div>
        </div>

        <div class="warning-box">
            <div class="warning-title">⚠️ Important Security Information</div>
            <ul style="margin: 0; padding-left: 20px;">
                <li>Keep your login credentials secure and confidential</li>
                <li>The password reset link below expires in 60 minutes</li>
                <li>If you didn't request this reset, please ignore this email</li>
            </ul>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $resetUrl }}" class="reset-button">
                🔑 Reset Your Password
            </a>
        </div>

        <div class="steps">
            <h4 style="margin-top: 0; color: #333;">How to proceed:</h4>
            <div class="step">Click the "Reset Your Password" button above</div>
            <div class="step">Create a new secure password</div>
            <div class="step">Login using your email address and new password</div>
            <div class="step">Complete your transcript application</div>
        </div>

        <p><strong>Alternative Login Options:</strong></p>
        <ul>
            <li>Use your <strong>email address</strong> ({{ $loginEmail }}) and password</li>
            <li>Use your <strong>matriculation number</strong> ({{ $matricNumber }}) for verification</li>
        </ul>

        <div class="footer">
            <p>This email was sent from {{ config('app.name') }} Transcript System.</p>
            <p>If you have any questions, please contact our support team.</p>
            <p style="font-size: 12px; color: #999;">
                This is an automated email. Please do not reply to this message.
            </p>
        </div>
    </div>
</body>
</html>