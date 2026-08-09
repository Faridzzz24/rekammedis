@extends('layouts.main')
@section('page-title', 'Rujukan')

@section('content')
<div class="card">
    <div class="card-head">
        <h2>Daftar Rujukan</h2>
        <div class="actions">
            <form method="GET" action="{{ route('referrals.index') }}" style="display:inline-flex;gap:8px;">
                <select name="status" class="form-control" style="width:140px;" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Diterima</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </form>
            @if(in_array(auth()->user()->role, ['admin','doctor']))
            <a href="{{ route('referrals.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Buat Rujukan</a>
            @endif
        </div>
    </div>
    @if($referrals->isEmpty())
        <div class="empty"><i class="fas fa-share"></i><p>Belum ada rujukan</p></div>
    @else
    <table class="tbl">
        <thead><tr><th>Pasien</th><th>Dari</th><th>Tujuan</th><th>Prioritas</th><th>Status</th><th>Tanggal</th><th></th></tr></thead>
        <tbody>
            @foreach($referrals as $ref)
            <tr>
                <td style="font-weight:500;">{{ $ref->medicalRecord->patient->name }}</td>
                <td>
                    <div style="font-size:13px;">dr. {{ $ref->fromDoctor->user->name }}</div>
                    <div style="font-size:11px;color:#6b7280;">{{ $ref->fromHospital->name }}</div>
                </td>
                <td>
                    <div style="font-size:13px;">dr. {{ $ref->toDoctor->user->name }}</div>
                    <div style="font-size:11px;color:#6b7280;">{{ $ref->toHospital->name }}</div>
                </td>
                <td>
                    @if($ref->priority === 'emergency')<span class="badge badge-red">Darurat</span>
                    @elseif($ref->priority === 'urgent')<span class="badge badge-yellow">Mendesak</span>
                    @else<span class="badge badge-gray">Normal</span>@endif
                </td>
                <td>
                    @if($ref->status === 'pending')<span class="badge badge-yellow">Pending</span>
                    @elseif($ref->status === 'accepted')<span class="badge badge-blue">Diterima</span>
                    @elseif($ref->status === 'completed')<span class="badge badge-green">Selesai</span>
                    @else<span class="badge badge-red">Ditolak</span>@endif
                </td>
                <td>{{ $ref->created_at->format('d/m/Y') }}</td>
                <td style="white-space:nowrap;">
                    <div class="actions">
                        <a href="{{ route('referrals.show', $ref) }}" class="btn btn-secondary btn-xs">Detail</a>
                        @if(in_array(auth()->user()->role, ['admin','doctor']))
                        <form method="POST" action="{{ route('referrals.destroy', $ref) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rujukan ini?')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs">Hapus</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination-wrap">{{ $referrals->links() }}</div>
    @endif
</div>
@endsection
