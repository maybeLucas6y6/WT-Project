<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Real estate manager for people looking to buy and sell estates.">
    <link rel="stylesheet" href="/views/mapView.css">
    <title>Register</title>
</head>

<body>
    <div class="big-wrapper">
        <h1>Register</h1>
        <form action="/auth/register" method="post" class="fancy-form">
            <input type="text" id="username" name="username" placeholder="Username" required> <br>
            <input type="text" id="email" name="email" placeholder="Email" required> <br>
            <input type="text" id="phoneNumber" name="phoneNumber" placeholder="Phone number" required> <br>
            <input type="password" id="password" name="password" placeholder="Password" required> <br>
            <input type="submit" value="Register"></button>
        </form>
        <a href="/auth/login" class="fancy-button">Login</a>
    </div>
</body>
</html>