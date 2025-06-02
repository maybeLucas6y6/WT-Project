<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form action="/auth/login" method="post">
        <input type="text" id="username" name="username" placeholder="Username" required> <br>
        <input type="password" id="password" name="password" placeholder="Password" required> <br>
        <button type="submit">Login</button>
    </form>
</body>

</html>