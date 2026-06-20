<?php

namespace App\Services;

use Illuminate\Http\Request;

class WebhookSignatureService
{
    public const STATUS_VALID = 'valid';
    public const STATUS_INVALID = 'invalid';
    public const STATUS_NOT_CONFIGURED = 'not_configured';

    public function verify(Request $request): bool
    {
        return $this->status($request) !== self::STATUS_INVALID;
    }

    public function status(Request $request): string
    {
        $secret = config('services.integration.webhook_secret');

        if (! $secret) {
            return self::STATUS_NOT_CONFIGURED;
        }

        $signature = $request->header('X-Integration-Signature');

        if (! $signature) {
            return self::STATUS_INVALID;
        }

        $expected = hash_hmac('sha256', $request->getContent(), $secret);

        return hash_equals($expected, $signature)
            ? self::STATUS_VALID
            : self::STATUS_INVALID;
    }
}
