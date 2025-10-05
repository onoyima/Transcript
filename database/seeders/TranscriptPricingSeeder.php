<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TranscriptPricing;

class TranscriptPricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        TranscriptPricing::truncate();

        // Transcript pricing data
        $transcriptPricing = [
            // Undergraduate pricing
            [
                'pricing_type' => 'transcript',
                'application_type' => 'undergraduate',
                'delivery_type' => 'physical',
                'price' => 15000.00,
                'description' => 'Undergraduate transcript - Physical copy',
                'is_active' => true,
            ],
            [
                'pricing_type' => 'transcript',
                'application_type' => 'undergraduate',
                'delivery_type' => 'ecopy',
                'price' => 10000.00,
                'description' => 'Undergraduate transcript - Electronic copy',
                'is_active' => true,
            ],
            
            // Postgraduate pricing
            [
                'pricing_type' => 'transcript',
                'application_type' => 'postgraduate',
                'delivery_type' => 'physical',
                'price' => 20000.00,
                'description' => 'Postgraduate transcript - Physical copy',
                'is_active' => true,
            ],
            [
                'pricing_type' => 'transcript',
                'application_type' => 'postgraduate',
                'delivery_type' => 'ecopy',
                'price' => 15000.00,
                'description' => 'Postgraduate transcript - Electronic copy',
                'is_active' => true,
            ],
        ];

        // Courier pricing data
        $courierPricing = [
            // DHL pricing
            [
                'pricing_type' => 'courier',
                'courier_name' => 'dhl',
                'destination' => 'local',
                'price' => 5000.00,
                'description' => 'DHL local delivery',
                'is_active' => true,
            ],
            [
                'pricing_type' => 'courier',
                'courier_name' => 'dhl',
                'destination' => 'international',
                'price' => 25000.00,
                'description' => 'DHL international delivery',
                'is_active' => true,
            ],
            
            // ZCarex pricing
            [
                'pricing_type' => 'courier',
                'courier_name' => 'zcarex',
                'destination' => 'local',
                'price' => 3500.00,
                'description' => 'ZCarex local delivery',
                'is_active' => true,
            ],
            [
                'pricing_type' => 'courier',
                'courier_name' => 'zcarex',
                'destination' => 'international',
                'price' => 20000.00,
                'description' => 'ZCarex international delivery',
                'is_active' => true,
            ],
            
            // Couples pricing
            [
                'pricing_type' => 'courier',
                'courier_name' => 'couples',
                'destination' => 'local',
                'price' => 4000.00,
                'description' => 'Couples local delivery',
                'is_active' => true,
            ],
            [
                'pricing_type' => 'courier',
                'courier_name' => 'couples',
                'destination' => 'international',
                'price' => 22000.00,
                'description' => 'Couples international delivery',
                'is_active' => true,
            ],
        ];

        // Insert transcript pricing
        foreach ($transcriptPricing as $pricing) {
            TranscriptPricing::create($pricing);
        }

        // Insert courier pricing
        foreach ($courierPricing as $pricing) {
            TranscriptPricing::create($pricing);
        }

        $this->command->info('Transcript pricing data seeded successfully!');
    }
}
