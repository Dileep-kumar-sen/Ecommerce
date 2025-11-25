<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_tier')->default('Free'); // Free, Basic, Premium, Diamond etc.
            $table->integer('trial_period_days')->default(0);
            $table->integer('coupons_per_week')->default(0);
            $table->string('plan_icon')->nullable(); // Store plan icon image path
            $table->string('month_year')->nullable(); // Store plan icon image path

            $table->string('discount_limit')->default('0'); // e.g., 10%, 30%, Unlimited
            $table->integer('exclusive_offers_monthly')->default(0);
            $table->text('features')->nullable(); // JSON or comma-separated list
            $table->text('achievements')->nullable(); // e.g., Streaks, Missions, Levels
            $table->text('referral_bonus')->nullable(); // referral info
            $table->decimal('plan_price', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_plans');
    }
};
