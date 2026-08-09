<x-guest-layout>
    <div class="auth-title">Selamat Datang Kembali</div>
    <div class="auth-subtitle">Silakan masuk ke akun MedRecord Anda</div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="input-group">
            <label for="email" class="input-label">Email / Username</label>
            <div class="input-field-wrapper">
                <i class="fas fa-envelope icon-prefix"></i>
                <input id="email" class="input-control" type="email" name="email" value="{{ old('email', 'sari@medrecord.test') }}" required autofocus autocomplete="username" placeholder="masukkan email...">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-600" />
        </div>

        <!-- Password -->
        <div class="input-group">
            <label for="password" class="input-label">Password</label>
            <div class="input-field-wrapper">
                <i class="fas fa-lock icon-prefix"></i>
                <input id="password" class="input-control" type="password" name="password" value="password" required autocomplete="current-password" placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-600" />
        </div>

        <!-- Remember Me & Lupa Password -->
        <div style="display: flex; align-items: center; justify-content: space-between; font-size: 12px; margin-top: 10px;">
            <label for="remember_me" style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer; color: #4b5563;">
                <input id="remember_me" type="checkbox" name="remember" style="accent-color: #4f46e5; width: 14px; height: 14px;">
                <span>Ingat Saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="color: #4f46e5; text-decoration: none; font-weight: 500;">
                    Lupa Password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-sign-in-alt"></i> Masuk ke Sistem
        </button>
    </form>

    <!-- Quick Demo Accounts for Testing -->
    <div class="demo-accounts">
        <div class="demo-title"><i class="fas fa-bolt" style="color: #f59e0b;"></i> Klik Akun Demo (Password: password)</div>
        <div class="demo-chips">
            <button type="button" class="demo-chip" onclick="fillAccount('sari@medrecord.test')">dr. Sari (Dokter B)</button>
            <button type="button" class="demo-chip" onclick="fillAccount('andi@medrecord.test')">dr. Andi (Dokter A)</button>
            <button type="button" class="demo-chip" onclick="fillAccount('rudi@medrecord.test')">Rudi (Pasien)</button>
            <button type="button" class="demo-chip" onclick="fillAccount('admin@medrecord.test')">Admin</button>
        </div>
    </div>

    <script>
    function fillAccount(email) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = 'password';
    }
    </script>
</x-guest-layout>
