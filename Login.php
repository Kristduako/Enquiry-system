<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="Login.css">
</head>

<body class="body">
    <div class="div">
        <h1>Login 👤</h1>
        <p>Login to your Account</p>

        <form onsubmit="login(event)">
            <input
                type="text"
                id="username"
                placeholder="UserName 👨🏽"
                class="input"
                required
            >
            <br><br>

            <input
                type="password"
                id="password"
                placeholder="password 🗝️"
                class="input"
                required
            >
            <br><br>

            <button type="submit" class="btn">Login</button>

            <p id="message"></p>
        </form>
    </div>
<script src="script.js"></script>
</body>
</html>
