<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-slate-900 tracking-tight">
            {{ __('Create New Event') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-[32px] border border-slate-200">
                <div class="p-8 sm:p-12">
                    <div class="mb-8">
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">New Event Details</h3>
                        <p class="text-xs font-semibold text-slate-550 mt-1">Provide information about your event to host it in your local community.</p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 bg-rose-50 border-l-4 border-rose-550 p-4 rounded-r-2xl">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-xs font-bold text-rose-800">There were some problems with your input.</h3>
                                    <ul class="mt-2 text-xs text-rose-700 font-semibold list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('events.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        
                        <div>
                            <label for="title" class="block text-xs font-bold uppercase tracking-widest text-slate-500">Event Title <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required class="mt-2 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 py-3 px-4 text-xs font-semibold placeholder-slate-400 outline-none">
                        </div>

                        <div>
                            <label for="category_id" class="block text-xs font-bold uppercase tracking-widest text-slate-500">Category</label>
                            <select name="category_id" id="category_id" class="mt-2 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 py-3 px-4 text-xs font-semibold outline-none bg-white">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="date" class="block text-xs font-bold uppercase tracking-widest text-slate-500">Date <span class="text-rose-500">*</span></label>
                                <input type="date" name="date" id="date" value="{{ old('date') }}" required class="mt-2 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 py-3 px-4 text-xs font-semibold outline-none">
                            </div>
                            <div>
                                <label for="time" class="block text-xs font-bold uppercase tracking-widest text-slate-500">Time <span class="text-rose-500">*</span></label>
                                <input type="time" name="time" id="time" value="{{ old('time') }}" required class="mt-2 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 py-3 px-4 text-xs font-semibold outline-none">
                            </div>
                        </div>

                        <div>
                            <label for="location" class="block text-xs font-bold uppercase tracking-widest text-slate-500">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}" placeholder="Venue name or address" class="mt-2 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 py-3 px-4 text-xs font-semibold placeholder-slate-400 outline-none">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="capacity" class="block text-xs font-bold uppercase tracking-widest text-slate-500">Capacity <span class="text-slate-400 font-normal uppercase tracking-normal">(optional)</span></label>
                                <input type="number" name="capacity" id="capacity" min="1" value="{{ old('capacity') }}" placeholder="Max attendees limit" class="mt-2 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 py-3 px-4 text-xs font-semibold placeholder-slate-400 outline-none">
                            </div>
                            <div>
                                <label for="price" class="block text-xs font-bold uppercase tracking-widest text-slate-500">Ticket Price (₹) <span class="text-slate-400 font-normal uppercase tracking-normal">(0 for free event)</span></label>
                                <input type="number" step="0.01" min="0" name="price" id="price" value="{{ old('price', 0) }}" placeholder="0.00" class="mt-2 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 py-3 px-4 text-xs font-semibold placeholder-slate-400 outline-none">
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-bold uppercase tracking-widest text-slate-500">Description</label>
                            <textarea name="description" id="description" rows="5" placeholder="Provide event schedule, rules, guidelines, etc." class="mt-2 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 py-3 px-4 text-xs font-semibold placeholder-slate-400 outline-none">{{ old('description') }}</textarea>
                        </div>

                        {{-- Cover Image Upload --}}
                        <div>
                            <label for="image" class="block text-xs font-bold uppercase tracking-widest text-slate-500">Cover Image <span class="text-slate-400 font-normal uppercase tracking-normal">(optional, max 2MB)</span></label>
                            <div class="mt-2 flex items-center justify-center w-full">
                                <label for="image" id="image-drop-zone" class="flex flex-col items-center justify-center w-full h-44 border-2 border-dashed border-slate-200 rounded-2xl cursor-pointer bg-slate-50 hover:bg-white hover:border-indigo-400 focus-within:border-indigo-500 focus-within:ring-4 focus-within:ring-indigo-500/10 transition-all duration-200 group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center" id="image-placeholder">
                                        <svg class="w-10 h-10 mb-3 text-slate-350 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-xs text-slate-500 font-bold"><span class="text-indigo-600 font-black">Click to upload</span> or drag & drop</p>
                                        <p class="text-[10px] text-slate-400 font-semibold mt-1">PNG, JPG, GIF, WEBP up to 2MB</p>
                                    </div>
                                    <img id="image-preview" src="#" alt="Preview" class="hidden max-h-36 rounded-xl object-cover">
                                    <input id="image" name="image" type="file" accept="image/*" class="hidden" onchange="previewImage(event)">
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-100">
                            <a href="{{ route('events.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-650 text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-indigo-650 hover:bg-indigo-700 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm">
                                Create Event
                            </button>
                        </div>
                    </form>

                    <script>
                        function previewImage(event) {
                            const input = event.target;
                            const preview = document.getElementById('image-preview');
                            const placeholder = document.getElementById('image-placeholder');
                            if (input.files && input.files[0]) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    preview.src = e.target.result;
                                    preview.classList.remove('hidden');
                                    placeholder.classList.add('hidden');
                                };
                                reader.readAsDataURL(input.files[0]);
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
