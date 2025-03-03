<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Department;
use App\Enums\RequisitionStatus;
use App\Enums\RequisitionUrgency;

return new class extends Migration
{
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->json('handles')->nullable()->comment('JSON array of statuses the department can handle');
        });
        
       
        Department::where('name', 'Procurement')->update([
            'handles' => json_encode([RequisitionStatus::PROCUREMENT->value])
        ]);
        
        Department::where('name', 'Finance')->update([
            'handles' => json_encode([RequisitionStatus::FINANCE->value])
        ]);

        Department::where('name', 'Administration')->update([
            'handles' => json_encode([RequisitionStatus::ADMINISTRATION->value])
        ]);
    }
    
    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('handles');
        });
    }
};
