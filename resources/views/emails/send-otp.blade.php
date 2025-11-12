<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code For Verification</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f7f6;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f7f6;">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; margin-top: 40px; margin-bottom: 40px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">

                    <tr>
                        <td align="center" style="padding: 40px 30px 20px 30px;">
                            <img src={{ asset('logo.png') }} alt="TransformBD Edtech Logo" width="180" style="display: block;">
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px 40px 40px 40px;">
                            <h1 style="font-size: 24px; font-weight: bold; color: #333333; margin-top: 0; margin-bottom: 20px;">
                                Your Verification Code
                            </h1>
                            
                            <p style="font-size: 16px; color: #555555; line-height: 1.5; margin-bottom: 25px;">
                                Hello,
                            </p>
                            
                            <p style="font-size: 16px; color: #555555; line-height: 1.5; margin-bottom: 25px;">
                                Please use the following One-Time Password (OTP) to complete your verification. This code is valid for 10 minutes.
                            </p>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" style="padding: 20px 10px; background-color: #f0f5ff; border-radius: 6px;">
                                        <span style="font-size: 36px; font-weight: bold; color: #0056b3; letter-spacing: 4px; line-height: 1;">
                                            {{ $otp }}
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 16px; color: #555555; line-height: 1.5; margin-top: 30px; margin-bottom: 0;">
                                If you did not request this code, you can safely ignore this email.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding: 20px 40px; background-color: #fafafa; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                            <p style="font-size: 12px; color: #888888; margin: 0;">
                                &copy; {{ date('Y') }} TransformBD Edtech. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>