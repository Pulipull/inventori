<?php

namespace App\Listeners;

use App\Events\ReportGenerationFailed;
use App\Services\NotificationService;

class SendReportGenerationFailedNotification
{
    public function __construct(private readonly NotificationService $notifications)
    {
    }

    public function handle(ReportGenerationFailed $event): void
    {
        $this->notifications->create(
            $event->export->user,
            'Export laporan gagal',
            'Export '.$event->export->report_type.' gagal diproses.',
            'danger',
            'report',
        );
    }
}
