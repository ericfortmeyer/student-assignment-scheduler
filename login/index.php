<!DOCTYPE html>
<html lang="en">
    <head>
        <title>JW Virtual Assistant</title>
        <meta name="theme-color" content="#ffffff" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Author: jwvirtualassistant.com community,
            LAMM Scheduling App developed by the community" />
        <link rel="manifest" href="/manifest.json" />
        <link rel="icon" href="/resources/images/icon-192.png" />
        <link rel="apple-touch-icon" href="/resources/images/icon-192.png" />
        <link  rel="preload" as="style" onload="this.rel='stylesheet'" href="/dist/bundle.min.css" type="text/css" />
        <style>
            form button {
                font-size: 1rem;
                color: var(--black);
                padding: 1rem 4rem;
                appearance: none;
                border: 1px solid var(--primary);
                margin: 2rem auto;
            }
        </style>
    </head>
    <body>
        <h1>
            JW Virtual Assistant
        </h1>
        <form id="loginForm" method="post" action="#">
            <header>
            </header>
            <section>
                <h2 style="color:white">
                    Login
                </h2>
                <div>
                    <label for="username">
                        User name
                    </label>
                    <input type="text" id="username" name="username" />
                </div>
                <div>
                    <label for="password">
                        Password
                    </label>
                    <input type="password" id="password" name="password" />
                </div>
                <p>
                    <a href="#">Create an account</a>
                </p>
                <button type="submit">Submit</button>
            </section>
            <input type="hidden" name="grant_type" value="password" />
            <input type="hidden" name="client_id" value="testclient2" />
        </form>
        <script type="text/javascript" src="/login.js" async></script>
    </body>
</html>
