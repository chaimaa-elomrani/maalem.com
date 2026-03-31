<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('artisan_id')->constrained('artisans')->onDelete('cascade');
            $table->foreignId('mediateur_id')->nullable()->constrained('mediateurs')->onDelete('set null');
            $table->text('description');
            $table->enum('status', [
                'pending',
                'accepted_by_mediator',
                'in_progress_to_artisan',
                'at_artisan',
                'in_progress_to_client',
                'delivered',
                'rejected',
            ])->default('pending');
            $table->timestamp('deliveryDate')->nullable();
            $table->string('adresse');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_requests');
    }
};
