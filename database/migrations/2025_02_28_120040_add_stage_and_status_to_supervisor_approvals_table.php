<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::table('supervisor_approvals', function (Blueprint $table) {
            // Add stage column
            $table->string('stage')
                  ->after('department_id') // Optional: specify position
                  ->comment('Workflow stage when approval/rejection occurred');
            
            // Add status column (only if it doesn't exist)
            if (!Schema::hasColumn('supervisor_approvals', 'status')) {
                $table->string('status')
                      ->after('stage')
                      ->comment('Approval status: approved/rejected');
            }
        });
    }
    
    public function down()
    {
        Schema::table('supervisor_approvals', function (Blueprint $table) {
            $table->dropColumn(['stage', 'status']);
        });
    }
};
