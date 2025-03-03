<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        \DB::table('requisitions')
            ->where('status', 'close')
            ->update(['status' => 'fulfilled']);
    }
    
    public function down(): void
    {
        //
    }
};
