<x-guest-layout>
    <div style="margin-bottom:28px;">
        <h2 style="font-size:1.5rem; font-weight:800; color:#0f172a; letter-spacing:-0.02em;">Create account</h2>
        <p style="margin-top:6px; font-size:0.875rem; color:#64748b;">Join LECS — discover and create local events.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" style="display:flex; flex-direction:column; gap:15px;">
        @csrf

        <div>
            <label class="field-label" for="name">Full name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                required autofocus autocomplete="name"
                class="input-field" placeholder="Your full name">
            @error('name') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="field-label" for="email">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                required autocomplete="username"
                class="input-field" placeholder="you@example.com">
            @error('email') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="field-label" for="password">Password</label>
            <input id="password" type="password" name="password"
                required autocomplete="new-password"
                class="input-field" placeholder="Min. 8 characters">
            @error('password') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="field-label" for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                required autocomplete="new-password"
                class="input-field" placeholder="Repeat your password">
            @error('password_confirmation') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        {{-- Account Type --}}
        <div>
            <label class="field-label">Account type</label>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:8px;">
                <label style="display:flex; flex-direction:column; align-items:center; justify-content:center; border:2px solid; border-radius:14px; padding:16px 10px; cursor:pointer; gap:6px; transition:all 0.15s;"
                    id="role-user-label"
                    style="border-color: {{ old('role', 'user') === 'user' ? '#0f172a' : '#e2e8f0' }};">
                    <input type="radio" name="role" value="user" id="role-user" class="hidden" {{ old('role', 'user') === 'user' ? 'checked' : '' }}>
                    <svg style="width:28px;height:28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span style="font-size:0.8rem; font-weight:700;">Attendee</span>
                    <span style="font-size:0.68rem; color:#94a3b8; text-align:center;">Browse &amp; RSVP to events</span>
                </label>
                <label style="display:flex; flex-direction:column; align-items:center; justify-content:center; border:2px solid #e2e8f0; border-radius:14px; padding:16px 10px; cursor:pointer; gap:6px; transition:all 0.15s;"
                    id="role-organizer-label">
                    <input type="radio" name="role" value="organizer" id="role-organizer" class="hidden" {{ old('role') === 'organizer' ? 'checked' : '' }}>
                    <svg style="width:28px;height:28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span style="font-size:0.8rem; font-weight:700;">Organizer</span>
                    <span style="font-size:0.68rem; color:#94a3b8; text-align:center;">Create &amp; manage events</span>
                </label>
            </div>
            @error('role') <span class="error-text">{{ $message }}</span> @enderror
        </div>

        <script>
            (function() {
                const userLabel = document.getElementById('role-user-label');
                const orgLabel  = document.getElementById('role-organizer-label');
                const userRadio = document.getElementById('role-user');
                const orgRadio  = document.getElementById('role-organizer');

                function updateStyles() {
                    userLabel.style.borderColor = userRadio.checked ? '#0f172a' : '#e2e8f0';
                    userLabel.style.backgroundColor = userRadio.checked ? '#f8fafc' : 'white';
                    orgLabel.style.borderColor  = orgRadio.checked  ? '#0f172a' : '#e2e8f0';
                    orgLabel.style.backgroundColor = orgRadio.checked ? '#f8fafc' : 'white';
                }

                userLabel.addEventListener('click', function() { userRadio.checked = true; updateStyles(); });
                orgLabel.addEventListener('click',  function() { orgRadio.checked  = true; updateStyles(); });

                updateStyles();
            })();
        </script>

        <button type="submit" class="btn-primary" style="margin-top:6px;">
            Create free account
        </button>

        <p style="color:#94a3b8; font-size:0.72rem; text-align:center; line-height:1.6; margin:0;">
            By registering, you agree to our Terms of Service and Privacy Policy.
        </p>
    </form>

    <hr class="divider">

    <p class="link" style="text-align:center;">
        Already have an account? <a href="{{ route('login') }}">Sign in</a>
    </p>
</x-guest-layout>
