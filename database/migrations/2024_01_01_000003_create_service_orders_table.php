<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('device_model'); // Modelo do celular
            $table->string('device_imei')->nullable();
            $table->text('problem_description'); // Descrição do problema
            $table->text('diagnostic')->nullable(); // Diagnóstico técnico
            $table->decimal('estimated_cost', 10, 2)->nullable();
            $table->decimal('final_cost', 10, 2)->nullable();
            $table->enum('status', ['pending', 'approved', 'in_progress', 'completed', 'cancelled'])
                ->default('pending');
            $table->date('deadline')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
