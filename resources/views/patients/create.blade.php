@extends('layouts.main')
@section('page-title', 'Tambah Pasien')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-head"><h2>Tambah Pasien</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ route('patients.store') }}">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">NIK (16 digit) *</label>
                    <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" maxlength="16" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Jenis Kelamin *</label>
                    <select name="gender" class="form-control" required>
                        <option value="">Pilih</option>
                        <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Lahir *</label>
                    <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="birth_place" class="form-control" value="{{ old('birth_place') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Golongan Darah</label>
                    <select name="blood_type" class="form-control">
                        <option value="">-</option>
                        @foreach(['A','B','AB','O','A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
                        <option value="{{ $bt }}" {{ old('blood_type') == $bt ? 'selected' : '' }}>{{ $bt }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Alergi</label>
                    <input type="text" name="allergies" class="form-control" value="{{ old('allergies') }}" placeholder="Contoh: Penisilin, Kacang">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Alamat *</label>
                <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
            </div>

            <div style="border-top: 1px solid #e8eaed; padding-top: 16px; margin-top: 8px;">
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                        <input type="checkbox" name="create_account" value="1" id="createAccount" {{ old('create_account') ? 'checked' : '' }}>
                        <span class="form-label" style="margin:0;">Buat akun login untuk pasien</span>
                    </label>
                </div>
                <div id="accountFields" style="display:{{ old('create_account') ? 'block' : 'none' }};">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('patients.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('createAccount').addEventListener('change', function(){
    document.getElementById('accountFields').style.display = this.checked ? 'block' : 'none';
});
</script>
@endsection
