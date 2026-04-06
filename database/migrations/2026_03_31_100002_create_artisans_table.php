<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artisans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('workingArea')->nullable();
            $table->string('service')->nullable();
            $table->json('disponibility')->nullable();
            $table->integer('experience')->default(0);
            $table->json('certifications')->nullable();
            $table->string('workshopAdresse')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->enum('access_type', ['contact_only', 'full_service'])->default('full_service');
            $table->float('noteMoyenne')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artisans');
    }
};
