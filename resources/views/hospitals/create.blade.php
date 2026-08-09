@extends('layouts.main')
@section('page-title', 'Tambah Rumah Sakit')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-head"><h2>Tambah Rumah Sakit</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ route('hospitals.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Rumah Sakit *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tipe *</label>
                    <select name="type" class="form-control" required>
                        <option value="umum" {{ old('type') == 'umum' ? 'selected' : '' }}>Umum</option>
                        <option value="khusus" {{ old('type') == 'khusus' ? 'selected' : '' }}>Khusus</option>
                        <option value="klinik" {{ old('type') == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Alamat *</label>
                <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
            </div>
            <div class="actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('hospitals.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
