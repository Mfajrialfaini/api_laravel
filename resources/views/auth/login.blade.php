<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #dc2626, #7f1d1d);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .card {
            background: white;
            width: 100%;
            max-width: 380px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, .2);
            animation: fadeIn .6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #111827;
        }

        .alert {
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #22c55e;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        label {
            font-size: 14px;
            font-weight: 600;
            margin-top: 15px;
            display: block;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            outline: none;
            transition: .2s;
        }

        input:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, .2);
        }

        button {
            width: 100%;
            margin-top: 25px;
            padding: 12px;
            background: #dc2626;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: .2s;
        }

        button:hover {
            background: #b91c1c;
        }

        .link {
            margin-top: 18px;
            text-align: center;
            font-size: 14px;
        }

        .link a {
            color: #dc2626;
            font-weight: 600;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="card">
        <h2>Login</h2>

        {{-- ALERT LOGIN BERHASIL --}}
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        {{-- ALERT LOGIN GAGAL --}}
        @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
        @endif

        {{-- VALIDATION ERROR --}}
        @if($errors->any())
        <div class="alert alert-error">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label>NRP</label>
            <input type="text" name="NRP" value="{{ old('NRP') }}" placeholder="Masukkan NRP" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password" required>

            <button type="submit">Masuk</button>
        </form>

        <div class="link">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar</a>
        </div>
    </div>

</body>

</html>