<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Meeting Details</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f7fafc;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #2563eb;
            padding: 24px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 24px;
        }

        .content p {
            color: #4a5568;
            margin-bottom: 16px;
        }

        .content span {
            font-weight: 600;
        }

        .card {
            background-color: #f9fafb;
            border-left: 4px solid #3b82f6;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .card p {
            margin: 4px 0;
        }

        .card .label {
            text-transform: uppercase;
            font-size: 12px;
            color: #718096;
            font-weight: 500;
        }

        .card .value {
            color: #2d3748;
            font-weight: 500;
        }

        .join-button {
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: #2563eb;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        .join-button:hover {
            background-color: #1d4ed8;
        }

        .footer {
            background-color: #f9fafb;
            padding: 16px;
            text-align: center;
            font-size: 14px;
            color: #718096;
            border-top: 1px solid #e2e8f0;
        }

        .contact {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
        }

        .contact a {
            color: #2563eb;
            text-decoration: none;
        }

        .contact a:hover {
            text-decoration: underline;
        }

        svg {
            width: 20px;
            height: 20px;
            vertical-align: middle;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Meeting Confirmation</h1>
            <!-- Calendar Icon -->
            <svg viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                <line x1="16" y1="2" x2="16" y2="6" />
                <line x1="8" y1="2" x2="8" y2="6" />
                <line x1="3" y1="10" x2="21" y2="10" />
            </svg>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Hello <span>{{ $data['learner_name'] }}</span>,</p>

            <p>
                Your meeting with your mentor, <span>{{ $data['mentor_name'] }}</span>, has been scheduled. Below are
                the details:
            </p>

            <!-- Meeting Details Card -->
            <div class="card">
                <div>
                    <p class="label">Subject</p>
                    <p class="value">{{ $data['subject'] }}</p>
                </div>
                <div>
                    <p class="label">Scheduled Time</p>
                    <p class="value">{{ $data['requested_time'] }}</p>
                </div>
            </div>

            <p>Please use the link below to join the meeting:</p>

            <!-- Join Button -->
            <a href="{{ $data['meeting_link'] }}" class=" join-button" style="color: #ffffff">
                <!-- Link Icon -->
                <svg viewBox="0 0 24 24">
                    <path d="M10 13a5 5 0 0 1 7 7l-1 1a5 5 0 0 1-7-7" />
                    <path d="M14 11a5 5 0 0 0-7-7l-1 1a5 5 0 0 0 7 7" />
                </svg>
                Join Meeting
            </a>

            <div style="padding-top: 16px; border-top: 1px solid #e2e8f0; margin-top: 24px;">
                <p>If you have any questions or need to reschedule, feel free to reach out.</p>

                <div class="contact">
                    <!-- Message Icon -->
                    <svg viewBox="0 0 24 24" style="color: #2563eb;">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                    <a href="mailto:akyanpayy@gmail.com">akyanpayy@gmail.com</a>
                </div>

                <div style="margin-top: 24px;">
                    <p>Best regards,</p>
                    <p style="font-weight: 600; color: #2d3748;">AKyanPayy</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© 2025 AKyanPayy. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
