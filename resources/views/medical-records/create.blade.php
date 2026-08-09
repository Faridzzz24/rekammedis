@extends('layouts.main')
@section('page-title', 'Tambah Rekam Medis')

@section('content')
<div class="card" style="max-width: 800px;">
    <div class="card-head"><h2>Rekam Medis Baru</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ route('medical-records.store') }}">
            @csrf

            {{-- Pasien & Dokter --}}
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Pasien *</label>
                    <select name="patient_id" class="form-control" required>
                        <option value="">Pilih Pasien</option>
                        @foreach($patients as $p)
                        <option value="{{ $p->id }}" {{ (old('patient_id') ?? ($selectedPatient->id ?? '')) == $p->id ? 'selected' : '' }}>
                            {{ $p->name }} — {{ $p->nik }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Kunjungan *</label>
                    <input type="date" name="visit_date" class="form-control" value="{{ old('visit_date', date('Y-m-d')) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Dokter *</label>
                    <select name="doctor_id" class="form-control" required>
                        <option value="">Pilih Dokter</option>
                        @foreach($doctors as $d)
                        <option value="{{ $d->id }}" {{ old('doctor_id', auth()->user()->doctor->id ?? '') == $d->id ? 'selected' : '' }}>
                            dr. {{ $d->user->name }} — {{ $d->specialization }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Rumah Sakit *</label>
                    <select name="hospital_id" class="form-control" required>
                        <option value="">Pilih RS</option>
                        @foreach($hospitals as $h)
                        <option value="{{ $h->id }}" {{ old('hospital_id', auth()->user()->doctor->hospital_id ?? '') == $h->id ? 'selected' : '' }}>
                            {{ $h->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Vital Signs --}}
            <div style="border-top: 1px solid #e8eaed; padding-top: 16px; margin-top: 8px; margin-bottom: 16px;">
                <div class="form-label" style="margin-bottom: 12px; font-size: 13px; color: #1a1a2e;">Tanda Vital</div>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 12px;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Tekanan Darah (sys)</label>
                        <input type="number" step="0.1" name="blood_pressure_sys" class="form-control" value="{{ old('blood_pressure_sys') }}" placeholder="mmHg">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Tekanan Darah (dia)</label>
                        <input type="number" step="0.1" name="blood_pressure_dia" class="form-control" value="{{ old('blood_pressure_dia') }}" placeholder="mmHg">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Suhu (°C)</label>
                        <input type="number" step="0.1" name="temperature" class="form-control" value="{{ old('temperature') }}" placeholder="36.5">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Berat (kg)</label>
                        <input type="number" step="0.1" name="weight" class="form-control" value="{{ old('weight') }}">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Detak Jantung</label>
                        <input type="number" name="heart_rate" class="form-control" value="{{ old('heart_rate') }}" placeholder="bpm">
                    </div>
                </div>
            </div>

            {{-- Keluhan & Diagnosis --}}
            <div class="form-group">
                <label class="form-label">Keluhan Pasien *</label>
                <textarea name="complaint" class="form-control" required placeholder="Tuliskan keluhan pasien...">{{ old('complaint') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Diagnosis</label>
                <textarea name="diagnosis" class="form-control" placeholder="Diagnosis dokter...">{{ old('diagnosis') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Tindakan</label>
                <textarea name="treatment" class="form-control" placeholder="Tindakan yang dilakukan...">{{ old('treatment') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Resep Obat</label>
                <textarea name="prescription" class="form-control" placeholder="Obat yang diresepkan...">{{ old('prescription') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Catatan Tambahan</label>
                <textarea name="notes" class="form-control" style="min-height:60px;" placeholder="Catatan lainnya...">{{ old('notes') }}</textarea>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Simpan Rekam Medis</button>
                <a href="{{ route('medical-records.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
