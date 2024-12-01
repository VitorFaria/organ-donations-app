<?php

namespace Database\Seeders;

use App\Models\Organ;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

class OrganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organList = [
            [
                'name' => 'células-tronco',
                'organ_type' => 'nervoso',
            ],
            [
                'name' => 'Fígado',
                'organ_type' => 'digestivo',
            ],
            [
                'name' => 'Pulmões',
                'organ_type' => 'respiratório'
            ],
            [
                'name' => 'Coração',
                'organ_type' => 'circulatório'
            ],
            [
                'name' => 'Rins',
                'organ_type' => 'urinário'
            ],
            [
                'name' => 'óvulos',
                'organ_type' => 'reprodutor'
            ],
            [
                'name' => 'Pãncreas',
                'organ_type' => 'endócrino'
            ],
            [
                'name' => 'Cabelos',
                'organ_type' => 'tegumentar'
            ],
            [
                'name' => 'Ossos',
                'organ_type' => 'locomotor'
            ],
            [
                'name' => 'Tímpano',
                'organ_type' => 'sensorial'
            ],
        ];

        foreach($organList as $organ)
        {
            $organArr[] = [
                'id' => Uuid::uuid4(),
                'name' => $organ['name'],
                'organ_type' => $organ['organ_type'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        Schema::disableForeignKeyConstraints();
        Organ::truncate();
        Schema::enableForeignKeyConstraints();
        Organ::insert($organArr);
    }
}
