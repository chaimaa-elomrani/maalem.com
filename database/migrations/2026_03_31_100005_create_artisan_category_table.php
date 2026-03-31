<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artisan_category', function (Blueprint $table) {
            $table->foreignId('artisan_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->primary(['artisan_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artisan_category');
    }
};
