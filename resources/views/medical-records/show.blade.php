@extends('layouts.main')
@section('page-title', 'Detail Rekam Medis')

@section('content')
<div style="margin-bottom: 16px;">
    <a href="{{ route('medical-records.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

{{-- Info Pasien --}}
<div class="card" style="margin-bottom: 20px;">
    <div class="card-head">
        <h2>Pasien: {{ $medicalRecord->patient->name }}</h2>
        <div class="actions">
            @if(in_array(auth()->user()->role, ['admin','doctor']))
            <a href="{{ route('medical-records.edit', $medicalRecord) }}" class="btn btn-secondary btn-sm">Edit</a>
            @if(!$medicalRecord->referral)
            <a href="{{ route('referrals.create', ['medical_record_id' => $medicalRecord->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-share"></i> Buat Rujukan</a>
            @endif
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item"><div class="dl">NIK</div><div class="dv" style="font-family:monospace;">{{ $medicalRecord->patient->nik }}</div></div>
            <div class="detail-item"><div class="dl">Gender</div><div class="dv">{{ $medicalRecord->patient->gender }}</div></div>
            <div class="detail-item"><div class="dl">Umur</div><div class="dv">{{ $medicalRecord->patient->age }} tahun</div></div>
            <div class="detail-item"><div class="dl">Gol. Darah</div><div class="dv">{{ $medicalRecord->patient->blood_type ?? '-' }}</div></div>
            <div class="detail-item"><div class="dl">Alergi</div><div class="dv">{{ $medicalRecord->patient->allergies ?: 'Tidak ada' }}</div></div>
        </div>
    </div>
</div>

{{-- Rekam Medis --}}
<div class="card" style="margin-bottom: 20px;">
    <div class="card-head"><h2>Rekam Medis — {{ $medicalRecord->visit_date->format('d F Y') }}</h2></div>
    <div class="card-body">
        <div class="detail-grid" style="margin-bottom: 16px;">
            <div class="detail-item"><div class="dl">Dokter</div><div class="dv">dr. {{ $medicalRecord->doctor->user->name }}</div></div>
            <div class="detail-item"><div class="dl">Rumah Sakit</div><div class="dv">{{ $medicalRecord->hospital->name }}</div></div>
            <div class="detail-item"><div class="dl">Tanggal</div><div class="dv">{{ $medicalRecord->visit_date->format('d/m/Y') }}</div></div>
        </div>

        @if($medicalRecord->blood_pressure_sys || $medicalRecord->temperature || $medicalRecord->weight || $medicalRecord->heart_rate)
        <div style="margin-bottom: 16px;">
            <div class="form-label" style="margin-bottom: 8px;">Tanda Vital</div>
            <div class="detail-grid">
                @if($medicalRecord->blood_pressure_sys)
                <div class="detail-item"><div class="dl">Tekanan Darah</div><div class="dv">{{ $medicalRecord->blood_pressure_sys }}/{{ $medicalRecord->blood_pressure_dia }} mmHg</div></div>
                @endif
                @if($medicalRecord->temperature)
                <div class="detail-item"><div class="dl">Suhu</div><div class="dv">{{ $medicalRecord->temperature }} °C</div></div>
                @endif
                @if($medicalRecord->weight)
                <div class="detail-item"><div class="dl">Berat Badan</div><div class="dv">{{ $medicalRecord->weight }} kg</div></div>
                @endif
                @if($medicalRecord->heart_rate)
                <div class="detail-item"><div class="dl">Detak Jantung</div><div class="dv">{{ $medicalRecord->heart_rate }} bpm</div></div>
                @endif
            </div>
        </div>
        @endif

        <div style="display: grid; gap: 12px;">
            <div>
                <div class="form-label">Keluhan</div>
                <div style="padding: 12px; background: #f9fafb; border-radius: 8px; border: 1px solid #e8eaed; white-space: pre-line;">{{ $medicalRecord->complaint }}</div>
            </div>
            @if($medicalRecord->diagnosis)
            <div>
                <div class="form-label">Diagnosis</div>
                <div style="padding: 12px; background: #f9fafb; border-radius: 8px; border: 1px solid #e8eaed; white-space: pre-line;">{{ $medicalRecord->diagnosis }}</div>
            </div>
            @endif
            @if($medicalRecord->treatment)
            <div>
                <div class="form-label">Tindakan</div>
                <div style="padding: 12px; background: #f9fafb; border-radius: 8px; border: 1px solid #e8eaed; white-space: pre-line;">{{ $medicalRecord->treatment }}</div>
            </div>
            @endif
            @if($medicalRecord->prescription)
            <div>
                <div class="form-label">Resep Obat</div>
                <div style="padding: 12px; background: #f9fafb; border-radius: 8px; border: 1px solid #e8eaed; white-space: pre-line;">{{ $medicalRecord->prescription }}</div>
            </div>
            @endif
            @if($medicalRecord->notes)
            <div>
                <div class="form-label">Catatan</div>
                <div style="padding: 12px; background: #f9fafb; border-radius: 8px; border: 1px solid #e8eaed; white-space: pre-line;">{{ $medicalRecord->notes }}</div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Rujukan (jika ada) --}}
@if($medicalRecord->referral)
<div class="card">
    <div class="card-head"><h2>Rujukan</h2></div>
    <div class="card-body">
        <div class="transfer-flow" style="margin-bottom: 16px;">
            <div class="transfer-node">
                <div class="tn-label">Dari</div>
                <div class="tn-val">dr. {{ $medicalRecord->referral->fromDoctor->user->name }}</div>
                <div class="tn-sub">{{ $medicalRecord->referral->fromHospital->name }}</div>
            </div>
            <div class="transfer-arrow"><i class="fas fa-arrow-right"></i></div>
            <div class="transfer-node">
                <div class="tn-label">Ke</div>
                <div class="tn-val">dr. {{ $medicalRecord->referral->toDoctor->user->name }}</div>
                <div class="tn-sub">{{ $medicalRecord->referral->toHospital->name }}</div>
            </div>
        </div>
        <div class="detail-grid">
            <div class="detail-item">
                <div class="dl">Status</div>
                <div class="dv">
                    @if($medicalRecord->referral->status === 'pending')<span class="badge badge-yellow">Pending</span>
                    @elseif($medicalRecord->referral->status === 'accepted')<span class="badge badge-blue">Diterima</span>
                    @elseif($medicalRecord->referral->status === 'completed')<span class="badge badge-green">Selesai</span>
                    @else<span class="badge badge-red">Ditolak</span>@endif
                </div>
            </div>
            <div class="detail-item"><div class="dl">Prioritas</div><div class="dv">{{ ucfirst($medicalRecord->referral->priority) }}</div></div>
        </div>
        <div style="margin-top: 12px;">
            <div class="form-label">Alasan Rujukan</div>
            <div style="padding: 12px; background: #f9fafb; border-radius: 8px; border: 1px solid #e8eaed;">{{ $medicalRecord->referral->reason }}</div>
        </div>
    </div>
</div>
@endif
@endsection
