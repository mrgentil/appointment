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
        Schema::create('consultings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade'); // clé étrangère vers la table rendez_vous
            $table->date('consulting_date'); // Date de la consultation
            $table->time('consulting_time'); // Heure de la consultation
            $table->enum('type_consultation', ['En personne', 'En ligne'])->default('En personne');// Type de consultation (en personne, en ligne, etc.)
            $table->longText('details')->nullable(); // Autres détails de la consultation (notes, diagnostic, ordonnances, etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultings');
    }
};
