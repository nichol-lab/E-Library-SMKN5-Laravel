<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fines', function (Blueprint $table) {
            $table->id();

            $table->foreignId('loan_detail_id')
                ->unique()
                ->constrained('loan_details')
                ->cascadeOnDelete();

            $table->unsignedInteger('late_days')->default(0);
            $table->decimal('amount', 12, 2)->default(0);

            $table->enum('status', [
                'unpaid',
                'paid'
            ])->default('unpaid');

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fines');
    }
};