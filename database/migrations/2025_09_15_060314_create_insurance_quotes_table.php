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
        Schema::create('insurance_quotes', function (Blueprint $table) {
            $table->id();

            // Core travel info
            $table->string('destination');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('number_of_travelers');
            $table->json('coverage_options');
            $table->decimal('price', 10, 2);
            $table->string('quote_reference')->unique()->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_quotes');
    }
};
