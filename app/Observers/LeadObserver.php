<?php

namespace App\Observers;

use App\Models\Lead;
use App\Models\Commission;

class LeadObserver
{
    /**
     * Handle the Lead "updated" event.
     */
    public function updated(Lead $lead): void
    {
        // When lead is approved, calculate and create commission
        if ($lead->isDirty('status') && $lead->status === 'approved' && $lead->affiliate_id) {
            $product = $lead->product;
            $amount = 0;

            if ($product->commission_type === 'fixed') {
                $amount = $product->commission_value;
            } elseif ($product->commission_type === 'percent') {
                $amount = ($lead->order_value * $product->commission_value) / 100;
            }

            Commission::updateOrCreate(
                ['lead_id' => $lead->id],
                [
                    'affiliate_id' => $lead->affiliate_id,
                    'product_id' => $lead->product_id,
                    'amount' => $amount,
                    'status' => 'pending',
                ]
            );
        }
    }
}
