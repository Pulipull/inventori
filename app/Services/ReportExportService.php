<?php

namespace App\Services;

use App\Models\ReportExport;
use App\Models\User;

class ReportExportService
{
    public function create(User $user, string $reportType, array $filters = []): ReportExport
    {
        return ReportExport::create([
            'user_id' => $user->id,
            'report_type' => $reportType,
            'filters' => $filters === [] ? null : $filters,
            'status' => ReportExport::STATUS_PENDING,
        ]);
    }

    public function markProcessing(ReportExport $export): ReportExport
    {
        $export->update(['status' => ReportExport::STATUS_PROCESSING]);

        return $export;
    }

    public function markCompleted(ReportExport $export, string $filePath): ReportExport
    {
        $export->update([
            'status' => ReportExport::STATUS_COMPLETED,
            'file_path' => $filePath,
            'generated_at' => now(),
        ]);

        return $export;
    }

    public function markFailed(ReportExport $export): ReportExport
    {
        $export->update(['status' => ReportExport::STATUS_FAILED]);

        return $export;
    }

    public function history(User $user)
    {
        return ReportExport::with('user')
            ->when(! $user->isAdmin(), fn ($query) => $query->where('user_id', $user->id))
            ->latest()
            ->paginate(15);
    }
}
