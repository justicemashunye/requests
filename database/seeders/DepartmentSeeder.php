<?php

namespace Database\Seeders;
use App\Models\Department;
use App\Enums\RequisitionStatus;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
  
    public function run(): void
    {
        Department::updateOrCreate(
            ['name' => 'Procurement'],
            ['handles' => json_encode([RequisitionStatus::PROCUREMENT->value])]
        );
        
        Department::updateOrCreate(
            ['name' => 'Finance'],
            ['handles' => json_encode([RequisitionStatus::FINANCE->value])]
        );
        Department::updateOrCreate(
            ['name' => 'Administration'],
            ['handles' => json_encode([RequisitionStatus::ADMINISTRATION->value])]
        );
    }
}
