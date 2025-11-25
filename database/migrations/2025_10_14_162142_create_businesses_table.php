<?php
// database/migrations/2025_10_14_000000_create_businesses_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('shop_name');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('location');
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('businesses');
    }
};
