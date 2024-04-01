<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade'); // clé étrangère vers la table patients
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade'); // clé étrangère vers la table medecins
            $table->date('appointment_date'); // Date du rendez-vous
            $table->time('appointment_time'); // Heure du rendez-vous
            $table->enum('statut', ['En attente', 'Confirmé', 'Annulé', 'Autre'])->default('En attente'); // Statut du rendez-vous (confirmé, en attente, annulé, etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
