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
        * { font-family: 'Inter', sans-serif; }
        .auth-bg {
            background: #0a0a0a;
            background-image: radial-gradient(ellipse 80% 50% at 50% -20%, rgba(255,255,255,0.08), transparent);
        }
        .glass-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
        }
        .input-field {
            background: rgba(255,255,255,0.05) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            color: white !important;
            border-radius: 10px !important;
            padding: 14px 16px !important;
            width: 100%;
            transition: all 0.2s ease;
            outline: none;
            font-size: 0.9rem;
        }
        .input-field::placeholder { color: rgba(255,255,255,0.3); }
        .input-field:focus {
            background: rgba(255,255,255,0.08) !important;
            border-color: rgba(255,255,255,0.3) !important;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.05);
        }
        .btn-primary {
            background: white;
            color: #0a0a0a;
            font-weight: 700;
            border-radius: 10px;
            padding: 14px 28px;
            width: 100%;
            font-size: 0.9rem;
            letter-spacing: 0.01em;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }
        .btn-primary:hover {
            background: #e8e8e8;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.4);
        }
        label { color: rgba(255,255,255,0.6); font-size: 0.8rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; }
        .grid-dots {
            background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 28px 28px;
        }
        .error-text { color: #ff6b6b; font-size: 0.78rem; margin-top: 4px; }
        .link { color: rgba(255,255,255,0.5); font-size: 0.85rem; transition: color 0.2s; }
        .link:hover { color: white; }
        .link-bold { color: white; font-weight: 600; font-size: 0.85rem; text-decoration: none; }
        .link-bold:hover { text-decoration: underline; }
        .divider { border-color: rgba(255,255,255,0.08); margin: 20px 0; }
        .stat-badge {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 50px;
            padding: 6px 14px;
            font-size: 0.78rem;
            color: rgba(255,255,255,0.6);
        }
    </style>
</head>
<body class="auth-bg min-h-screen antialiased grid-dots">
    <div class="min-h-screen flex">

        {{-- Left Branding Panel --}}
        <div class="hidden lg:flex lg:w-[52%] flex-col justify-between p-16 relative overflow-hidden">
            <div class="absolute inset-0 auth-bg"></div>
            <div class="absolute inset-0 grid-dots opacity-60"></div>
            {{-- Glow effect --}}
            <div class="absolute top-1/3 left-1/4 w-96 h-96 rounded-full blur-3xl" style="background: radial-gradient(circle, rgba(255,255,255,0.04) 0%, transparent 70%);"></div>

            <div class="relative z-10">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-white font-black text-xl tracking-tight">LECS</span>
                </a>
            </div>

            <div class="relative z-10 space-y-8">
                <div class="space-y-5">
                    <div class="flex gap-2 flex-wrap">
                        <span class="stat-badge">🎉 500+ Events</span>
                        <span class="stat-badge">👥 10k+ Members</span>
                        <span class="stat-badge">🏙️ 20+ Cities</span>
                    </div>
                    <h1 class="text-5xl font-black text-white leading-[1.1] tracking-tight">
                        Your city's<br>
                        social hub,<br>
                        <span style="color: rgba(255,255,255,0.4);">all in one place.</span>
                    </h1>
                    <p class="text-lg leading-relaxed" style="color: rgba(255,255,255,0.45); max-width: 400px;">
                        Discover concerts, workshops, food festivals, and meetups happening right around the corner.
                    </p>
                </div>

                {{-- Testimonial Card --}}
                <div class="glass-card rounded-2xl p-5 max-w-sm">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold text-black" style="background: linear-gradient(135deg, #e0e0e0, #a0a0a0);">RK</div>
                        <div>
                            <div class="text-white font-semibold text-sm">Rahul K.</div>
                            <div class="text-xs" style="color: rgba(255,255,255,0.4);">Event Organizer, Mumbai</div>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed" style="color: rgba(255,255,255,0.55);">"LECS helped me fill seats at my workshop within hours. The platform is incredibly intuitive."</p>
                    <div class="flex gap-1 mt-3">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                </div>
            </div>

            <div class="relative z-10">
                <p class="text-sm" style="color: rgba(255,255,255,0.25);">&copy; {{ date('Y') }} Local Event Calendar System</p>
            </div>
        </div>

        {{-- Right Form Panel --}}
        <div class="w-full lg:w-[48%] flex items-center justify-center p-6 sm:p-10 lg:p-16" style="background: #111111;">
            <div class="w-full max-w-[400px]">
                {{-- Mobile Logo --}}
                <div class="lg:hidden mb-10">
                    <a href="/" class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-white rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-white font-black text-xl tracking-tight">LECS</span>
                    </a>
                </div>

                {{ $slot }}
            </div>
        </div>

    </div>
</body>
</html>
