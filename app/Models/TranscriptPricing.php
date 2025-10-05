<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranscriptPricing extends Model
{
    protected $table = 'transcript_pricing';
    
    protected $fillable = [
        'pricing_type',
        'application_type',
        'delivery_type',
        'courier_name',
        'destination',
        'price',
        'description',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // Scope for active pricing only
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Get transcript pricing
    public static function getTranscriptPrice($applicationType, $deliveryType)
    {
        return self::active()
            ->where('pricing_type', 'transcript')
            ->where('application_type', $applicationType)
            ->where('delivery_type', $deliveryType)
            ->value('price') ?? 0;
    }

    // Get courier pricing
    public static function getCourierPrice($courierName, $destination = null)
    {
        $query = self::active()
            ->where('pricing_type', 'courier')
            ->where('courier_name', $courierName);
            
        if ($destination) {
            $query->where('destination', $destination);
        }
        
        return $query->value('price') ?? 0;
    }

    // Get all transcript prices
    public static function getTranscriptPrices()
    {
        return self::active()
            ->where('pricing_type', 'transcript')
            ->get()
            ->groupBy(['application_type', 'delivery_type'])
            ->map(function ($deliveryTypes) {
                return $deliveryTypes->map(function ($items) {
                    return $items->first()->price;
                });
            });
    }

    // Get all courier prices
    public static function getCourierPrices()
    {
        return self::active()
            ->where('pricing_type', 'courier')
            ->get()
            ->groupBy(['courier_name', 'destination'])
            ->map(function ($destinations) {
                return $destinations->map(function ($items) {
                    return $items->first()->price;
                });
            });
    }
}
