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
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('artisan_id')->constrained('artisans')->cascadeOnDelete();
            $table->foreignId('mediateur_id')->nullable()->constrained('mediateurs');
            $table->text('description');
            $table->enum('status', [
                'pending',
                'accepted_by_mediateur',
                'picked_up_client',
                'at_artisan',
                'in_progress',
                'ready_for_return',
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
