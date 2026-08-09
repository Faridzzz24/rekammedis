@extends('layouts.main')
@section('page-title', $hospital->name)

@section('content')
<div style="margin-bottom: 16px;">
    <a href="{{ route('hospitals.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card" style="margin-bottom: 20px;">
    <div class="card-head">
        <h2>Detail Rumah Sakit</h2>
        <a href="{{ route('hospitals.edit', $hospital) }}" class="btn btn-secondary btn-sm">Edit</a>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item"><div class="dl">Nama</div><div class="dv">{{ $hospital->name }}</div></div>
            <div class="detail-item"><div class="dl">Tipe</div><div class="dv">{{ ucfirst($hospital->type) }}</div></div>
            <div class="detail-item"><div class="dl">Telepon</div><div class="dv">{{ $hospital->phone ?? '-' }}</div></div>
            <div class="detail-item"><div class="dl">Email</div><div class="dv">{{ $hospital->email ?? '-' }}</div></div>
        </div>
        <div style="margin-top: 12px;">
            <div class="detail-item"><div class="dl">Alamat</div><div class="dv">{{ $hospital->address }}</div></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>Dokter di Rumah Sakit Ini ({{ $hospital->doctors->count() }})</h2></div>
    @if($hospital->doctors->isEmpty())
        <div class="empty"><i class="fas fa-user-md"></i><p>Belum ada dokter terdaftar</p></div>
    @else
    <table class="tbl">
        <thead><tr><th>Nama</th><th>Spesialisasi</th><th>No. Lisensi</th></tr></thead>
        <tbody>
            @foreach($hospital->doctors as $d)
            <tr>
                <td style="font-weight:500;">{{ $d->user->name }}</td>
                <td>{{ $d->specialization }}</td>
                <td>{{ $d->license_number }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
