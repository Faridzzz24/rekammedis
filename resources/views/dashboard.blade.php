@extends('layouts.main')
@section('page-title', 'Dashboard')

@section('content')
@php $role = auth()->user()->role; @endphp

{{-- Admin Dashboard --}}
@if($role === 'admin')
<div class="stat-row">
    <div class="stat">
        <div class="stat-icon blue"><i class="fas fa-hospital"></i></div>
        <div class="num">{{ $stats['hospitals'] ?? 0 }}</div>
        <div class="label">Rumah Sakit</div>
    </div>
    <div class="stat">
        <div class="stat-icon green"><i class="fas fa-user-md"></i></div>
        <div class="num">{{ $stats['doctors'] ?? 0 }}</div>
        <div class="label">Dokter</div>
    </div>
    <div class="stat">
        <div class="stat-icon purple"><i class="fas fa-users"></i></div>
        <div class="num">{{ $stats['patients'] ?? 0 }}</div>
        <div class="label">Pasien</div>
    </div>
    <div class="stat">
        <div class="stat-icon amber"><i class="fas fa-share"></i></div>
        <div class="num">{{ $stats['referrals'] ?? 0 }}</div>
        <div class="label">Rujukan Pending</div>
    </div>
    <div class="stat">
        <div class="stat-icon cyan"><i class="fas fa-file-medical"></i></div>
        <div class="num">{{ $stats['records'] ?? 0 }}</div>
        <div class="label">Total Rekam Medis</div>
    </div>
</div>
@endif

{{-- Doctor Dashboard --}}
@if($role === 'doctor')
<div class="stat-row">
    <div class="stat">
        <div class="stat-icon blue"><i class="fas fa-calendar-check"></i></div>
        <div class="num">{{ $stats['patients_today'] ?? 0 }}</div>
        <div class="label">Pasien Hari Ini</div>
    </div>
    <div class="stat">
        <div class="stat-icon green"><i class="fas fa-users"></i></div>
        <div class="num">{{ $stats['total_patients'] ?? 0 }}</div>
        <div class="label">Total Pasien</div>
    </div>
    <div class="stat">
        <div class="stat-icon amber"><i class="fas fa-share"></i></div>
        <div class="num">{{ $stats['pending_referrals'] ?? 0 }}</div>
        <div class="label">Rujukan Masuk</div>
    </div>
    <div class="stat">
        <div class="stat-icon purple"><i class="fas fa-file-medical"></i></div>
        <div class="num">{{ $stats['records'] ?? 0 }}</div>
        <div class="label">Rekam Medis</div>
    </div>
</div>
@endif

{{-- Patient Dashboard --}}
@if($role === 'patient')
<div class="stat-row">
    <div class="stat">
        <div class="stat-icon blue"><i class="fas fa-clipboard-list"></i></div>
        <div class="num">{{ $stats['total_visits'] ?? 0 }}</div>
        <div class="label">Total Kunjungan</div>
    </div>
    <div class="stat">
        <div class="stat-icon green"><i class="fas fa-hospital"></i></div>
        <div class="num">{{ $stats['hospitals_visited'] ?? 0 }}</div>
        <div class="label">RS Dikunjungi</div>
    </div>
    <div class="stat">
        <div class="stat-icon amber"><i class="fas fa-share"></i></div>
        <div class="num">{{ $stats['active_referrals'] ?? 0 }}</div>
        <div class="label">Rujukan Aktif</div>
    </div>
</div>
@endif

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
    {{-- Recent Records --}}
    <div class="card">
        <div class="card-head">
            <h2>Rekam Medis Terbaru</h2>
            @if(in_array($role, ['admin','doctor']))
            <a href="{{ route('medical-records.index') }}" class="btn btn-secondary btn-xs">Lihat Semua</a>
            @endif
        </div>
        @if($recentRecords->isEmpty())
            <div class="empty"><i class="fas fa-inbox"></i><p>Belum ada data</p></div>
        @else
        <table class="tbl">
            <thead><tr><th>Pasien</th><th>Tanggal</th><th>Keluhan</th></tr></thead>
            <tbody>
                @foreach($recentRecords as $rec)
                <tr>
                    <td style="font-weight:500;">{{ $rec->patient->name }}</td>
                    <td>{{ $rec->visit_date->format('d/m/Y') }}</td>
                    <td>{{ Str::limit($rec->complaint, 40) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- Recent Referrals --}}
    <div class="card">
        <div class="card-head">
            <h2>Rujukan Terbaru</h2>
            @if(in_array($role, ['admin','doctor']))
            <a href="{{ route('referrals.index') }}" class="btn btn-secondary btn-xs">Lihat Semua</a>
            @endif
        </div>
        @if($recentReferrals->isEmpty())
            <div class="empty"><i class="fas fa-inbox"></i><p>Belum ada rujukan</p></div>
        @else
        <table class="tbl">
            <thead><tr><th>Dari</th><th>Ke</th><th>Status</th></tr></thead>
            <tbody>
                @foreach($recentReferrals as $ref)
                <tr>
                    <td>{{ $ref->fromDoctor->user->name ?? '-' }}</td>
                    <td>{{ $ref->toDoctor->user->name ?? '-' }}</td>
                    <td>
                        @if($ref->status === 'pending')<span class="badge badge-yellow">Pending</span>
                        @elseif($ref->status === 'accepted')<span class="badge badge-blue">Diterima</span>
                        @elseif($ref->status === 'completed')<span class="badge badge-green">Selesai</span>
                        @else<span class="badge badge-red">Ditolak</span>@endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
