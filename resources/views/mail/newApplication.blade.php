<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Application Received</title>
    <style>
        body {
            background-color: #f3f4f6;
            color: #1f2937;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            padding: 24px;
            text-align: center;
        }
        h1 {
            color: #06401c;
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 20px;
        }
        p {
            color: #4a5568;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .highlight {
            font-weight: bold;
            color: #06401c;
        }
        .button {
            display: inline-block;
            background-color: #06401c;
            color: white;
            padding: 12px 24px;
            font-size: 1rem;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        .button:hover {
            background-color: #042d14;
        }
        .footer {
            margin-top: 24px;
            font-size: 0.875rem;
            color: #6b7280;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>New Job Application</h1>
    <p>
        Dear <span class="highlight">{{ $application->post->user->name }}</span>,
    </p>
    <p>
        You have received a new application for your job post
        <span class="highlight">{{ $application->post->tittle }}</span>.
    </p>
    <p>
        Applicant: <span class="highlight">{{ $application->user->name }} {{ $application->user->lastname }}</span>
    </p>
    <p>
        Visit your profile to review the application details and take the next steps.
    </p>

    <a href="{{ route('profilePage') }}" class="button">
        View Application
    </a>

    <div class="footer">
        <p>Thank you for using FindMate!</p>
        <p><strong>The FindMate Team</strong></p>
    </div>
</div>
</body>
</html>
