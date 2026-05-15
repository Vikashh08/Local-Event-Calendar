<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('events.show', $event) }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 text-gray-500 hover:text-gray-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="font-black text-2xl text-gray-900 tracking-tight">
                Secure Booking
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Left: Checkout Form --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-8">
                            <h3 class="text-xl font-black text-gray-900 tracking-tight mb-6">Payment Method</h3>
                            
                            <form action="{{ route('rsvps.store', $event) }}" method="POST" id="checkout-form" x-data="{ isProcessing: false }" @submit="isProcessing = true">
                                @csrf
                                <input type="hidden" name="status" value="yes">

                                <!-- Processing Overlay -->
                                <template x-if="isProcessing">
                                    <div class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/80 backdrop-blur-md transition-opacity">
                                        <div class="bg-white rounded-3xl p-10 flex flex-col items-center gap-6 shadow-2xl max-w-sm w-full mx-4 animate-fade-up">
                                            <div class="relative w-24 h-24">
                                                <!-- Outer spinning ring -->
                                                <div class="absolute inset-0 border-4 border-gray-100 rounded-full"></div>
                                                <div class="absolute inset-0 border-4 border-gray-900 rounded-full border-t-transparent animate-spin"></div>
                                                <!-- Inner pulsing lock icon -->
                                                <div class="absolute inset-0 flex items-center justify-center">
                                                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-gray-900 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <h3 class="text-xl font-black text-gray-900 tracking-tight mb-2">Processing Payment</h3>
                                                <p class="text-sm font-medium text-gray-500">Securely completing your booking. Please do not close this window.</p>
                                            </div>
                                            <div class="w-full bg-gray-100 rounded-full h-1 overflow-hidden mt-2">
                                                <div class="bg-gray-900 h-full rounded-full animate-pulse" style="width: 100%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <div class="space-y-4">
                                    <label class="relative flex items-center p-4 rounded-2xl border-2 border-gray-100 cursor-pointer hover:bg-gray-50 transition-all has-[:checked]:border-gray-900 has-[:checked]:bg-gray-50/50 group">
                                        <input type="radio" name="payment_method" value="credit_card" checked class="hidden peer">
                                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-900">Credit / Debit Card</p>
                                            <p class="text-xs text-gray-400">Secure payment via Stripe</p>
                                        </div>
                                        <div class="w-6 h-6 rounded-full border-2 border-gray-200 flex items-center justify-center peer-checked:border-gray-900 peer-checked:bg-gray-900 transition-all">
                                            <div class="w-2 h-2 bg-white rounded-full"></div>
                                        </div>
                                    </label>

                                    <label class="relative flex items-center p-4 rounded-2xl border-2 border-gray-100 cursor-pointer hover:bg-gray-50 transition-all has-[:checked]:border-gray-900 has-[:checked]:bg-gray-50/50 group">
                                        <input type="radio" name="payment_method" value="paypal" class="hidden peer">
                                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M7.076 21.337H2.47a.641.641 0 01-.633-.74L4.934 3.09A1.282 1.282 0 016.188 2.2h6.588c2.812 0 4.981.42 6.005 1.583 1.05 1.192 1.24 2.894.61 4.805-.51 1.547-1.46 2.846-2.73 3.682-1.12.738-2.58.988-4.22.988h-1.61c-.51 0-.94.381-1.02.885l-.94 5.378-.4 2.298a.64.64 0 01-.633.518z"/></svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-900">PayPal</p>
                                            <p class="text-xs text-gray-400">Fast and secure checkout</p>
                                        </div>
                                        <div class="w-6 h-6 rounded-full border-2 border-gray-200 flex items-center justify-center peer-checked:border-gray-900 peer-checked:bg-gray-900 transition-all">
                                            <div class="w-2 h-2 bg-white rounded-full"></div>
                                        </div>
                                    </label>

                                    <label class="relative flex items-center p-4 rounded-2xl border-2 border-gray-100 cursor-pointer hover:bg-gray-50 transition-all has-[:checked]:border-gray-900 has-[:checked]:bg-gray-50/50 group">
                                        <input type="radio" name="payment_method" value="apple_pay" class="hidden peer">
                                        <div class="w-10 h-10 bg-gray-900 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 4.17c.66-.81 1.11-1.93.99-3.05-1.04.04-2.19.69-2.88 1.5-.6.69-1.11 1.83-.97 2.93 1.16.09 2.2-.59 2.86-1.38z"/></svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-900">Apple Pay</p>
                                            <p class="text-xs text-gray-400">One-tap secure payment</p>
                                        </div>
                                        <div class="w-6 h-6 rounded-full border-2 border-gray-200 flex items-center justify-center peer-checked:border-gray-900 peer-checked:bg-gray-900 transition-all">
                                            <div class="w-2 h-2 bg-white rounded-full"></div>
                                        </div>
                                    </label>
                                </div>

                                <div class="mt-8 pt-8 border-t border-gray-100">
                                    <button type="submit"
                                        :disabled="isProcessing"
                                        :class="isProcessing ? 'opacity-80 cursor-not-allowed' : 'hover:bg-black hover:-translate-y-1 hover:shadow-2xl'"
                                        class="relative w-full py-4 bg-gray-900 text-white rounded-2xl font-black uppercase tracking-widest transition-all duration-300 shadow-xl overflow-hidden">

                                        {{-- Normal state --}}
                                        <span x-show="!isProcessing" class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            Confirm &amp; Pay ₹{{ number_format($event->price, 2) }}
                                        </span>

                                        {{-- Loading state --}}
                                        <span x-show="isProcessing" class="flex items-center justify-center gap-3">
                                            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                            </svg>
                                            Processing...
                                        </span>

                                        {{-- Shimmer sweep on hover --}}
                                        <span x-show="!isProcessing" class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/10 to-transparent group-hover:translate-x-full transition-transform duration-700 pointer-events-none"></span>
                                    </button>
                                    <p class="text-center text-[10px] text-gray-400 mt-4 uppercase tracking-widest font-bold">
                                        🔒 Secure transaction powered by LECS Pay
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="bg-gray-900 rounded-3xl p-8 text-white flex items-center justify-between">
                        <div>
                            <h4 class="font-black text-lg tracking-tight">Need help?</h4>
                            <p class="text-gray-400 text-sm mt-1">Our support team is here for you 24/7.</p>
                        </div>
                        <a href="mailto:support@lecs.com" class="px-6 py-3 bg-white/10 hover:bg-white/20 rounded-xl font-bold text-xs uppercase tracking-widest transition-all">
                            Contact Support
                        </a>
                    </div>
                </div>

                {{-- Right: Order Summary --}}
                <div class="space-y-6">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden sticky top-8">
                        <div class="h-40 relative">
                            @if($event->image)
                                <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-950"></div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-4 left-6">
                                <span class="px-2 py-1 bg-white/20 backdrop-blur-md rounded-lg text-[10px] font-bold text-white uppercase tracking-widest border border-white/20">
                                    {{ $event->category?->name ?? 'General' }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-black text-gray-900 leading-tight">{{ $event->title }}</h3>
                            
                            <div class="mt-4 space-y-3">
                                <div class="flex items-center gap-3 text-sm">
                                    <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <span class="text-gray-600 font-medium">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm">
                                    <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <span class="text-gray-600 font-medium truncate">{{ $event->location ?? 'TBA' }}</span>
                                </div>
                            </div>

                            <div class="mt-8 pt-6 border-t border-gray-100 space-y-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400 font-bold uppercase tracking-widest text-[10px]">Ticket Price</span>
                                    <span class="text-gray-900 font-bold">₹{{ number_format($event->price, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400 font-bold uppercase tracking-widest text-[10px]">Service Fee</span>
                                    <span class="text-gray-900 font-bold">₹0.00</span>
                                </div>
                                <div class="flex justify-between items-center pt-4 border-t border-gray-900">
                                    <span class="text-gray-900 font-black uppercase tracking-widest text-xs">Total Amount</span>
                                    <span class="text-2xl font-black text-gray-900">₹{{ number_format($event->price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes bounceIn {
        0%   { transform: scale(0.3); opacity: 0; }
        50%  { transform: scale(1.06); opacity: 1; }
        70%  { transform: scale(0.95); }
        100% { transform: scale(1); }
    }
    @keyframes shimmerSlide {
        from { transform: translateX(-100%); }
        to   { transform: translateX(100%); }
    }
    .animate-fade-up   { animation: fadeSlideUp 0.55s cubic-bezier(0.16,1,0.3,1) forwards; }
    .animate-bounce-in { animation: bounceIn   0.55s cubic-bezier(0.175,0.885,0.32,1.275) forwards; }
</style>
