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
            background: #f1f5f9;
            background-image:
                radial-gradient(ellipse 70% 50% at 20% 10%, rgba(99,102,241,0.07) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 90%, rgba(14,165,233,0.07) 0%, transparent 60%);
            min-height: 100vh;
        }

        .auth-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 20px 60px -10px rgba(0,0,0,0.12);
            width: 100%;
            max-width: 420px;
            padding: 40px;
        }

        .input-field {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            color: #0f172a;
            border-radius: 10px;
            padding: 11px 14px;
            width: 100%;
            transition: all 0.2s ease;
            outline: none;
            font-size: 0.9rem;
            display: block;
        }
        .input-field::placeholder { color: #94a3b8; }
        .input-field:focus {
            border-color: #6366f1;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: white;
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
            letter-spacing: 0.01em;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(15,23,42,0.25);
        }
        .btn-primary:active { transform: translateY(0); }

        .field-label {
            display: block;
            color: #475569;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 6px;
        }
        .error-text { color: #ef4444; font-size: 0.78rem; margin-top: 5px; display: block; }
        .link { color: #64748b; font-size: 0.85rem; }
        .link a { color: #4f46e5; font-weight: 600; text-decoration: none; }
        .link a:hover { text-decoration: underline; }
        .divider { border: none; border-top: 1px solid #f1f5f9; margin: 22px 0; }

        .logo-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #1e293b, #334155);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(15,23,42,0.2);
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">

        {{-- Logo --}}
        <a href="/" class="flex items-center gap-2.5 mb-8 group">
            <div class="logo-icon group-hover:scale-105 transition-transform">
                <svg style="width:17px;height:17px;" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span style="color:#0f172a; font-weight:900; font-size:1.2rem; letter-spacing:-0.03em;">LECS</span>
        </a>

        {{-- Card --}}
        <div class="auth-card">
            {{ $slot }}
        </div>

        {{-- Back link --}}
        <a href="/" class="mt-6 text-sm font-medium text-slate-400 hover:text-slate-600 transition-colors">
            ← Back to website
        </a>

    </div>
</body>
</html>
