@extends('layouts.main')
@section('page-title', 'Edit Rumah Sakit')

@section('content')
<div class="card" style="max-width: 600px;">
    <div class="card-head"><h2>Edit Rumah Sakit</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ route('hospitals.update', $hospital) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Nama Rumah Sakit *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $hospital->name) }}" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tipe *</label>
                    <select name="type" class="form-control" required>
                        <option value="umum" {{ old('type', $hospital->type) == 'umum' ? 'selected' : '' }}>Umum</option>
                        <option value="khusus" {{ old('type', $hospital->type) == 'khusus' ? 'selected' : '' }}>Khusus</option>
                        <option value="klinik" {{ old('type', $hospital->type) == 'klinik' ? 'selected' : '' }}>Klinik</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $hospital->phone) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $hospital->email) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Alamat *</label>
                <textarea name="address" class="form-control" required>{{ old('address', $hospital->address) }}</textarea>
            </div>
            <div class="actions">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('hospitals.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
