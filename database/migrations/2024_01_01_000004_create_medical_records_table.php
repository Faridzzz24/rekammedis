<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('hospital_id')->constrained()->onDelete('cascade');
            $table->text('complaint'); // Keluhan
            $table->text('diagnosis')->nullable(); // Diagnosis
            $table->text('treatment')->nullable(); // Tindakan
            $table->text('prescription')->nullable(); // Resep obat
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->decimal('blood_pressure_sys', 5, 1)->nullable();
            $table->decimal('blood_pressure_dia', 5, 1)->nullable();
            $table->decimal('temperature', 4, 1)->nullable();
            $table->decimal('weight', 5, 1)->nullable();
            $table->integer('heart_rate')->nullable();
            $table->date('visit_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
