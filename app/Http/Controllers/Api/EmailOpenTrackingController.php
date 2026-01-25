<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmailLog;
use Illuminate\Http\Response;

class EmailOpenTrackingController extends Controller
{
    /**
     * Transparent 1x1 GIF (43 bytes).
     */
    private const TRACKING_PIXEL_GIF = "\x47\x49\x46\x38\x39\x61\x01\x00\x01\x00\x90\x01\x00\xff\xff\xff\x00\x00\x00\x21\xf9\x04\x01\x00\x00\x01\x00\x2c\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02\x4c\x01\x00\x3b";

    /**
     * Track email open via 1x1 pixel; set opened_at if null. Return transparent GIF.
     */
    public function track(EmailLog $emailLog): Response
    {
        if ($emailLog->opened_at === null) {
            $emailLog->update(['opened_at' => now()]);
        }

        return response(self::TRACKING_PIXEL_GIF, Response::HTTP_OK, [
            'Content-Type' => 'image/gif',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
