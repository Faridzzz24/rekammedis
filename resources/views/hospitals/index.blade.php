@extends('layouts.main')
@section('page-title', 'Rumah Sakit')

@section('content')
<div class="card">
    <div class="card-head">
        <h2>Daftar Rumah Sakit</h2>
        <a href="{{ route('hospitals.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
    </div>
    @if($hospitals->isEmpty())
        <div class="empty"><i class="fas fa-hospital"></i><p>Belum ada data rumah sakit</p></div>
    @else
    <div class="table-responsive">
        <table class="tbl">
            <thead><tr><th>Nama</th><th>Tipe</th><th>Alamat</th><th>Telepon</th><th>Dokter</th><th></th></tr></thead>
            <tbody>
                @foreach($hospitals as $h)
                <tr>
                    <td style="font-weight:500;">{{ $h->name }}</td>
                    <td><span class="badge badge-blue">{{ ucfirst($h->type) }}</span></td>
                    <td>{{ Str::limit($h->address, 40) }}</td>
                    <td>{{ $h->phone ?? '-' }}</td>
                    <td>{{ $h->doctors_count }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('hospitals.show', $h) }}" class="btn btn-secondary btn-xs">Detail</a>
                            <a href="{{ route('hospitals.edit', $h) }}" class="btn btn-secondary btn-xs">Edit</a>
                            <form method="POST" action="{{ route('hospitals.destroy', $h) }}" onsubmit="return confirm('Hapus rumah sakit ini?')" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-xs">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pagination-wrap">{{ $hospitals->links() }}</div>
    @endif
</div>
@endsection
