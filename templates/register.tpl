<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <h1>Register</h1>
    <form action="/auth/register" method="post">
        <input type="text" id="username" name="username" placeholder="Username" required> <br>
        <input type="text" id="email" name="email" placeholder="Email" required> <br>
        <input type="text" id="phoneNumber" name="phoneNumber" placeholder="Phone number" required> <br>
        <input type="password" id="password" name="password" placeholder="Password" required> <br>
        <button type="submit">Register</button>
    </form>
</body>

</html>