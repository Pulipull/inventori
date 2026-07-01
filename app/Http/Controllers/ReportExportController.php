<?php

namespace App\Http\Controllers;

use App\Models\ReportExport;
use App\Services\ReportExportService;
use App\Services\ReportGenerationService;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ReportExportController extends Controller
{
    public function index(Request $request, ReportExportService $exports): View
    {
        return view('reports.exports.index', [
            'exports' => $exports->history($request->user()),
        ]);
    }

    public function store(Request $request, ReportGenerationService $reports): RedirectResponse
    {
        $data = $this->validated($request);

        $export = $reports->request($request->user(), $data['report_type'], $data);

        return redirect()->route('reports.exports.show', $export)->with('success', 'Permintaan export laporan berhasil dibuat.');
    }

    public function show(Request $request, ReportExport $export, ReportGenerationService $reports): View
    {
        abort_unless($request->user()->isAdmin() || $export->user_id === $request->user()->id, 403);

        return view('reports.exports.show', [
            'export' => $export->load('user'),
            'metadata' => $reports->metadata($export),
        ]);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'report_type' => ['required', Rule::in(['stock', 'transactions_in', 'transactions_out', 'sales', 'payments', 'revenue'])],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date'],
        ]);

        if (
            isset($data['date_from'], $data['date_to'])
            && CarbonImmutable::parse($data['date_to'])->lt(CarbonImmutable::parse($data['date_from']))
        ) {
            throw ValidationException::withMessages([
                'date_to' => 'Tanggal akhir harus sama dengan atau setelah tanggal awal.',
            ]);
        }

        return $data;
    }
}
