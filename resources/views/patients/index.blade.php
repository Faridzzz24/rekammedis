@extends('layouts.main')
@section('page-title', 'Pasien')

@section('content')
<div class="card">
    <div class="card-head">
        <h2>Daftar Pasien</h2>
        <div class="actions">
            <form method="GET" action="{{ route('patients.index') }}" class="search-box" style="display:inline-block;">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="form-control" placeholder="Cari NIK atau nama..." value="{{ request('search') }}" style="width:220px;">
            </form>
            <a href="{{ route('patients.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
        </div>
    </div>
    @if($patients->isEmpty())
        <div class="empty"><i class="fas fa-users"></i><p>Belum ada data pasien</p></div>
    @else
    <table class="tbl">
        <thead><tr><th>NIK</th><th>Nama</th><th>Gender</th><th>Tgl Lahir</th><th>Gol. Darah</th><th>Telepon</th><th></th></tr></thead>
        <tbody>
            @foreach($patients as $p)
            <tr>
                <td style="font-family:monospace;font-size:12px;">{{ $p->nik }}</td>
                <td style="font-weight:500;">{{ $p->name }}</td>
                <td>{{ $p->gender === 'Laki-laki' ? 'L' : 'P' }}</td>
                <td>{{ $p->birth_date->format('d/m/Y') }}</td>
                <td>{{ $p->blood_type ?? '-' }}</td>
                <td>{{ $p->phone ?? '-' }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('patients.show', $p) }}" class="btn btn-secondary btn-xs">Detail</a>
                        <a href="{{ route('patients.edit', $p) }}" class="btn btn-secondary btn-xs">Edit</a>
                        <a href="{{ route('medical-records.create', ['patient_id' => $p->id]) }}" class="btn btn-primary btn-xs">+ Rekam Medis</a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination-wrap">{{ $patients->links() }}</div>
    @endif
</div>
@endsection
