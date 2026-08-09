@extends('layouts.main')
@section('page-title', 'Edit Dokter')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-head"><h2>Edit Dokter</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ route('doctors.update', $doctor) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Nama Lengkap *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $doctor->user->name) }}" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $doctor->user->email) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Rumah Sakit *</label>
                    <select name="hospital_id" class="form-control" required>
                        @foreach($hospitals as $h)
                        <option value="{{ $h->id }}" {{ old('hospital_id', $doctor->hospital_id) == $h->id ? 'selected' : '' }}>{{ $h->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Spesialisasi *</label>
                    <input type="text" name="specialization" class="form-control" value="{{ old('specialization', $doctor->specialization) }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">No. Lisensi (STR) *</label>
                    <input type="text" name="license_number" class="form-control" value="{{ old('license_number', $doctor->license_number) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $doctor->phone) }}">
                </div>
            </div>
            <div class="actions">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
