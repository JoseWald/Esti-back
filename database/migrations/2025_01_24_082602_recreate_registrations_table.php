<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id(); 
            $table->string('photo_path'); 
            $table->string('year'); // L1 | L2 | L3 | M1 | M2 
            $table->string('department'); 
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date');
            $table->string('birth_place');
            $table->string('address');
            $table->string('nationality');
            $table->string('phone');
            $table->string('email');
            $table->string('father_name');
            $table->string('father_job');
            $table->string('mother_name');
            $table->string('mother_job');
            $table->string('parent_contact');
            $table->string('invoice_path'); 
            $table->string('grade_sheet_path');
            $table->boolean('state');//true = approved and can send his inscription
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
