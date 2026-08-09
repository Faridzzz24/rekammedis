@extends('layouts.main')
@section('page-title', 'Buat Rujukan')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-head"><h2>Buat Rujukan Baru</h2></div>
    <div class="card-body">

        @if($medicalRecord)
        <div style="background:#f9fafb;border:1px solid #e8eaed;border-radius:8px;padding:12px;margin-bottom:20px;">
            <div style="font-size:12px;font-weight:600;color:#6b7280;margin-bottom:4px;">Rekam Medis yang Dirujuk</div>
            <div style="font-weight:500;">{{ $medicalRecord->patient->name }} — {{ $medicalRecord->visit_date->format('d/m/Y') }}</div>
            <div style="font-size:12px;color:#6b7280;">Dokter: dr. {{ $medicalRecord->doctor->user->name }} | RS: {{ $medicalRecord->hospital->name }}</div>
            <div style="font-size:12px;color:#6b7280;margin-top:4px;">Keluhan: {{ Str::limit($medicalRecord->complaint, 80) }}</div>
        </div>
        @endif

        <form method="POST" action="{{ route('referrals.store') }}">
            @csrf

            @if($medicalRecord)
                <input type="hidden" name="medical_record_id" value="{{ $medicalRecord->id }}">
            @else
            <div class="form-group">
                <label class="form-label">Rekam Medis *</label>
                <select name="medical_record_id" class="form-control" required>
                    <option value="">Pilih rekam medis</option>
                    @foreach($medicalRecords as $mr)
                    <option value="{{ $mr->id }}" {{ old('medical_record_id') == $mr->id ? 'selected' : '' }}>
                        {{ $mr->patient->name }} — {{ $mr->visit_date->format('d/m/Y') }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="form-group">
                <label class="form-label">Rumah Sakit Tujuan *</label>
                <select name="to_hospital_id" class="form-control" required id="toHospital">
                    <option value="">Pilih RS tujuan</option>
                    @foreach($hospitals as $h)
                    <option value="{{ $h->id }}" {{ old('to_hospital_id') == $h->id ? 'selected' : '' }}>{{ $h->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Dokter Tujuan *</label>
                <select name="to_doctor_id" class="form-control" required id="toDoctor">
                    <option value="">Pilih dokter tujuan</option>
                    @foreach($doctors as $d)
                    <option value="{{ $d->id }}" data-hospital="{{ $d->hospital_id }}" {{ old('to_doctor_id') == $d->id ? 'selected' : '' }}>
                        dr. {{ $d->user->name }} — {{ $d->specialization }} ({{ $d->hospital->name }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Prioritas *</label>
                <select name="priority" class="form-control" required>
                    <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                    <option value="emergency" {{ old('priority') == 'emergency' ? 'selected' : '' }}>Darurat</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Alasan Rujukan *</label>
                <textarea name="reason" class="form-control" required placeholder="Jelaskan alasan merujuk pasien ini...">{{ old('reason') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Catatan Tambahan</label>
                <textarea name="notes" class="form-control" style="min-height:60px;" placeholder="Informasi tambahan untuk dokter tujuan...">{{ old('notes') }}</textarea>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Kirim Rujukan</button>
                <a href="{{ route('referrals.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
// Filter dokter berdasarkan RS yang dipilih
document.getElementById('toHospital').addEventListener('change', function(){
    const hospitalId = this.value;
    const doctorSelect = document.getElementById('toDoctor');
    const options = doctorSelect.querySelectorAll('option[data-hospital]');

    options.forEach(opt => {
        if (!hospitalId || opt.dataset.hospital === hospitalId) {
            opt.style.display = '';
        } else {
            opt.style.display = 'none';
            if (opt.selected) opt.selected = false;
        }
    });
});
</script>
@endsection
