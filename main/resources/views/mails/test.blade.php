<!DOCTYPE html>
<html>
<head>
  <title>Email Template</title>
  <style>
    /* Add your custom styles here */
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
    }
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
    }
    .header {
      background-color: #f2f2f2;
      padding: 10px;
      text-align: center;
    }
    .content {
      margin-top: 20px;
    }
    .footer {
      background-color: #f2f2f2;
      padding: 10px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Your Email Heading</h1>
    </div>
    <div class="content">
      <p>Hello, {{$customer_mail['name']}} your email is {{$customer_mail['email']}}</p>
      <p>This is the body of your email. You can customize it with your own text and formatting.</p>
      <p>Feel free to add more paragraphs or include any other HTML elements.</p>
    </div>
    <div class="footer">
      <p>Thank you for reading!</p>
    </div>
  </div>
</body>
</html>
