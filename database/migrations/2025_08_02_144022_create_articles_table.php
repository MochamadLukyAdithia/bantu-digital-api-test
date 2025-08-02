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
         Schema::create('articles', function (Blueprint $table) {
        $table->id(); // ID (auto increment)
        $table->string('title'); // Judul
        $table->text('content'); // Isi konten
        $table->string('author'); // Penulis
        $table->timestamps(); // created_at dan updated_at
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
