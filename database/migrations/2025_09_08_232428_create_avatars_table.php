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
        Schema::create('avatars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('filename'); // Nombre del archivo guardado
            $table->string('original_name')->nullable(); // Nombre original del archivo
            $table->string('mime_type')->nullable(); // image/jpeg, image/png, etc.
            $table->unsignedInteger('size')->nullable(); // Tamaño en bytes
            $table->string('path')->nullable(); // Ruta completa del archivo
            $table->boolean('is_active')->default(true); // Avatar activo

            $table->timestamps();

            $table->index(['user_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avatars');
    }
};
