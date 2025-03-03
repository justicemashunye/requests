<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->string('typeOfProduct');
            $table->string('nameOfProduct');          
            $table->text('description');
            $table->integer('quantity');
            $table->text('purpose');
            $table->decimal('estimatedCost', 10, 2)->nullable(); // Cost field
            $table->string('status')->default('pending'); // Enum-like status
            $table->string('urgency')->default('urgent'); // Enum-like status
            $table->timestamps();
        });

        
    }

    public function down(): void
    {
        Schema::dropIfExists('requisitions');
    }

    
};
