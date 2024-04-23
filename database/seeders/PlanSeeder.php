<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'stripe_plan' => 'price_1P8freSErWPImwflEB2GyJMS',
                'price' => 1,
                'description' => 'This is a basic plan for customer'
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'stripe_plan' => 'price_1P8GlSSErWPImwflHrS93Bo7',
                'price' => 100,
                'description' => 'This is a premium plan for customer'
            ],
            [
                'name' => 'Bussiness Plan',
                'slug' => 'bussiness plan',
                'stripe_plan' => 'price_1P8fuHSErWPImwflv9cqIMNz',
                'price' => 500,
                'description' => 'This is a bussiness plan for customer'
            ]
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
