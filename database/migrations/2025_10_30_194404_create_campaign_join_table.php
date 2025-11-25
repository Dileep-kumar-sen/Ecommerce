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
        Schema::create('campaign_join', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('campaign_id');

            // Empty (nullable) count_offer
            $table->integer('count_offer')->nullable();

            // Foreign key constraints
            $table->foreign('business_id')
                  ->references('id')->on('businesses')
                  ->onDelete('cascade');

            $table->foreign('campaign_id')
                  ->references('id')->on('campaigns')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_join');
    }
};
