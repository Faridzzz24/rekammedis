@extends('layouts.main')
@section('page-title', 'Detail Rujukan')

@section('content')
<div style="margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center;">
    <a href="{{ route('referrals.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
    @if(in_array(auth()->user()->role, ['admin','doctor']))
    <form method="POST" action="{{ route('referrals.destroy', $referral) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rujukan ini?')" style="display:inline;">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus Rujukan</button>
    </form>
    @endif
</div>

{{-- Transfer Flow --}}
<div class="card" style="margin-bottom: 20px;">
    <div class="card-head">
        <h2>Alur Rujukan</h2>
        <div>
            @if($referral->status === 'pending')<span class="badge badge-yellow">Pending</span>
            @elseif($referral->status === 'accepted')<span class="badge badge-blue">Diterima</span>
            @elseif($referral->status === 'completed')<span class="badge badge-green">Selesai</span>
            @else<span class="badge badge-red">Ditolak</span>@endif

            @if($referral->priority === 'emergency')<span class="badge badge-red" style="margin-left:4px;">Darurat</span>
            @elseif($referral->priority === 'urgent')<span class="badge badge-yellow" style="margin-left:4px;">Mendesak</span>@endif
        </div>
    </div>
    <div class="card-body">
        <div class="transfer-flow" style="margin-bottom: 16px;">
            <div class="transfer-node">
                <div class="tn-label">Asal</div>
                <div class="tn-val">dr. {{ $referral->fromDoctor->user->name }}</div>
                <div class="tn-sub">{{ $referral->fromHospital->name }}</div>
            </div>
            <div class="transfer-arrow"><i class="fas fa-long-arrow-alt-right"></i></div>
            <div class="transfer-node">
                <div class="tn-label">Tujuan</div>
                <div class="tn-val">dr. {{ $referral->toDoctor->user->name }}</div>
                <div class="tn-sub">{{ $referral->toHospital->name }}</div>
            </div>
        </div>

        <div>
            <div class="form-label">Alasan Rujukan</div>
            <div style="padding: 12px; background: #f9fafb; border-radius: 8px; border: 1px solid #e8eaed; white-space: pre-line; margin-bottom: 12px;">{{ $referral->reason }}</div>
        </div>
        @if($referral->notes)
        <div>
            <div class="form-label">Catatan</div>
            <div style="padding: 12px; background: #f9fafb; border-radius: 8px; border: 1px solid #e8eaed; white-space: pre-line;">{{ $referral->notes }}</div>
        </div>
        @endif

        {{-- Action Buttons --}}
        @if(auth()->user()->role === 'doctor' && auth()->user()->doctor && auth()->user()->doctor->id === $referral->to_doctor_id)
            @if($referral->status === 'pending')
            <div class="actions" style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #e8eaed;">
                <form method="POST" action="{{ route('referrals.accept', $referral) }}" style="display:inline;">
                    @csrf
                    <button class="btn btn-success btn-sm"><i class="fas fa-check"></i> Terima Rujukan</button>
                </form>
                <form method="POST" action="{{ route('referrals.reject', $referral) }}" style="display:inline;" onsubmit="return rejectReferral(this)">
                    @csrf
                    <input type="hidden" name="notes" id="rejectNotes">
                    <button class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Tolak</button>
                </form>
            </div>
            @elseif($referral->status === 'accepted')
            <div class="actions" style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #e8eaed;">
                <form method="POST" action="{{ route('referrals.complete', $referral) }}" style="display:inline;">
                    @csrf
                    <button class="btn btn-success btn-sm"><i class="fas fa-check-double"></i> Selesai</button>
                </form>
                <a href="{{ route('medical-records.create', ['patient_id' => $referral->medicalRecord->patient_id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Buat Rekam Medis Lanjutan</a>
            </div>
            @endif
        @endif

        @if(auth()->user()->role === 'admin')
            @if($referral->status === 'pending')
            <div class="actions" style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #e8eaed;">
                <form method="POST" action="{{ route('referrals.accept', $referral) }}" style="display:inline;">@csrf<button class="btn btn-success btn-sm">Terima</button></form>
                <form method="POST" action="{{ route('referrals.reject', $referral) }}" style="display:inline;" onsubmit="return rejectReferral(this)">
                    @csrf<input type="hidden" name="notes" id="rejectNotes2"><button class="btn btn-danger btn-sm">Tolak</button>
                </form>
            </div>
            @endif
        @endif
    </div>
</div>

{{-- Data Rekam Medis Asal --}}
<div class="card" style="margin-bottom: 20px;">
    <div class="card-head"><h2>Rekam Medis yang Dirujuk</h2></div>
    <div class="card-body">
        <div class="detail-grid" style="margin-bottom: 12px;">
            <div class="detail-item"><div class="dl">Pasien</div><div class="dv">{{ $referral->medicalRecord->patient->name }}</div></div>
            <div class="detail-item"><div class="dl">NIK</div><div class="dv" style="font-family:monospace;">{{ $referral->medicalRecord->patient->nik }}</div></div>
            <div class="detail-item"><div class="dl">Tanggal Periksa</div><div class="dv">{{ $referral->medicalRecord->visit_date->format('d/m/Y') }}</div></div>
        </div>
        <div style="display:grid;gap:10px;">
            <div><div class="form-label">Keluhan</div><div style="padding:10px;background:#f9fafb;border-radius:8px;border:1px solid #e8eaed;white-space:pre-line;">{{ $referral->medicalRecord->complaint }}</div></div>
            @if($referral->medicalRecord->diagnosis)
            <div><div class="form-label">Diagnosis</div><div style="padding:10px;background:#f9fafb;border-radius:8px;border:1px solid #e8eaed;white-space:pre-line;">{{ $referral->medicalRecord->diagnosis }}</div></div>
            @endif
            @if($referral->medicalRecord->treatment)
            <div><div class="form-label">Tindakan</div><div style="padding:10px;background:#f9fafb;border-radius:8px;border:1px solid #e8eaed;white-space:pre-line;">{{ $referral->medicalRecord->treatment }}</div></div>
            @endif
            @if($referral->medicalRecord->prescription)
            <div><div class="form-label">Resep Obat</div><div style="padding:10px;background:#f9fafb;border-radius:8px;border:1px solid #e8eaed;white-space:pre-line;">{{ $referral->medicalRecord->prescription }}</div></div>
            @endif
        </div>
    </div>
</div>

{{-- Riwayat Pasien --}}
<div class="card">
    <div class="card-head"><h2>Seluruh Riwayat Medis Pasien ({{ $patientHistory->count() }})</h2></div>
    @if($patientHistory->isEmpty())
        <div class="empty"><i class="fas fa-file-medical"></i><p>Belum ada riwayat</p></div>
    @else
    <table class="tbl">
        <thead><tr><th>Tanggal</th><th>Dokter</th><th>RS</th><th>Keluhan</th><th>Diagnosis</th></tr></thead>
        <tbody>
            @foreach($patientHistory as $h)
            <tr>
                <td>{{ $h->visit_date->format('d/m/Y') }}</td>
                <td>dr. {{ $h->doctor->user->name }}</td>
                <td>{{ $h->hospital->name }}</td>
                <td>{{ Str::limit($h->complaint, 40) }}</td>
                <td>{{ Str::limit($h->diagnosis ?? '-', 40) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

<script>
function rejectReferral(form) {
    const reason = prompt('Masukkan alasan penolakan:');
    if (!reason) return false;
    form.querySelector('input[name=notes]').value = reason;
    return true;
}
</script>
@endsection
