@extends('layouts.main')
@section('page-title', $patient->name)

@section('content')
<div style="margin-bottom: 16px;">
    <a href="{{ route('patients.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card" style="margin-bottom: 20px;">
    <div class="card-head">
        <h2>Data Pasien</h2>
        <div class="actions">
            <a href="{{ route('medical-records.create', ['patient_id' => $patient->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Rekam Medis Baru</a>
            <a href="{{ route('patients.edit', $patient) }}" class="btn btn-secondary btn-sm">Edit</a>
        </div>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item"><div class="dl">NIK</div><div class="dv" style="font-family:monospace;">{{ $patient->nik }}</div></div>
            <div class="detail-item"><div class="dl">Nama</div><div class="dv">{{ $patient->name }}</div></div>
            <div class="detail-item"><div class="dl">Gender</div><div class="dv">{{ $patient->gender }}</div></div>
            <div class="detail-item"><div class="dl">Tanggal Lahir</div><div class="dv">{{ $patient->birth_date->format('d/m/Y') }} ({{ $patient->age }} thn)</div></div>
            <div class="detail-item"><div class="dl">Tempat Lahir</div><div class="dv">{{ $patient->birth_place ?? '-' }}</div></div>
            <div class="detail-item"><div class="dl">Gol. Darah</div><div class="dv">{{ $patient->blood_type ?? '-' }}</div></div>
            <div class="detail-item"><div class="dl">Telepon</div><div class="dv">{{ $patient->phone ?? '-' }}</div></div>
            <div class="detail-item"><div class="dl">Alergi</div><div class="dv">{{ $patient->allergies ?: 'Tidak ada' }}</div></div>
        </div>
        <div style="margin-top: 12px;">
            <div class="detail-item"><div class="dl">Alamat</div><div class="dv">{{ $patient->address }}</div></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>Riwayat Rekam Medis ({{ $patient->medicalRecords->count() }})</h2></div>
    @if($patient->medicalRecords->isEmpty())
        <div class="empty"><i class="fas fa-file-medical"></i><p>Belum ada rekam medis</p></div>
    @else
    <table class="tbl">
        <thead><tr><th>Tanggal</th><th>Dokter</th><th>RS</th><th>Keluhan</th><th>Diagnosis</th><th>Rujukan</th><th></th></tr></thead>
        <tbody>
            @foreach($patient->medicalRecords as $rec)
            <tr>
                <td>{{ $rec->visit_date->format('d/m/Y') }}</td>
                <td>dr. {{ $rec->doctor->user->name }}</td>
                <td>{{ $rec->hospital->name }}</td>
                <td>{{ Str::limit($rec->complaint, 30) }}</td>
                <td>{{ Str::limit($rec->diagnosis ?? '-', 30) }}</td>
                <td>
                    @if($rec->referral)
                        <span class="badge badge-{{ $rec->referral->status === 'completed' ? 'green' : ($rec->referral->status === 'pending' ? 'yellow' : 'blue') }}">
                            {{ ucfirst($rec->referral->status) }}
                        </span>
                    @else
                        <span style="color:#9ca3af;">—</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('medical-records.show', $rec) }}" class="btn btn-secondary btn-xs">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
