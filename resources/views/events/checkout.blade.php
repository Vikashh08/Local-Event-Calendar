<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('events.show', $event) }}" class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Step 2 of 2</p>
                <h1 class="font-black text-xl text-slate-900 tracking-tight leading-none mt-0.5">Secure Checkout</h1>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/70 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Trust bar --}}
            <div class="flex flex-wrap items-center justify-center gap-6 mb-8 py-3 px-6 bg-white border border-slate-100 rounded-2xl shadow-sm w-fit mx-auto">
                <span class="flex items-center gap-1.5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    SSL Encrypted
                </span>
                <span class="flex items-center gap-1.5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Instant Confirmation
                </span>
                <span class="flex items-center gap-1.5 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    Digital Ticket Issued
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

                {{-- ===== LEFT: Payment Form ===== --}}
                <div class="lg:col-span-3 space-y-6">

                    {{-- Payment Method Card --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-100">
                            <h2 class="font-black text-slate-900 text-lg tracking-tight">Choose Payment Method</h2>
                            <p class="text-xs text-slate-400 font-semibold mt-0.5">All transactions are secured and encrypted</p>
                        </div>

                        <form action="{{ route('rsvps.store', $event) }}" method="POST" id="checkout-form" x-data="{ method: 'credit_card', isProcessing: false }" @submit="isProcessing = true">
                            @csrf
                            <input type="hidden" name="status" value="yes">
                            <input type="hidden" name="payment_method" :value="method">

                            <div class="p-8 space-y-3">

                                {{-- Credit Card Option --}}
                                <label @click="method = 'credit_card'" :class="method === 'credit_card' ? 'border-indigo-500 bg-indigo-50/50 ring-2 ring-indigo-500/20' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50/50'"
                                       class="flex items-center gap-5 p-5 rounded-2xl border-2 cursor-pointer transition-all duration-150 group">
                                    <div :class="method === 'credit_card' ? 'bg-indigo-600 border-indigo-600' : 'bg-white border-slate-200 group-hover:border-slate-300'"
                                         class="shrink-0 w-11 h-11 border-2 rounded-xl flex items-center justify-center transition-all duration-150">
                                        <svg class="w-5 h-5" :class="method === 'credit_card' ? 'text-white' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-slate-900 text-sm">Credit / Debit Card</p>
                                        <p class="text-xs text-slate-400 font-semibold mt-0.5">Visa, Mastercard, RuPay accepted</p>
                                    </div>
                                    <div :class="method === 'credit_card' ? 'border-indigo-600 bg-indigo-600' : 'border-slate-300'"
                                         class="shrink-0 w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all">
                                        <div :class="method === 'credit_card' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'" class="w-2 h-2 bg-white rounded-full transition-all duration-150"></div>
                                    </div>
                                </label>

                                {{-- PayPal Option --}}
                                <label @click="method = 'paypal'" :class="method === 'paypal' ? 'border-blue-500 bg-blue-50/50 ring-2 ring-blue-500/20' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50/50'"
                                       class="flex items-center gap-5 p-5 rounded-2xl border-2 cursor-pointer transition-all duration-150 group">
                                    <div :class="method === 'paypal' ? 'bg-blue-600 border-blue-600' : 'bg-white border-slate-200 group-hover:border-slate-300'"
                                         class="shrink-0 w-11 h-11 border-2 rounded-xl flex items-center justify-center transition-all duration-150">
                                        <svg class="w-5 h-5" :class="method === 'paypal' ? 'text-white' : 'text-blue-400'" fill="currentColor" viewBox="0 0 24 24"><path d="M7.076 21.337H2.47a.641.641 0 01-.633-.74L4.934 3.09A1.282 1.282 0 016.188 2.2h6.588c2.812 0 4.981.42 6.005 1.583 1.05 1.192 1.24 2.894.61 4.805-.51 1.547-1.46 2.846-2.73 3.682-1.12.738-2.58.988-4.22.988h-1.61c-.51 0-.94.381-1.02.885l-.94 5.378-.4 2.298a.64.64 0 01-.633.518z"/></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-slate-900 text-sm">PayPal</p>
                                        <p class="text-xs text-slate-400 font-semibold mt-0.5">Fast and secure checkout</p>
                                    </div>
                                    <div :class="method === 'paypal' ? 'border-blue-600 bg-blue-600' : 'border-slate-300'"
                                         class="shrink-0 w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all">
                                        <div :class="method === 'paypal' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'" class="w-2 h-2 bg-white rounded-full transition-all duration-150"></div>
                                    </div>
                                </label>

                                {{-- Apple Pay Option --}}
                                <label @click="method = 'apple_pay'" :class="method === 'apple_pay' ? 'border-slate-900 bg-slate-50/80 ring-2 ring-slate-900/10' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50/50'"
                                       class="flex items-center gap-5 p-5 rounded-2xl border-2 cursor-pointer transition-all duration-150 group">
                                    <div :class="method === 'apple_pay' ? 'bg-slate-900 border-slate-900' : 'bg-white border-slate-200 group-hover:border-slate-300'"
                                         class="shrink-0 w-11 h-11 border-2 rounded-xl flex items-center justify-center transition-all duration-150">
                                        <svg class="w-5 h-5" :class="method === 'apple_pay' ? 'text-white' : 'text-slate-700'" fill="currentColor" viewBox="0 0 24 24"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 4.17c.66-.81 1.11-1.93.99-3.05-1.04.04-2.19.69-2.88 1.5-.6.69-1.11 1.83-.97 2.93 1.16.09 2.2-.59 2.86-1.38z"/></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-slate-900 text-sm">Apple Pay</p>
                                        <p class="text-xs text-slate-400 font-semibold mt-0.5">One-tap secure payment</p>
                                    </div>
                                    <div :class="method === 'apple_pay' ? 'border-slate-900 bg-slate-900' : 'border-slate-300'"
                                         class="shrink-0 w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all">
                                        <div :class="method === 'apple_pay' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'" class="w-2 h-2 bg-white rounded-full transition-all duration-150"></div>
                                    </div>
                                </label>
                            </div>

                            {{-- Confirm Button --}}
                            <div class="px-8 pb-8">
                                <button type="submit" :disabled="isProcessing"
                                        class="relative w-full py-4 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-70 text-white rounded-2xl font-black text-sm uppercase tracking-widest transition-all duration-200 shadow-sm hover:shadow-md hover:shadow-indigo-600/20 overflow-hidden flex items-center justify-center gap-2.5">
                                    <span x-show="!isProcessing" class="flex items-center gap-2.5">
                                        <svg class="w-5 h-5 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        Confirm & Pay ₹{{ number_format($event->price, 2) }}
                                    </span>
                                    <span x-show="isProcessing" x-cloak class="flex items-center gap-3">
                                        <svg class="w-5 h-5 animate-spin text-white/70" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                        Processing Payment...
                                    </span>
                                </button>
                                <p class="text-center text-[10px] text-slate-400 mt-4 uppercase tracking-widest font-bold flex items-center justify-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    Secured &amp; encrypted by LECS Pay
                                </p>
                            </div>
                        </form>
                    </div>

                    {{-- Help Banner --}}
                    <div class="flex items-center justify-between bg-slate-900 rounded-2xl px-6 py-4">
                        <div>
                            <p class="font-bold text-white text-sm">Need help?</p>
                            <p class="text-slate-400 text-xs font-semibold mt-0.5">Our support team responds in under 2 hours.</p>
                        </div>
                        <a href="mailto:support@lecs.com" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 border border-white/10 rounded-xl font-bold text-xs text-white uppercase tracking-widest transition-all whitespace-nowrap">
                            Get Help
                        </a>
                    </div>
                </div>

                {{-- ===== RIGHT: Order Summary ===== --}}
                <div class="lg:col-span-2">
                    <div class="sticky top-24">
                        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

                            {{-- Event image preview --}}
                            <div class="h-48 relative bg-slate-100">
                                @if($event->image)
                                    <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 to-transparent"></div>
                                <div class="absolute bottom-4 left-5">
                                    <span class="px-2.5 py-1 bg-white/20 backdrop-blur-md rounded-lg text-[9px] font-black text-white uppercase tracking-widest border border-white/20">
                                        {{ $event->category?->name ?? 'General' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Order details --}}
                            <div class="p-6">
                                <h3 class="font-black text-slate-900 text-base leading-snug mb-4">{{ $event->title }}</h3>

                                <div class="space-y-3 mb-6">
                                    <div class="flex items-center gap-3 text-xs">
                                        <div class="w-8 h-8 bg-slate-50 border border-slate-100 rounded-lg flex items-center justify-center shrink-0">
                                            <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <span class="font-semibold text-slate-600">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-xs">
                                        <div class="w-8 h-8 bg-slate-50 border border-slate-100 rounded-lg flex items-center justify-center shrink-0">
                                            <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <span class="font-semibold text-slate-600">{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</span>
                                    </div>
                                    @if($event->location)
                                        <div class="flex items-center gap-3 text-xs">
                                            <div class="w-8 h-8 bg-slate-50 border border-slate-100 rounded-lg flex items-center justify-center shrink-0">
                                                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                            </div>
                                            <span class="font-semibold text-slate-600 truncate">{{ $event->location }}</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Price breakdown --}}
                                <div class="border-t border-slate-100 pt-5 space-y-3">
                                    <div class="flex justify-between text-xs">
                                        <span class="text-slate-400 font-bold uppercase tracking-widest text-[9px]">Ticket (×1)</span>
                                        <span class="text-slate-700 font-bold">₹{{ number_format($event->price, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-slate-400 font-bold uppercase tracking-widest text-[9px]">Platform Fee</span>
                                        <span class="text-emerald-600 font-bold">₹0.00 — Free</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-4 border-t border-slate-200">
                                        <span class="font-black text-slate-900 text-sm uppercase tracking-wider">Total</span>
                                        <span class="text-2xl font-black text-slate-900">₹{{ number_format($event->price, 2) }}</span>
                                    </div>
                                </div>

                                {{-- What you get --}}
                                <div class="mt-5 pt-4 border-t border-slate-100">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3">What You'll Get</p>
                                    <ul class="space-y-2">
                                        <li class="flex items-center gap-2 text-xs font-semibold text-slate-600">
                                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            Digital Entry Pass (QR Code)
                                        </li>
                                        <li class="flex items-center gap-2 text-xs font-semibold text-slate-600">
                                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            Instant Booking Confirmation
                                        </li>
                                        <li class="flex items-center gap-2 text-xs font-semibold text-slate-600">
                                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            Event Reminders via Notification
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
