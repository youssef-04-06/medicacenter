<?php

namespace App\Services;

use App\Models\Appointment;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class WhatsAppService
{
    private const TELEMEDICINE_FEE = '$20';
    private const WHISH_NUMBER = '81754630';

    public function sendAppointmentLink(Appointment $appointment): bool
    {
        $to = $this->formatPhone($appointment->phone);
        if ($to === null) {
            return false;
        }

        $token = (string) config('services.whatsapp.token');
        $phoneNumberId = (string) config('services.whatsapp.phone_number_id');
        $apiVersion = (string) config('services.whatsapp.api_version');

        if ($token === '' || $phoneNumberId === '') {
            throw new RuntimeException('WhatsApp Cloud API credentials are missing in services configuration.');
        }

        $message = $this->buildMessage($appointment);

        $response = Http::withToken($token)
            ->post("https://graph.facebook.com/{$apiVersion}/{$phoneNumberId}/messages", [
                'messaging_product' => 'whatsapp',
                'to' => ltrim($to, '+'),
                'type' => 'text',
                'text' => ['body' => $message],
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('WhatsApp Cloud API request failed: ' . $response->body());
        }

        return true;
    }

    /**
     * Build a wa.me click-to-chat link so the admin can send the notification manually
     * (used when the WhatsApp Cloud API is not configured with real credentials).
     */
    public function buildWaMeLink(Appointment $appointment): ?string
    {
        $to = $this->formatPhone($appointment->phone);
        if ($to === null) {
            return null;
        }

        return 'https://wa.me/' . ltrim($to, '+') . '?text=' . rawurlencode($this->buildMessage($appointment));
    }

    private function buildMessage(Appointment $appointment): string
    {
        $doctorName = $appointment->doctor->name ?? 'your doctor';
        $date = $appointment->schedule->date ?? 'scheduled date';
        $time = $appointment->schedule->start_time ?? 'scheduled time';
        $joinUrl = $appointment->zoom_join_url ?: $appointment->zoom_meeting_link;
        $isTelemedicine = strtolower((string) $appointment->appointment_type) === 'telemedicine';

        $lines = [
            "Hello {$appointment->name}, your appointment is *confirmed*!",
            '',
            "Doctor: Dr. {$doctorName}",
            "Date: {$date}",
            "Time: {$time}",
        ];

        if ($isTelemedicine) {
            $lines[] = '';
            $lines[] = 'Payment: ' . self::TELEMEDICINE_FEE . ' received via Whish (' . self::WHISH_NUMBER . '). Thank you!';

            if ($joinUrl) {
                $lines[] = '';
                $lines[] = "Join Zoom: {$joinUrl}";
            }
        }

        return implode("\n", $lines);
    }

    private function formatPhone(?string $phone): ?string
    {
        $raw = trim((string) $phone);
        if ($raw === '') {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $raw);
        if ($digits === '') {
            return null;
        }

        return str_starts_with($raw, '+') ? '+' . $digits : '+' . $digits;
    }
}
