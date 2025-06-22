<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Real estate manager for people looking to buy and sell estates.">
    <link rel="stylesheet" href="/views/mapView.css">
    <title>Login</title>
</head>

<body>
    <form action="/auth/login" method="post">
        <input type="text" id="username" name="username" placeholder="Username" required> <br>
        <input type="password" id="password" name="password" placeholder="Password" required> <br>
        <input type="submit"></input>
    </form>
</body>

</html>