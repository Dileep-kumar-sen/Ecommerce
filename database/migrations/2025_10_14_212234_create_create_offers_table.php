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
        Schema::create('create_offers', function (Blueprint $table) {
             $table->id();
            $table->unsignedBigInteger('business_id')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('expiry_datetime')->nullable();
            $table->integer('stock_limit')->default(0);
            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('subcategory_id')->nullable()->index();
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedTinyInteger('discount')->default(0); // percentage 0-100
             $table->decimal('discount_price', 12, 2)->default(0);
             $table->string('voucher_code')->unique();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(1); // 1=active,0=inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('create_offers');
    }
};
