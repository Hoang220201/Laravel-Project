<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Thank You</title>
    <style>
        / CSS styles for the email template /
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
        }
        .container {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            color: #555555;
            font-size: 16px;
            line-height: 24px;
        }
    </style>
</head>
<body>
    <table class="container"  width="600">
        <tr>
            <td>
                <h1>Thank You for Reaching Us</h1>
                <p>Dear {{$customer_mail['name']}},</p>
                <p>Thank you for contacting us. We have received your message and our team will get back to you soon with a response.</p>
                <p>In the meantime, if you have any further questions, feel free to reach out to us.</p>
                <p>Best regards,</p>
                <p>CXC</p>
                <p><a href="http://localhost/main/public/home" style="text-decoration: none; color: #ffffff; background-color: #007bff; padding: 10px 20px; display: inline-block; border-radius: 5px;">Visit Our Website</a></p>
            </td>
        </tr>
    </table>
</body>
</html>