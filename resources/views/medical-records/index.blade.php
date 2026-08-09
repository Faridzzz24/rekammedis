@extends('layouts.main')
@section('page-title', 'Rekam Medis')

@section('content')
<div class="card">
    <div class="card-head">
        <h2>Daftar Rekam Medis</h2>
        <div class="actions">
            <form method="GET" action="{{ route('medical-records.index') }}" class="search-box" style="display:inline-block;">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="form-control" placeholder="Cari pasien..." value="{{ request('search') }}" style="width:200px;">
            </form>
            @if(in_array(auth()->user()->role, ['admin','doctor']))
            <a href="{{ route('medical-records.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
            @endif
        </div>
    </div>
    @if($records->isEmpty())
        <div class="empty"><i class="fas fa-file-medical"></i><p>Belum ada rekam medis</p></div>
    @else
    <table class="tbl">
        <thead><tr><th>Tanggal</th><th>Pasien</th><th>Dokter</th><th>RS</th><th>Keluhan</th><th>Diagnosis</th><th></th></tr></thead>
        <tbody>
            @foreach($records as $r)
            <tr>
                <td>{{ $r->visit_date->format('d/m/Y') }}</td>
                <td style="font-weight:500;">{{ $r->patient->name }}</td>
                <td>dr. {{ $r->doctor->user->name }}</td>
                <td>{{ $r->hospital->name }}</td>
                <td>{{ Str::limit($r->complaint, 30) }}</td>
                <td>{{ Str::limit($r->diagnosis ?? '-', 30) }}</td>
                <td>
                    <a href="{{ route('medical-records.show', $r) }}" class="btn btn-secondary btn-xs">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination-wrap">{{ $records->links() }}</div>
    @endif
</div>
@endsection
