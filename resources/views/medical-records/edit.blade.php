@extends('layouts.main')
@section('page-title', 'Edit Rekam Medis')

@section('content')
<div class="card" style="max-width: 800px;">
    <div class="card-head"><h2>Edit Rekam Medis</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ route('medical-records.update', $medicalRecord) }}">
            @csrf @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Pasien *</label>
                    <select name="patient_id" class="form-control" required>
                        @foreach($patients as $p)
                        <option value="{{ $p->id }}" {{ old('patient_id', $medicalRecord->patient_id) == $p->id ? 'selected' : '' }}>{{ $p->name }} — {{ $p->nik }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Kunjungan *</label>
                    <input type="date" name="visit_date" class="form-control" value="{{ old('visit_date', $medicalRecord->visit_date->format('Y-m-d')) }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Dokter *</label>
                    <select name="doctor_id" class="form-control" required>
                        @foreach($doctors as $d)
                        <option value="{{ $d->id }}" {{ old('doctor_id', $medicalRecord->doctor_id) == $d->id ? 'selected' : '' }}>dr. {{ $d->user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Rumah Sakit *</label>
                    <select name="hospital_id" class="form-control" required>
                        @foreach($hospitals as $h)
                        <option value="{{ $h->id }}" {{ old('hospital_id', $medicalRecord->hospital_id) == $h->id ? 'selected' : '' }}>{{ $h->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 12px; margin-bottom: 16px;">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">TD Sistolik</label>
                    <input type="number" step="0.1" name="blood_pressure_sys" class="form-control" value="{{ old('blood_pressure_sys', $medicalRecord->blood_pressure_sys) }}">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">TD Diastolik</label>
                    <input type="number" step="0.1" name="blood_pressure_dia" class="form-control" value="{{ old('blood_pressure_dia', $medicalRecord->blood_pressure_dia) }}">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Suhu (°C)</label>
                    <input type="number" step="0.1" name="temperature" class="form-control" value="{{ old('temperature', $medicalRecord->temperature) }}">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Berat (kg)</label>
                    <input type="number" step="0.1" name="weight" class="form-control" value="{{ old('weight', $medicalRecord->weight) }}">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Detak Jantung</label>
                    <input type="number" name="heart_rate" class="form-control" value="{{ old('heart_rate', $medicalRecord->heart_rate) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Keluhan *</label>
                <textarea name="complaint" class="form-control" required>{{ old('complaint', $medicalRecord->complaint) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Diagnosis</label>
                <textarea name="diagnosis" class="form-control">{{ old('diagnosis', $medicalRecord->diagnosis) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Tindakan</label>
                <textarea name="treatment" class="form-control">{{ old('treatment', $medicalRecord->treatment) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Resep Obat</label>
                <textarea name="prescription" class="form-control">{{ old('prescription', $medicalRecord->prescription) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Catatan</label>
                <textarea name="notes" class="form-control" style="min-height:60px;">{{ old('notes', $medicalRecord->notes) }}</textarea>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('medical-records.show', $medicalRecord) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
