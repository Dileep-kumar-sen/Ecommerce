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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('campaign_name');
        $table->date('start_date');
        $table->date('end_date');
        $table->json('categories')->nullable();
        $table->json('subcategories')->nullable();
        $table->decimal('join_fee', 10, 2)->nullable();
        $table->string('discount_rules')->nullable();
        $table->string('benefit')->nullable();
        $table->string('banner')->nullable();
        $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
