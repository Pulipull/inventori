<?php

namespace App\Listeners;

use App\Events\ReportGenerated;
use App\Services\NotificationService;

class SendReportGeneratedNotification
{
    public function __construct(private readonly NotificationService $notifications)
    {
    }

    public function handle(ReportGenerated $event): void
    {
        $this->notifications->create(
            $event->export->user,
            'Export laporan selesai',
            'Export '.$event->export->report_type.' sudah siap dibuka.',
            'success',
            'report',
        );
    }
}
