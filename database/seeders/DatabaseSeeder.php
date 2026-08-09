<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Hospital;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\MedicalRecord;
use App\Models\Referral;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === Admin ===
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@medrecord.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // === Rumah Sakit ===
        $rsA = Hospital::create([
            'name' => 'RS Harapan Bunda',
            'address' => 'Jl. Gatot Subroto No. 12, Jakarta Selatan',
            'phone' => '021-5551234',
            'email' => 'info@rsharapanbunda.id',
            'type' => 'umum',
        ]);

        $rsB = Hospital::create([
            'name' => 'RS Medika Utama',
            'address' => 'Jl. Sudirman No. 45, Jakarta Pusat',
            'phone' => '021-5555678',
            'email' => 'info@rsmedikautama.id',
            'type' => 'umum',
        ]);

        $rsC = Hospital::create([
            'name' => 'Klinik Sehat Sejahtera',
            'address' => 'Jl. Kemang Raya No. 8, Jakarta Selatan',
            'phone' => '021-5559012',
            'email' => 'info@kliniksehat.id',
            'type' => 'klinik',
        ]);

        // === Dokter ===
        $userDokterA = User::create([
            'name' => 'Andi Wijaya',
            'email' => 'andi@medrecord.test',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);
        $dokterA = Doctor::create([
            'user_id' => $userDokterA->id,
            'hospital_id' => $rsA->id,
            'specialization' => 'Umum',
            'license_number' => 'STR-2024-001',
            'phone' => '0812-0001-0001',
        ]);

        $userDokterB = User::create([
            'name' => 'Sari Puspita',
            'email' => 'sari@medrecord.test',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);
        $dokterB = Doctor::create([
            'user_id' => $userDokterB->id,
            'hospital_id' => $rsB->id,
            'specialization' => 'Penyakit Dalam',
            'license_number' => 'STR-2024-002',
            'phone' => '0812-0002-0002',
        ]);

        $userDokterC = User::create([
            'name' => 'Budi Hartono',
            'email' => 'budi@medrecord.test',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);
        $dokterC = Doctor::create([
            'user_id' => $userDokterC->id,
            'hospital_id' => $rsA->id,
            'specialization' => 'Neurologi',
            'license_number' => 'STR-2024-003',
            'phone' => '0812-0003-0003',
        ]);

        $userDokterD = User::create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi@medrecord.test',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);
        $dokterD = Doctor::create([
            'user_id' => $userDokterD->id,
            'hospital_id' => $rsC->id,
            'specialization' => 'Umum',
            'license_number' => 'STR-2024-004',
            'phone' => '0812-0004-0004',
        ]);

        // === Pasien ===
        $userPasien1 = User::create([
            'name' => 'Rudi Santoso',
            'email' => 'rudi@medrecord.test',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);
        $pasien1 = Patient::create([
            'user_id' => $userPasien1->id,
            'nik' => '3201010101900001',
            'name' => 'Rudi Santoso',
            'gender' => 'Laki-laki',
            'birth_date' => '1990-01-15',
            'birth_place' => 'Jakarta',
            'address' => 'Jl. Melati No. 5, RT 03/RW 02, Kebayoran Baru, Jakarta Selatan',
            'phone' => '0813-1000-1001',
            'blood_type' => 'O',
            'allergies' => 'Penisilin',
        ]);

        $pasien2 = Patient::create([
            'nik' => '3201020202850002',
            'name' => 'Siti Nurhaliza',
            'gender' => 'Perempuan',
            'birth_date' => '1985-06-20',
            'birth_place' => 'Bandung',
            'address' => 'Jl. Anggrek No. 12, Menteng, Jakarta Pusat',
            'phone' => '0813-2000-2002',
            'blood_type' => 'B',
            'allergies' => null,
        ]);

        $pasien3 = Patient::create([
            'nik' => '3201030303780003',
            'name' => 'Hasan Basri',
            'gender' => 'Laki-laki',
            'birth_date' => '1978-11-03',
            'birth_place' => 'Surabaya',
            'address' => 'Jl. Dahlia No. 7, Tebet, Jakarta Selatan',
            'phone' => '0813-3000-3003',
            'blood_type' => 'AB',
            'allergies' => 'Sulfa, Aspirin',
        ]);

        // === Rekam Medis ===

        // Pasien 1 - Kunjungan 1 di RS A
        $rm1 = MedicalRecord::create([
            'patient_id' => $pasien1->id,
            'doctor_id' => $dokterA->id,
            'hospital_id' => $rsA->id,
            'complaint' => 'Sakit kepala hebat sejak 3 hari lalu, disertai mual dan pandangan kabur. Nyeri terutama di bagian belakang kepala.',
            'diagnosis' => 'Cephalgia tension type. Suspek hipertensi grade I.',
            'treatment' => 'Pemberian analgesik (Paracetamol 500mg). Pemeriksaan tekanan darah serial. Anjuran konsultasi ke spesialis penyakit dalam.',
            'prescription' => "Paracetamol 500mg 3x1 (setelah makan)\nAmlodipin 5mg 1x1 (pagi)",
            'notes' => 'Pasien perlu dirujuk ke spesialis penyakit dalam untuk evaluasi hipertensi lebih lanjut.',
            'blood_pressure_sys' => 150,
            'blood_pressure_dia' => 95,
            'temperature' => 36.8,
            'weight' => 78.5,
            'heart_rate' => 88,
            'visit_date' => now()->subDays(5),
        ]);

        // Pasien 1 - Kunjungan 2 di RS B (setelah rujukan)
        $rm2 = MedicalRecord::create([
            'patient_id' => $pasien1->id,
            'doctor_id' => $dokterB->id,
            'hospital_id' => $rsB->id,
            'complaint' => 'Kontrol rujukan dari RS Harapan Bunda. Masih sering sakit kepala tapi frekuensi berkurang.',
            'diagnosis' => 'Hipertensi grade I terkontrol. Cephalgia membaik.',
            'treatment' => 'Lanjutkan terapi antihipertensi. Pemeriksaan lab darah lengkap. Kontrol 2 minggu.',
            'prescription' => "Amlodipin 5mg 1x1 (pagi)\nCandesartan 8mg 1x1 (malam)",
            'blood_pressure_sys' => 138,
            'blood_pressure_dia' => 88,
            'temperature' => 36.5,
            'weight' => 78.0,
            'heart_rate' => 82,
            'visit_date' => now()->subDays(2),
        ]);

        // Pasien 2 - Kunjungan di RS A
        $rm3 = MedicalRecord::create([
            'patient_id' => $pasien2->id,
            'doctor_id' => $dokterA->id,
            'hospital_id' => $rsA->id,
            'complaint' => 'Batuk berdahak sudah 1 minggu. Demam naik turun. Sesak napas ringan terutama malam hari.',
            'diagnosis' => 'Bronkitis akut',
            'treatment' => 'Nebulizer. Pemberian antibiotik dan ekspektoran.',
            'prescription' => "Azithromycin 500mg 1x1 (3 hari)\nAmbroxol 30mg 3x1\nSalbutamol inhaler 2 puff bila sesak",
            'blood_pressure_sys' => 120,
            'blood_pressure_dia' => 80,
            'temperature' => 38.2,
            'weight' => 55.0,
            'heart_rate' => 92,
            'visit_date' => now()->subDays(3),
        ]);

        // Pasien 3 - Kunjungan di Klinik
        $rm4 = MedicalRecord::create([
            'patient_id' => $pasien3->id,
            'doctor_id' => $dokterD->id,
            'hospital_id' => $rsC->id,
            'complaint' => 'Nyeri perut bagian atas, kembung, dan mual setelah makan. Sudah dirasakan 2 minggu.',
            'diagnosis' => 'Dispepsia fungsional. Perlu evaluasi lebih lanjut jika tidak membaik.',
            'treatment' => 'Pemberian antasida dan PPI. Edukasi pola makan.',
            'prescription' => "Omeprazole 20mg 2x1 (sebelum makan)\nDomperidone 10mg 3x1 (sebelum makan)\nSucralfat syrup 3x1 C",
            'blood_pressure_sys' => 125,
            'blood_pressure_dia' => 82,
            'temperature' => 36.6,
            'weight' => 72.0,
            'heart_rate' => 76,
            'visit_date' => now()->subDays(7),
        ]);

        // Pasien 3 - Kunjungan kedua
        $rm5 = MedicalRecord::create([
            'patient_id' => $pasien3->id,
            'doctor_id' => $dokterD->id,
            'hospital_id' => $rsC->id,
            'complaint' => 'Kontrol. Nyeri perut masih ada walau berkurang. Mual hilang timbul.',
            'diagnosis' => 'Dispepsia persisten. Suspek GERD. Rujuk ke spesialis penyakit dalam.',
            'treatment' => 'Lanjutkan PPI. Rujuk ke RS Medika Utama untuk endoskopi.',
            'prescription' => "Omeprazole 20mg 2x1 (lanjut)\nAntasida syrup prn",
            'notes' => 'Pasien memerlukan pemeriksaan endoskopi. Dirujuk ke dr. Sari di RS Medika Utama.',
            'blood_pressure_sys' => 128,
            'blood_pressure_dia' => 84,
            'temperature' => 36.5,
            'weight' => 71.5,
            'heart_rate' => 78,
            'visit_date' => now()->subDays(1),
        ]);

        // === Rujukan ===

        // Rujukan pasien 1: dr. Andi (RS A) -> dr. Sari (RS B)
        Referral::create([
            'medical_record_id' => $rm1->id,
            'from_doctor_id' => $dokterA->id,
            'from_hospital_id' => $rsA->id,
            'to_doctor_id' => $dokterB->id,
            'to_hospital_id' => $rsB->id,
            'reason' => 'Pasien memiliki tekanan darah tinggi (150/95 mmHg) yang memerlukan evaluasi dan penanganan oleh spesialis penyakit dalam. Sakit kepala kemungkinan terkait hipertensi.',
            'notes' => 'Hasil pemeriksaan awal terlampir dalam rekam medis. Pasien sudah diberikan Amlodipin 5mg sebagai terapi awal.',
            'status' => 'completed',
            'priority' => 'normal',
            'accepted_at' => now()->subDays(4),
            'completed_at' => now()->subDays(2),
        ]);

        // Rujukan pasien 3: dr. Dewi (Klinik) -> dr. Sari (RS B)
        Referral::create([
            'medical_record_id' => $rm5->id,
            'from_doctor_id' => $dokterD->id,
            'from_hospital_id' => $rsC->id,
            'to_doctor_id' => $dokterB->id,
            'to_hospital_id' => $rsB->id,
            'reason' => 'Pasien dengan dispepsia persisten yang tidak membaik dengan terapi konservatif. Memerlukan pemeriksaan endoskopi untuk menyingkirkan kelainan organik.',
            'status' => 'pending',
            'priority' => 'urgent',
        ]);
    }
}
