<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class CarrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $time = now();
        DB::table('carriers')->insert([
            [
                'name' => 'Transcompany',
                'slug' => 'transcompany',
                'calculator' => 'App\Application\CarrierService\ShippingCostCalculators\TranscompanyCalculator',
                'created_at' => $time,
                'updated_at' => $time
            ],
            [
                'name' => 'PackGroup',
                'slug' => 'packgroup',
                'calculator' => 'App\Application\CarrierService\ShippingCostCalculators\PackGroupCalculator',
                'created_at' => $time,
                'updated_at' => $time
            ],            
        ]);
    }
}
