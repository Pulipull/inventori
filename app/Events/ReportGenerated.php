<?php

namespace App\Events;

use App\Models\ReportExport;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportGenerated implements ShouldDispatchAfterCommit
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public ReportExport $export)
    {
        $this->export->loadMissing('user');
    }
}
