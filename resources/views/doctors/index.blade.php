@extends('layouts.main')
@section('page-title', 'Dokter')

@section('content')
<div class="card">
    <div class="card-head">
        <h2>Daftar Dokter</h2>
        <a href="{{ route('doctors.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
    </div>
    @if($doctors->isEmpty())
        <div class="empty"><i class="fas fa-user-md"></i><p>Belum ada data dokter</p></div>
    @else
    <table class="tbl">
        <thead><tr><th>Nama</th><th>Spesialisasi</th><th>Rumah Sakit</th><th>No. Lisensi</th><th></th></tr></thead>
        <tbody>
            @foreach($doctors as $d)
            <tr>
                <td style="font-weight:500;">dr. {{ $d->user->name }}</td>
                <td>{{ $d->specialization }}</td>
                <td>{{ $d->hospital->name }}</td>
                <td>{{ $d->license_number }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('doctors.show', $d) }}" class="btn btn-secondary btn-xs">Detail</a>
                        <a href="{{ route('doctors.edit', $d) }}" class="btn btn-secondary btn-xs">Edit</a>
                        <form method="POST" action="{{ route('doctors.destroy', $d) }}" onsubmit="return confirm('Hapus dokter ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-xs">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination-wrap">{{ $doctors->links() }}</div>
    @endif
</div>
@endsection
