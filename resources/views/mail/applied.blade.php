<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Confirmation</title>
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
        .footer {
            margin-top: 24px;
            font-size: 0.875rem;
            color: #6b7280;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Application Received</h1>
    <p>
        Dear <span class="highlight">{{ $application->user->name }}</span>,
    </p>
    <p>
        Thank you for applying for the <span class="highlight">{{ $application->post->tittle }}</span> position
        at <span class="highlight">{{ $application->post->company->name ?? 'the company' }}</span>.
    </p>
    <p>
        Your application has been successfully submitted and is currently under review.
        We will notify you as soon as there are any updates regarding your application status.
    </p>

    <div class="footer">
        <p>Best of luck with your application!</p>
        <p><strong>The FindMate Team</strong></p>
    </div>
</div>
</body>
</html>
