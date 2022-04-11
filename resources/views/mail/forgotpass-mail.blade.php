<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Hello, {{ $email_data['name'] }}</h1>
    <a href="http://127.0.0.1:8000/ResetPass?code={{ $email_data['password'] }}&email={{ $email_data['email'] }}">Click Here to reset your password</a>
</body>
</html>