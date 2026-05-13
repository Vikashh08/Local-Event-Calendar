<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LECS') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }

        body {
            background-color: #0f0f0f;
            background-image:
                radial-gradient(ellipse 60% 40% at 70% 20%, rgba(255,255,255,0.04) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 20% 80%, rgba(255,255,255,0.03) 0%, transparent 60%);
            min-height: 100vh;
        }

        .auth-card {
            background: #1a1a1a;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            box-shadow: 0 24px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.04);
            width: 100%;
            max-width: 420px;
            padding: 40px;
        }

        .input-field {
            background: #0f0f0f;
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
            border-radius: 10px;
            padding: 12px 14px;
            width: 100%;
            transition: all 0.2s ease;
            outline: none;
            font-size: 0.9rem;
            display: block;
        }
        .input-field::placeholder { color: rgba(255,255,255,0.25); }
        .input-field:focus {
            border-color: rgba(255,255,255,0.3);
            background: #141414;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.04);
        }

        .btn-primary {
            background: white;
            color: #0a0a0a;
            font-weight: 700;
            border-radius: 10px;
            padding: 13px 24px;
            width: 100%;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-primary:hover {
            background: #e8e8e8;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.4);
        }
        .btn-primary:active { transform: translateY(0); }

        .field-label {
            display: block;
            color: rgba(255,255,255,0.45);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 6px;
        }
        .error-text { color: #f87171; font-size: 0.78rem; margin-top: 5px; display: block; }
        .link { color: rgba(255,255,255,0.4); font-size: 0.85rem; }
        .link a { color: white; font-weight: 600; text-decoration: none; }
        .link a:hover { text-decoration: underline; }
        .divider { border: none; border-top: 1px solid rgba(255,255,255,0.07); margin: 24px 0; }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">

        {{-- Logo --}}
        <a href="/" class="flex items-center gap-2.5 mb-8 group">
            <div class="w-9 h-9 bg-white rounded-xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                <svg class="w-4.5 h-4.5 text-black" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="text-white font-black text-xl tracking-tight">LECS</span>
        </a>

        {{-- Card --}}
        <div class="auth-card">
            {{ $slot }}
        </div>

        {{-- Back link --}}
        <a href="/" class="mt-6 text-sm font-medium transition-colors" style="color: rgba(255,255,255,0.3);"
           onmouseover="this.style.color='rgba(255,255,255,0.7)'"
           onmouseout="this.style.color='rgba(255,255,255,0.3)'">
            ← Back to website
        </a>

    </div>
</body>
</html>
