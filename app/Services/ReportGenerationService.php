<?php

namespace App\Services;

use App\Events\ReportGenerated;
use App\Events\ReportGenerationFailed;
use App\Events\ReportRequested;
use App\Models\ReportExport;
use App\Models\User;
use Illuminate\Support\Arr;
use Throwable;

class ReportGenerationService
{
    public function __construct(private readonly ReportExportService $exports)
    {
    }

    public function request(User $user, string $reportType, array $filters = []): ReportExport
    {
        $export = $this->exports->create($user, $reportType, $this->cleanFilters($filters));

        ReportRequested::dispatch($export);

        try {
            $this->exports->markProcessing($export);

            $filePath = $this->fileReference($export);
            $this->exports->markCompleted($export, $filePath);

            ReportGenerated::dispatch($export->fresh('user'));
        } catch (Throwable $exception) {
            $this->exports->markFailed($export);

            ReportGenerationFailed::dispatch($export->fresh('user'));
        }

        return $export->fresh('user');
    }

    public function metadata(ReportExport $export): array
    {
        return [
            'report_type' => $export->report_type,
            'filters' => $export->filters ?? [],
            'status' => $export->status,
            'file_path' => $export->file_path,
            'generated_at' => $export->generated_at,
        ];
    }

    private function cleanFilters(array $filters): array
    {
        return array_filter(Arr::only($filters, ['type', 'date_from', 'date_to']), fn ($value) => filled($value));
    }

    private function fileReference(ReportExport $export): string
    {
        return match ($export->report_type) {
            'stock' => route('reports.stock.pdf'),
            'transactions_in' => route('reports.transactions.pdf', ['type' => 'in'] + ($export->filters ?? [])),
            'transactions_out' => route('reports.transactions.pdf', ['type' => 'out'] + ($export->filters ?? [])),
            default => route('reports.exports.show', $export),
        };
    }
}
