<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class ZoomService
{
    public function createMeeting(array $data): array
    {
        $payload = [
            'topic' => $data['topic'] ?? 'Telemedicine Appointment',
            'type' => 2,
            'start_time' => $data['start_time'] ?? now()->addHour()->toIso8601String(),
            'duration' => $data['duration'] ?? 30,
            'timezone' => $data['timezone'] ?? config('app.timezone', 'UTC'),
            'agenda' => $data['agenda'] ?? null,
            'settings' => [
                'join_before_host' => false,
                'waiting_room' => true,
            ],
        ];

        $response = Http::withToken($this->getAccessToken())
            ->post('https://api.zoom.us/v2/users/me/meetings', $payload);

        if (! $response->successful()) {
            throw new RuntimeException('Zoom meeting creation failed: ' . $response->body());
        }

        $meeting = $response->json();

        return [
            'join_url' => $meeting['join_url'] ?? null,
            'start_url' => $meeting['start_url'] ?? null,
            'meeting_id' => isset($meeting['id']) ? (string) $meeting['id'] : null,
        ];
    }

    private function getAccessToken(): string
    {
        $cached = Cache::get('zoom_s2s_token');
        if (is_array($cached) && ! empty($cached['token']) && now()->lt($cached['expires_at'])) {
            return $cached['token'];
        }

        $accountId = (string) config('services.zoom.account_id');
        $clientId = (string) config('services.zoom.client_id');
        $clientSecret = (string) config('services.zoom.client_secret');

        if ($accountId === '' || $clientId === '' || $clientSecret === '') {
            throw new RuntimeException('Zoom credentials are missing in services configuration.');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($clientId . ':' . $clientSecret),
        ])->asForm()->post('https://zoom.us/oauth/token', [
            'grant_type' => 'account_credentials',
            'account_id' => $accountId,
        ]);

        if (! $response->successful()) {
            throw new RuntimeException('Zoom token request failed: ' . $response->body());
        }

        $token = (string) $response->json('access_token');
        $expiresIn = (int) $response->json('expires_in', 3600);

        if ($token === '') {
            throw new RuntimeException('Zoom token response did not include an access_token.');
        }

        $ttl = max(60, $expiresIn - 120);
        Cache::put('zoom_s2s_token', [
            'token' => $token,
            'expires_at' => now()->addSeconds($ttl),
        ], $ttl);

        return $token;
    }
}
