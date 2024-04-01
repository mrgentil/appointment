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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade'); // clé étrangère vers la table patients
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade'); // clé étrangère vers la table medecins
            $table->integer('note'); // Note attribuée à la consultation
            $table->text('commentaire')->nullable(); // Commentaire facultatif sur la consultation
            $table->date('date_evaluation'); // Date de l'évaluation
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
