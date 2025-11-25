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
        Schema::create('payments', function (Blueprint $table) {
                    $table->id();

            // 🔹 Reference to user
            $table->unsignedBigInteger('user_id')->nullable();

            // 🔹 Plan or product name
            $table->unsignedBigInteger('plan_id');
            $table->string('payment_type')->nullable();

            // 🔹 Amount paid
            $table->decimal('amount', 10, 2);

            // 🔹 Currency code (e.g. ARS, USD, INR)
            $table->string('currency', 10)->default('ARS');

            // 🔹 Mercado Pago transaction id
            $table->string('payment_id')->nullable();
            $table->string('expire_date')->nullable();
            $table->integer('membership_status')->nullable();

            // 🔹 Payment status
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');

            // 🔹 Payment method (card, UPI, wallet, etc.)
            $table->string('payment_method')->nullable();





            $table->timestamps();

            // foreign key (if you have users table)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('membership_plans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
