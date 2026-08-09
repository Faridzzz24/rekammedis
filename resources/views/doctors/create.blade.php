@extends('layouts.main')
@section('page-title', 'Tambah Dokter')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-head"><h2>Tambah Dokter</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ route('doctors.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Lengkap *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password *</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Rumah Sakit *</label>
                    <select name="hospital_id" class="form-control" required>
                        <option value="">Pilih Rumah Sakit</option>
                        @foreach($hospitals as $h)
                        <option value="{{ $h->id }}" {{ old('hospital_id') == $h->id ? 'selected' : '' }}>{{ $h->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Spesialisasi *</label>
                    <input type="text" name="specialization" class="form-control" value="{{ old('specialization') }}" placeholder="Contoh: Penyakit Dalam" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">No. Lisensi (STR) *</label>
                    <input type="text" name="license_number" class="form-control" value="{{ old('license_number') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
            </div>
            <div class="actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
