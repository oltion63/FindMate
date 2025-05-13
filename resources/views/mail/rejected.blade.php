<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Update</title>
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
            color: #b91c1c;
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
            color: #b91c1c;
        }
        .button {
            display: inline-block;
            background-color: #4b5563;
            color: white;
            padding: 12px 24px;
            font-size: 1rem;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        .button:hover {
            background-color: #1f2937;
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
    <h1>Application Update</h1>
    <p>
        Dear <span class="highlight">{{ $application->user->name }}</span>,
    </p>
    <p>
        We appreciate your interest in the <span class="highlight">{{ $application->post->tittle }}</span> position at
        <span class="highlight">{{ $application->post->company->name ?? 'the company' }}</span>.
    </p>
    <p>
        After careful consideration, we regret to inform you that your application was **not selected** at this time.
    </p>
    <p>
        Please don't be discouraged. New opportunities arise frequently, and we encourage you to explore
        other job openings that match your skills and experience.
    </p>

    <a href="{{ route('jobs.index') }}" class="button">
        Browse More Jobs
    </a>

    <div class="footer">
        <p>Thank you for using FindMate.</p>
        <p><strong>The FindMate Team</strong></p>
    </div>
</div>
</body>
</html>
