<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class TestCarrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $time = now();
        DB::table('carriers')->insert([
            [
                'name' => 'TestCarrier1',
                'slug' => 'testcarrier1',
                'calculator' => 'Tests\Feature\Infrastructure\Persist\Carrier\Helpers\CarrierCalculator',
                'created_at' => $time,
                'updated_at' => $time
            ],            
        ]);
    }
}
