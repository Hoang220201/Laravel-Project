<!DOCTYPE html>
<html>
<head>
  <title>Email Template</title>
  <style>
    /* Add your custom styles here */
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      margin: 10px auto;
      padding: 20px;
      background-color: #ddd;
    }

    .container-content {
      background-color: white;
      padding: 20px; 
      text-align: center;
    }

    .header {
      padding: 10px;
      text-align: center;
      font-size: 20px;
      color: #ffd971;
      background-color: #355e3b;
      width: 100%;
    }
    .content {
      margin-top: 20px;
    }

    .responsive-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 16px;
      transform: skew(-10deg);
    }
    .responsive-table th,
    .responsive-table td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: center;
      transform: skew(10deg);
    }
    a {
      text-decoration: none;
      cursor: pointer;
      color: red;
    }
  
            
  </style>
</head>
<body style="background-color: #ddd;">
  <table class="container">
    <tr>
      <td>
        <table class="header">
          <tr>
            <td>
              <h1>CurrencyxChange</h1>
            </td>
          </tr>
        </table>
        <table class="container-content">
          <tr>
            <td>
              <table class="content">
                <tr >
                  <td style="font-size:28px">
                    The exchange rate at <b>{{$customer_mail['date']}}</b> was
                  </td> 
                </tr>
                <tr>
                  <td style="font-size:28px">
                   <b> 1 {{$customer_mail['base']}}</b>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table class="responsive-table">
                      <thead>
                        <tr>
                          <th>Currencies</th>
                          <th>Rate</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($customer_mail['rates'] as $item)
                        <tr>
                          <td>{{$item->rate_code}}</td>
                          <td>{{$item->rate}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    <p>You are receiving this email because you registered on our website. To unsubscribe <a href="http://localhost/main/public/unsubscribe?token={{$customer_mail['token']}}">Click here</a>.</p>
                    <p style="font-size: 13px;">&copy; 2022 CXC All rights reserved.</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
