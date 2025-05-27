<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login | Modern Style</title>
    <style>
        /* Reset & base */
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

        /* Container split */
        .container {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* Left panel with gradient and text */
        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
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

        /* Right panel with form */
        .right-panel {
            flex: 1;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 50px;
            box-shadow: -4px 0 20px rgba(102, 126, 234, 0.15);
        }

        .login-form {
            max-width: 380px;
            margin: 0 auto;
        }
        .login-form h2 {
            font-weight: 700;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #555;
            font-size: 0.9rem;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1.5px solid #ddd;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.5);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 0.9rem;
            color: #666;
        }
        .remember-forgot label {
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        .remember-forgot input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
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

        /* Error messages styling */
        .error-messages {
            background: #ffe1e1;
            color: #d8000c;
            border: 1px solid #d8000c;
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .error-messages ul {
            list-style: inside disc;
        }

        /* Responsive for small screens */
        @media (max-width: 900px) {
            .container {
                flex-direction: column;
            }
            .left-panel, .right-panel {
                flex: none;
                width: 100%;
                height: 50vh;
                box-shadow: none !important;
            }
            .left-panel {
                padding: 40px 20px;
                height: 40vh;
                text-align: center;
            }
            .right-panel {
                padding: 40px 20px;
                height: 60vh;
            }
            .login-form {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="left-panel">
        <h1>Welcome Back!</h1>
        <p>Login to access your personalized dashboard and manage your projects with ease. Stay productive, organized, and connected.</p>
    </div>

    <div class="right-panel">
        <div class="login-form">
            <h2>Sign In</h2>

            @if ($errors->any())
                <div class="error-messages">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('login') }}">
                @csrf

                <label for="username">User Name</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="AdminName"
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

                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                </div>

                <button type="submit">Login</button>

                <div style="text-align: center; margin-top: 15px; font-size: 0.9rem;">
    Don't have an account? <a href="{{ route('register') }}">Sign Up</a>
</div>

            </form>

        </div>
    </div>

</div>

</body>
</html>
