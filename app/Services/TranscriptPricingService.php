<?php

namespace App\Services;

use App\Models\TranscriptPricing;

class TranscriptPricingService
{
    // Payment method charges (percentage)
    const PAYMENT_CHARGES = [
        'paystack' => 1.5, // 1.5% for Paystack
        'remita' => 1.0,   // 1.0% for Remita
    ];

    /**
     * Calculate total amount for transcript application
     *
     * @param array $data
     * @return array
     */
    public function calculateTotal(array $data): array
    {
        $breakdown = [];
        $subtotal = 0;

        // Map new form fields to pricing parameters
        $applicationType = $data['category'] ?? $data['application_type'] ?? null; // undergraduate/postgraduate
        $requestType = $data['request_type'] ?? $data['category'] ?? null; // self/institutional
        $deliveryOption = $data['delivery_option'] ?? null; // self_physical, self_ecopy, institutional_physical, institutional_ecopy
        
        // Determine delivery type from delivery option
        $deliveryType = null;
        $destination = null;
        
        if ($deliveryOption) {
            if (str_contains($deliveryOption, 'physical')) {
                $deliveryType = 'physical';
            } elseif (str_contains($deliveryOption, 'ecopy')) {
                $deliveryType = 'ecopy';
            }
            
            // Determine destination for courier pricing
            if ($deliveryOption === 'institutional_physical') {
                $institutionalLocation = $data['institutional_location'] ?? null;
                if ($institutionalLocation === 'local_institutional') {
                    $destination = 'local';
                } elseif ($institutionalLocation === 'international_institutional') {
                    $destination = 'international';
                }
            }
        } else {
            // Fallback to old field names for backward compatibility
            $deliveryType = $data['type'] ?? null;
            $destination = $data['destination'] ?? null;
        }

        // Get transcript pricing based on application type and delivery method
        if ($applicationType && $deliveryType) {
            $transcriptPrice = $this->getTranscriptPrice($applicationType, $requestType, $deliveryType);
            $breakdown['transcript_price'] = $transcriptPrice;
            $subtotal += $transcriptPrice;
        }

        // Add courier costs if applicable (institutional physical delivery)
        if ($requestType === 'institutional' && $deliveryType === 'physical' && 
            isset($destination) && isset($data['courier'])) {
            $courierPrice = $this->getCourierPrice($data['courier'], $destination);
            $breakdown['courier_price'] = $courierPrice;
            $subtotal += $courierPrice;
        }

        // Additional charges (processing fees, etc.)
        $additionalCharges = $this->calculateAdditionalCharges($data);
        $breakdown['additional_charges'] = $additionalCharges;
        $subtotal += array_sum($additionalCharges);

        $breakdown['subtotal'] = max(0, $subtotal);

        // Calculate payment charges if payment method is specified
        $paymentCharges = 0;
        if (isset($data['payment_method']) && array_key_exists($data['payment_method'], self::PAYMENT_CHARGES)) {
            $chargePercentage = self::PAYMENT_CHARGES[$data['payment_method']];
            $paymentCharges = ($subtotal * $chargePercentage) / 100;
            $breakdown['payment_charges'] = $paymentCharges;
            $breakdown['payment_method'] = $data['payment_method'];
            $breakdown['charge_percentage'] = $chargePercentage;
        }

        $breakdown['total'] = max(0, $subtotal + $paymentCharges);

        return $breakdown;
    }

    /**
     * Get transcript price from database
     *
     * @param string $applicationType
     * @param string $category
     * @param string $deliveryType
     * @return float
     */
    protected function getTranscriptPrice(string $applicationType, string $category, string $deliveryType): float
    {
        $pricing = TranscriptPricing::active()
            ->where('pricing_type', 'transcript')
            ->where('application_type', $applicationType)
            ->where('delivery_type', $deliveryType)
            ->first();

        return $pricing ? $pricing->price : 0;
    }

    /**
     * Get courier price from database
     *
     * @param string $courierName
     * @param string $destination
     * @return float
     */
    protected function getCourierPrice(string $courierName, string $destination): float
    {
        $pricing = TranscriptPricing::active()
            ->where('pricing_type', 'courier')
            ->where('courier_name', $courierName)
            ->where('destination', $destination)
            ->first();

        return $pricing ? $pricing->price : 0;
    }

    /**
     * Calculate additional charges (simplified - can be extended later)
     *
     * @param array $data
     * @return array
     */
    protected function calculateAdditionalCharges(array $data): array
    {
        $charges = [];

        // For now, we'll keep this simple
        // Additional charges can be added to the database later if needed
        
        return $charges;
    }

    /**
     * Get pricing structure for frontend from database
     *
     * @return array
     */
    public function getPricingStructure(): array
    {
        $transcriptPrices = TranscriptPricing::getTranscriptPrices();
        $courierPrices = TranscriptPricing::getCourierPrices();

        return [
            'transcript' => $transcriptPrices,
            'courier' => $courierPrices
        ];
    }

    /**
     * Get formatted pricing breakdown
     *
     * @param array $data
     * @return array
     */
    public function getFormattedBreakdown(array $data): array
    {
        $breakdown = $this->calculateTotal($data);
        
        $formatted = [
            'transcript_price' => number_format($breakdown['transcript_price'], 2),
            'courier_price' => number_format($breakdown['courier_price'] ?? 0, 2),
            'additional_charges' => array_map(function($charge) {
                return number_format($charge, 2);
            }, $breakdown['additional_charges']),
            'subtotal' => number_format($breakdown['subtotal'], 2),
            'total' => number_format($breakdown['total'], 2),
            'total_raw' => $breakdown['total'],
            'subtotal_raw' => $breakdown['subtotal']
        ];

        // Add payment charges if present
        if (isset($breakdown['payment_charges'])) {
            $formatted['payment_charges'] = number_format($breakdown['payment_charges'], 2);
            $formatted['payment_charges_raw'] = $breakdown['payment_charges'];
            $formatted['payment_method'] = $breakdown['payment_method'];
            $formatted['charge_percentage'] = $breakdown['charge_percentage'];
        }

        return $formatted;
    }

    /**
     * Get available payment methods with their charges
     *
     * @return array
     */
    public function getPaymentMethods(): array
    {
        return [
            'paystack' => [
                'name' => 'Paystack',
                'charge_percentage' => self::PAYMENT_CHARGES['paystack'],
                'description' => 'Pay with Paystack (Cards, Bank Transfer, USSD)'
            ],
            'remita' => [
                'name' => 'Remita',
                'charge_percentage' => self::PAYMENT_CHARGES['remita'],
                'description' => 'Pay with Remita (Bank Transfer, Cards)'
            ]
        ];
    }
}