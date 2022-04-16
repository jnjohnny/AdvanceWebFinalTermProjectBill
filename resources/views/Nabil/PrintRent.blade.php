<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Montly Rent Receipt</h1>
    <hr>
    <h3>Building Code: {{ $BuildingCode}}</h3>
    <h3>Flat Number: {{ $FlatNumber}}</h3>
    <h3>For Month: {{ $month}}</h3>
    <h3>Unit Used: {{ $unitAmount}}</h3>
    <hr>
    <h3>Total Bill: {{ $totalAmount}}</h3>
</body>
</html>