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
        Schema::create('pharamcyies', function (Blueprint $table) {
            $table->id();
            $table->string("pharamcy_name");
            $table->string("pharamcy_address");
            $table->string("pharamcy_image");
            $table->integer("pharmacy_phone");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharamcyies');
    }
};
