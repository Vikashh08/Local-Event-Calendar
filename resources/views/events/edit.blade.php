<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Edit Event: ') . $event->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100">
                <div class="p-8 sm:p-12">
                    
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">There were some problems with your input.</h3>
                                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('events.update', $event) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label for="title" class="block text-sm font-bold text-gray-700">Event Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800 transition-shadow">
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-bold text-gray-700">Category</label>
                            <select name="category_id" id="category_id" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800 transition-shadow">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="date" class="block text-sm font-bold text-gray-700">Date <span class="text-red-500">*</span></label>
                                <input type="date" name="date" id="date" value="{{ old('date', $event->date) }}" required class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800 transition-shadow">
                            </div>
                            <div>
                                <label for="time" class="block text-sm font-bold text-gray-700">Time <span class="text-red-500">*</span></label>
                                <input type="time" name="time" id="time" value="{{ old('time', date('H:i', strtotime($event->time))) }}" required class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800 transition-shadow">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="location" class="block text-sm font-bold text-gray-700">Location</label>
                                <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" placeholder="Venue name or address" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800 transition-shadow">
                            </div>
                            <div>
                                <label for="capacity" class="block text-sm font-bold text-gray-700">Capacity <span class="text-gray-400 font-normal">(optional)</span></label>
                                <input type="number" name="capacity" id="capacity" min="1" value="{{ old('capacity', $event->capacity) }}" placeholder="Max attendees" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800 transition-shadow">
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="5" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800 transition-shadow">{{ old('description', $event->description) }}</textarea>
                        </div>

                        {{-- Cover Image Upload --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Cover Image <span class="text-gray-400 font-normal">(optional, max 2MB)</span></label>
                            @if($event->image)
                                <div class="mt-2 mb-3 relative rounded-2xl overflow-hidden border border-gray-200 bg-gray-50 h-40 flex items-center justify-center">
                                    <img src="{{ Storage::url($event->image) }}" alt="Current cover" class="max-h-full max-w-full object-cover rounded-2xl" id="image-preview">
                                    <span class="absolute top-2 left-2 bg-black/60 text-white text-xs px-2.5 py-1 rounded-full font-medium">Current Cover</span>
                                </div>
                            @else
                                <img id="image-preview" src="#" alt="Preview" class="hidden mt-2 mb-3 max-h-40 rounded-2xl object-cover border border-gray-200">
                            @endif
                            <div class="flex items-center justify-center w-full">
                                <label for="image" class="flex flex-col items-center justify-center w-full h-24 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors group">
                                    <div class="flex flex-col items-center justify-center py-4" id="image-label">
                                        <svg class="w-7 h-7 mb-2 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <p class="text-sm text-gray-500">{{ $event->image ? 'Click to replace cover image' : 'Click to upload a cover image' }}</p>
                                    </div>
                                    <input id="image" name="image" type="file" accept="image/*" class="hidden" onchange="previewNewImage(event)">
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('events.show', $event) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-900 to-gray-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-black hover:to-gray-900 focus:bg-black active:bg-black focus:outline-none focus:ring-2 focus:ring-gray-800 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                Update Event
                            </button>
                        </div>
                    </form>

                    <script>
                        function previewNewImage(event) {
                            const input = event.target;
                            const preview = document.getElementById('image-preview');
                            const label = document.getElementById('image-label');
                            if (input.files && input.files[0]) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    preview.src = e.target.result;
                                    preview.classList.remove('hidden');
                                    if (label) label.querySelector('p').textContent = input.files[0].name;
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
