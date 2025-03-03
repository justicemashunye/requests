<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {       


            

            Schema::create('departments', function (Blueprint $table) {

            $table->id(); 
            $table->string('name'); 
            $table->unsignedBigInteger('program_id'); 
            $table->timestamps(); 

          
            $table->foreign('program_id')
                  ->references('id')
                  ->on('programs');
                
                });

    }

    
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
