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
        Schema::create('masjids', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('address');
        $table->integer('capacity')->nullable();
        $table->string('imam')->nullable();
        $table->string('khatib')->nullable();
        $table->text('prayer_times')->nullable(); // Simpan jadwal sebagai JSON
        $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masjids');
    }
};