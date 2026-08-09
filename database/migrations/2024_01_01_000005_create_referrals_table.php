<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained()->onDelete('cascade');
            $table->foreignId('from_doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('from_hospital_id')->constrained('hospitals')->onDelete('cascade');
            $table->foreignId('to_doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('to_hospital_id')->constrained('hospitals')->onDelete('cascade');
            $table->text('reason'); // Alasan rujukan
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->enum('status', ['pending', 'accepted', 'completed', 'rejected'])->default('pending');
            $table->enum('priority', ['normal', 'urgent', 'emergency'])->default('normal');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
