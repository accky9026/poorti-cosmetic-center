<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send the order's invoice to the customer's WhatsApp number.
     * Returns true on success, false if it could not be sent
     * (missing phone number, missing credentials, or API error).
     */
    public static function sendInvoice(Order $order): bool
    {
        $phone = $order->user->phone;

        if (! $phone) {
            Log::warning("WhatsApp invoice skipped for order #{$order->id}: customer has no phone number on file.");

            return false;
        }

        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.whatsapp_from');

        if (! $sid || ! $token || ! $from) {
            Log::warning("WhatsApp invoice skipped for order #{$order->id}: Twilio credentials are not set in .env.");

            return false;
        }

        try {
            $response = Http::withBasicAuth($sid, $token)
                ->asForm()
                ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                    'From' => $from,
                    'To' => 'whatsapp:'.self::normalizePhone($phone),
                    'Body' => self::buildMessage($order),
                ]);

            if ($response->successful()) {
                $order->update(['whatsapp_sent_at' => now()]);

                return true;
            }

            Log::error("WhatsApp send failed for order #{$order->id}: ".$response->body());

            return false;
        } catch (\Throwable $e) {
            Log::error("WhatsApp send exception for order #{$order->id}: ".$e->getMessage());

            return false;
        }
    }

    /**
     * Turn a plain Indian mobile number into E.164 format (+91XXXXXXXXXX).
     * Numbers that already include a country code are left as-is.
     */
    private static function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone);

        if (strlen($digits) === 10) {
            $digits = '91'.$digits;
        }

        return '+'.$digits;
    }

    private static function buildMessage(Order $order): string
    {
        $lines = [];
        $lines[] = '*Poorti Cosmetic Center*';
        $lines[] = 'Your order #'.str_pad((string) $order->id, 5, '0', STR_PAD_LEFT).' has been delivered! ✅';
        $lines[] = '';

        foreach ($order->items as $item) {
            $lines[] = "- {$item->product_name} x{$item->quantity} = ₹".number_format($item->subtotal, 2);
        }

        $lines[] = '';
        $lines[] = '*Total: ₹'.number_format($order->total_amount, 2).'*';
        $lines[] = '';
        $lines[] = 'Thank you for shopping with us!';
        $lines[] = 'Full invoice: '.route('orders.show', $order);

        return implode("\n", $lines);
    }
}
