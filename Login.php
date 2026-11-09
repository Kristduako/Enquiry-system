
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Login.css">
</head>

<body class="body">

    <div class="div">

        <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" height="48px" width="48px" fill="#000000"><path d="M18.6,21.85q-2.1-2.1-2.1-5.4t2.1-5.4T24,8.95t5.4,2.1t2.1,5.4t-2.1,5.4T24,23.95t-5.4-2.1ZM8,40V35.3q0-1.9 0.95-3.25T11.4,30q3.35-1.5 6.42-2.25T24,27t6.15,0.77T36.55,30q1.55,0.7 2.5,2.05T40,35.3V40H8Zm3-3H37V35.3q0-0.8-0.48-1.52T35.35,32.7q-3.2-1.55-5.85-2.13T24,30t-5.55,0.57T12.6,32.7q-0.7,0.35-1.15,1.07T11,35.3V37ZM27.23,19.67q1.27-1.27 1.27-3.22t-1.27-3.22T24,11.95t-3.22,1.28T19.5,16.45t1.28,3.22T24,20.95t3.23-1.28ZM24,16.45ZM24,37Z"/></svg></div>

        <h1>Welcome Back!</h1>
        <p class="subtitle">Login to access your account</p>

        <form onsubmit="login(event)">

            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                placeholder="Enter your username"
                class="input"
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                placeholder="Enter your password"
                class="input"
                required
            >

            <button type="submit" class="btn">
                Login →
            </button>

            <p id="message"></p>

        </form>

        <p class="footer">
            Secure Login | Welcome Back
        </p>

    </div>

    <script src="script.js"></script>

</body>
</html>
