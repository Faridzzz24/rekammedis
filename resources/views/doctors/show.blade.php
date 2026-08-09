@extends('layouts.main')
@section('page-title', 'dr. ' . $doctor->user->name)

@section('content')
<div style="margin-bottom: 16px;">
    <a href="{{ route('doctors.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card" style="margin-bottom: 20px;">
    <div class="card-head">
        <h2>Profil Dokter</h2>
        <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-secondary btn-sm">Edit</a>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item"><div class="dl">Nama</div><div class="dv">dr. {{ $doctor->user->name }}</div></div>
            <div class="detail-item"><div class="dl">Spesialisasi</div><div class="dv">{{ $doctor->specialization }}</div></div>
            <div class="detail-item"><div class="dl">Rumah Sakit</div><div class="dv">{{ $doctor->hospital->name }}</div></div>
            <div class="detail-item"><div class="dl">No. Lisensi</div><div class="dv">{{ $doctor->license_number }}</div></div>
            <div class="detail-item"><div class="dl">Email</div><div class="dv">{{ $doctor->user->email }}</div></div>
            <div class="detail-item"><div class="dl">Telepon</div><div class="dv">{{ $doctor->phone ?? '-' }}</div></div>
        </div>
    </div>
</div>
@endsection
