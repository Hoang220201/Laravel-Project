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
    </style>
</head>
<body>
    <table class="container"  width="600">
        <tr>
            <td>
                {{$team_mail['message']}}
            </td>
        </tr>
    </table>
</body>
</html>