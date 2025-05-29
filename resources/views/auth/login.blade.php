<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login | NetIT Technology</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body, html {
            height: 100%;
            background: #f0f4f8;
        }

        a {
            color: #667eea;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }

        .container {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        .left-panel {
            flex: 1;
            background: #F5F5F5;
            color: #383838;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 40px;
        }

        .left-panel h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .left-panel p {
            font-size: 1.25rem;
            line-height: 1.6;
            max-width: 400px;
            opacity: 0.85;
        }

        .right-panel {
            flex: 1;
            background: url('/NetIT Logo.png') no-repeat center center / cover;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 50px;
            position: relative;
        }

        .login-form {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            padding: 30px 25px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            color: #fff;
        }

        .login-form h2 {
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            color: #fff;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
            color: #f1f1f1;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: none;
            font-size: 1rem;
        }

        input::placeholder {
            color: #ccc;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 0.9rem;
            color: #eee;
        }

        .remember-forgot label {
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-forgot input[type="checkbox"] {
            width: 16px;
            height: 16px;
        }

        button {
            width: 100%;
            padding: 16px;
            background: #667eea;
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            transition: background-color 0.3s ease;
        }

        button:hover {
            background: #5a67d8;
        }

        .error-messages {
            background: rgba(255, 255, 255, 0.2);
            color: #ffe1e1;
            border: 1px solid #ffb3b3;
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .error-messages ul {
            list-style: inside disc;
        }

        @media (max-width: 900px) {
            .container {
                flex-direction: column;
            }

            .left-panel,
            .right-panel {
                flex: none;
                width: 100%;
                height: auto;
                padding: 40px 20px;
            }

            .login-form {
                max-width: 100%;
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="left-panel">
        <h1>Welcome!!</h1>
        <p>Login to access your personalized dashboard and manage your projects with ease. Stay productive, organized, and connected.</p>
    </div>

    <div class="right-panel">
        <div class="login-form">
            <h2>Sign In</h2>

            @if (session('error'))
                <div class="error-messages">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-messages">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="you@example.com"
                />

                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    placeholder="••••••••"
                />

                <div class="remember-forgot">
                    <label><input type="checkbox" name="remember"> Remember me</label>
                </div>

                <button type="submit">Login</button>

                <div style="text-align: center; margin-top: 15px; font-size: 0.9rem;">
                    Need access? Contact your Admin.
                </div>
            </form>
        </div>
    </div>

</div>

</body>
</html>
