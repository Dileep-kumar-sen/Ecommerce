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
        Schema::create('business_membership_plan', function (Blueprint $table) {
            $table->id();
            $table->string('plan_tier'); // free, basic, standard, featured, premium
            $table->integer('trial_days')->nullable();
            $table->integer('discount')->default(0);
            $table->integer('active_offers')->default(0);
            $table->decimal('plan_price', 10, 2)->default(0);
            $table->integer('duration_months')->default(1);
            $table->enum('visibility_level', ['low', 'medium', 'high', 'top'])->default('low');
            $table->enum('metrics_access', ['none', 'basic', 'advanced'])->default('none');
            $table->boolean('highlight_banner')->default(false);
            $table->boolean('push_notifications')->default(false);
            $table->text('marketing_campaigns')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_membership_plan');
    }
};
