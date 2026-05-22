<div x-data="{ show: true }" 
     x-init="window.addEventListener('load', () => setTimeout(() => show = false, 400))"
     x-show="show" 
     x-transition.opacity.duration.600ms
     class="fixed inset-0 z-[10000] bg-gray-950 flex flex-col items-center justify-center"
     style="display: flex;">
    <div class="relative flex items-center justify-center w-24 h-24">
        <!-- Large outer ring -->
        <div class="absolute inset-0 border-[3px] border-gray-800 rounded-full"></div>
        <!-- Spinning glow ring -->
        <div class="absolute inset-0 border-[3px] border-transparent border-t-white rounded-full animate-spin shadow-[0_0_15px_rgba(255,255,255,0.3)]"></div>
        
        <!-- Medium ring -->
        <div class="absolute inset-3 border-[2px] border-gray-800 rounded-full"></div>
        <div class="absolute inset-3 border-[2px] border-transparent border-b-gray-400 rounded-full animate-spin" style="animation-direction: reverse; animation-duration: 1.5s;"></div>
        
        <!-- Small inner ring -->
        <div class="absolute inset-6 border-[1px] border-gray-800 rounded-full"></div>
        <div class="absolute inset-6 border-[1px] border-transparent border-t-gray-500 border-l-gray-500 rounded-full animate-spin" style="animation-duration: 0.8s;"></div>
        
        <!-- Center Dot -->
        <div class="w-3 h-3 bg-white rounded-full shadow-[0_0_10px_rgba(255,255,255,0.8)] animate-pulse"></div>
    </div>
</div>
