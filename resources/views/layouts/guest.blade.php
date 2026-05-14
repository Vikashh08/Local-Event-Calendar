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
            background: #fafafa;
            min-height: 100vh;
        }

        /* Split layout */
        .auth-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .auth-panel-left {
            display: none;
            width: 45%;
            background: #0f172a;
            position: relative;
            overflow: hidden;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
        }
        @media(min-width: 1024px) {
            .auth-panel-left { display: flex; }
        }

        .auth-panel-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            overflow-y: auto;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
        }

        /* Grid pattern on left panel */
        .panel-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        /* Blobs */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }

        /* Inputs */
        .input-field {
            background: #ffffff;
            border: 1.5px solid #e5e7eb;
            color: #111827;
            border-radius: 12px;
            padding: 12px 16px;
            width: 100%;
            transition: all 0.2s ease;
            outline: none;
            font-size: 0.9rem;
            display: block;
        }
        .input-field::placeholder { color: #9ca3af; }
        .input-field:focus {
            border-color: #111827;
            box-shadow: 0 0 0 3px rgba(17,24,39,0.08);
        }

        /* Button */
        .btn-primary {
            background: #111827;
            color: white;
            font-weight: 700;
            border-radius: 12px;
            padding: 14px 24px;
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
            background: #000000;
            transform: translateY(-1px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .btn-primary:active { transform: translateY(0); }

        .field-label {
            display: block;
            color: #374151;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 6px;
            letter-spacing: 0.01em;
        }
        .error-text { color: #ef4444; font-size: 0.78rem; margin-top: 4px; display: block; }
        .divider { border: none; border-top: 1px solid #f3f4f6; margin: 20px 0; }
        .link { color: #6b7280; font-size: 0.85rem; }
        .link a { color: #111827; font-weight: 700; text-decoration: none; }
        .link a:hover { text-decoration: underline; }

        /* Testimonial cards on left panel */
        .stat-card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 20px;
            backdrop-filter: blur(8px);
        }
    </style>
</head>
<body class="antialiased">
    <div class="auth-wrapper">

        {{-- LEFT PANEL --}}
        <div class="auth-panel-left">
            <div class="panel-grid"></div>
            <div class="blob" style="width:400px;height:400px;background:#1e3a5f;top:-100px;right:-100px;opacity:0.4;"></div>
            <div class="blob" style="width:300px;height:300px;background:#374151;bottom:-80px;left:-80px;opacity:0.3;"></div>

            {{-- Logo --}}
            <div class="relative">
                <a href="/" style="display:inline-flex;align-items:center;gap:10px;">
                    <div style="width:36px;height:36px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:18px;height:18px;" fill="none" stroke="white" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span style="color:white;font-weight:900;font-size:1.25rem;letter-spacing:-0.04em;">LECS.</span>
                </a>
            </div>

            {{-- Headline --}}
            <div class="relative">
                <h2 style="color:white;font-size:2.5rem;font-weight:900;letter-spacing:-0.04em;line-height:1.1;margin-bottom:16px;">
                    Your city's events,<br>
                    <span style="color:#94a3b8;">all in one place.</span>
                </h2>
                <p style="color:#64748b;font-size:0.95rem;line-height:1.7;margin-bottom:32px;">
                    Discover concerts, workshops, meetups, and more. Join thousands of people connecting through local events every day.
                </p>

                {{-- Stats --}}
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
                    @foreach([
                        [\App\Models\Event::approved()->count(), 'Events Live'],
                        [\App\Models\User::count(), 'Members'],
                        [\App\Models\Rsvp::count(), 'RSVPs Made'],
                    ] as [$num, $label])
                    <div class="stat-card">
                        <p style="color:white;font-size:1.6rem;font-weight:900;letter-spacing:-0.03em;">{{ $num }}+</p>
                        <p style="color:#64748b;font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-top:2px;">{{ $label }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Footer --}}
            <div class="relative" style="color:#475569;font-size:0.75rem;">
                &copy; {{ date('Y') }} Local Event Calendar System
            </div>
        </div>

        {{-- RIGHT PANEL --}}
        <div class="auth-panel-right">
            {{-- Mobile Logo --}}
            <div class="lg:hidden mb-8">
                <a href="/" style="display:inline-flex;align-items:center;gap:10px;">
                    <div style="width:34px;height:34px;background:#111827;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:17px;height:17px;" fill="none" stroke="white" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span style="color:#111827;font-weight:900;font-size:1.2rem;letter-spacing:-0.04em;">LECS.</span>
                </a>
            </div>

            {{-- Card Content --}}
            <div class="auth-card">
                {{ $slot }}
            </div>

            <a href="/" style="margin-top:24px;font-size:0.8rem;color:#9ca3af;font-weight:500;text-decoration:none;" onmouseover="this.style.color='#374151'" onmouseout="this.style.color='#9ca3af'">
                ← Back to website
            </a>
        </div>

    </div>
</body>
</html>
