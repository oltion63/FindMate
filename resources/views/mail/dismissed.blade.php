<!-- resources/views/mail/dismissed.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Dismissed</title>
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
            color: #991b1b;
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
            color: #991b1b;
        }
        .info-box {
            background-color: #fef2f2;
            border-left: 4px solid #991b1b;
            padding: 16px;
            margin-bottom: 20px;
            text-align: left;
            border-radius: 4px;
        }
        .info-box p {
            margin: 4px 0;
            font-size: 0.95rem;
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
    <h1>Report Review Outcome</h1>
    <p>Hello,</p>
    <p>
        We’ve reviewed the post you reported and determined that it does not violate our community guidelines. 
        While we understand that certain content may be upsetting or controversial, it doesn't meet the criteria 
        for removal under our current policies.
    </p>

    <div class="info-box">
        <p><strong>📌 Reported Post:</strong> {{ $report->post->tittle }}</p>
        <p><strong>📝 Description Submitted:</strong> {{ $report->description }}</p>
    </div>

    <p>
        We appreciate your concern and thank you for helping keep our platform safe and respectful. 
        If you continue to see behavior that you believe breaks the rules, don’t hesitate to report it again.
    </p>

    <div class="footer">
        <p>Thanks for keeping our community safe,</p>
        <p><strong>The FindMate Team</strong></p>
    </div>
</div>
</body>
</html>
