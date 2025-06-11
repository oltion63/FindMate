<!-- resources/views/mail/reviewed.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Reviewed</title>
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
            color: #064e3b;
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
            color: #064e3b;
        }
        .info-box {
            background-color: #ecfdf5;
            border-left: 4px solid #10b981;
            padding: 16px;
            margin-bottom: 20px;
            text-align: left;
            border-radius: 4px;
        }
        .info-box p {
            margin: 4px 0;
            font-size: 0.95rem;
            color: #047857;
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
    <h1>Report Reviewed — Action Will Be Taken</h1>
    <p>Hello <span class="highlight">{{ $report->user->name }}</span>,</p>

    <p>
        Thank you for taking the time to report content that may violate our community guidelines. 
        Our moderation team has carefully reviewed the post, and we’ve determined that it does not align with our policies.
    </p>

    <div class="info-box">
        <p><strong>📌 Reported Post:</strong> {{ $report->post->tittle }}</p>
        <p><strong>📝 Description Submitted:</strong> {{ $report->description }}</p>
    </div>

    <p>
        Appropriate action will be taken, which may include removing the content or applying restrictions 
        to the user responsible. We appreciate your help in maintaining a safe and respectful environment for everyone.
    </p>

    <div class="footer">
        <p>Thank you for making FindMate better,</p>
        <p><strong>The FindMate Team</strong></p>
    </div>
</div>
</body>
</html>
