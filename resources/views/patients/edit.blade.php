@extends('layouts.main')
@section('page-title', 'Edit Pasien')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-head"><h2>Edit Data Pasien</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ route('patients.update', $patient) }}">
            @csrf @method('PUT')
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">NIK (16 digit) *</label>
                    <input type="text" name="nik" class="form-control" value="{{ old('nik', $patient->nik) }}" maxlength="16" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $patient->name) }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Jenis Kelamin *</label>
                    <select name="gender" class="form-control" required>
                        <option value="Laki-laki" {{ old('gender', $patient->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', $patient->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Lahir *</label>
                    <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $patient->birth_date->format('Y-m-d')) }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="birth_place" class="form-control" value="{{ old('birth_place', $patient->birth_place) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $patient->phone) }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Golongan Darah</label>
                    <select name="blood_type" class="form-control">
                        <option value="">-</option>
                        @foreach(['A','B','AB','O','A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
                        <option value="{{ $bt }}" {{ old('blood_type', $patient->blood_type) == $bt ? 'selected' : '' }}>{{ $bt }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Alergi</label>
                    <input type="text" name="allergies" class="form-control" value="{{ old('allergies', $patient->allergies) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Alamat *</label>
                <textarea name="address" class="form-control" required>{{ old('address', $patient->address) }}</textarea>
            </div>
            <div class="actions">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('patients.show', $patient) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
