<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Feedback Request</title>
</head>
<body style="margin:0;padding:0;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;font-size:16px;line-height:1.5;color:#333333;background-color:#f4f4f5;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f4f4f5;">
        <tr>
            <td align="center" style="padding:32px 16px;">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="max-width:600px;width:100%;background-color:#ffffff;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                    <tr>
                        <td style="padding:40px 40px 24px 40px;">
                            <p style="margin:0 0 8px 0;font-size:14px;color:#6b7280;">Dear {{ $client->name }},</p>
                            <p style="margin:0 0 24px 0;">We would appreciate your feedback on the following project.</p>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom:24px;background-color:#f9fafb;border-radius:6px;border:1px solid #e5e7eb;">
                                <tr>
                                    <td style="padding:20px;">
                                        <p style="margin:0 0 8px 0;font-size:12px;color:#6b7280;text-transform:uppercase;letter-spacing:0.5px;">Project</p>
                                        <p style="margin:0 0 12px 0;font-size:18px;font-weight:600;color:#111827;">{{ $project->name }}</p>
                                        @if($project->description)
                                        <p style="margin:0;font-size:14px;color:#4b5563;">{{ $project->description }}</p>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:0 0 24px 0;">Please take a moment to share your experience by clicking the button below.</p>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="border-radius:6px;background-color:#2563eb;">
                                        <a href="{{ config('app.frontend_url') . '/feedback/' . $feedbackLink->token }}" target="_blank" rel="noopener" style="display:inline-block;padding:14px 28px;font-size:16px;font-weight:600;color:#ffffff;text-decoration:none;">Give feedback</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:24px 0 0 0;font-size:13px;color:#6b7280;">This link expires on {{ $feedbackLink->expires_at->format('F j, Y \a\t g:i A') }}.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 40px 40px 40px;">
                            <p style="margin:0;font-size:12px;color:#9ca3af;">Thank you for your time.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <img src="{{ route('public.email.open', $emailLog, true) }}" width="1" height="1" alt="" style="display:block;width:1px;height:1px;border:0;" />
</body>
</html>
