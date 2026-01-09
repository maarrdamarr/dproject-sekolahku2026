<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Teacher;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        return view('administration.reports.index', $this->buildReportData($request));
    }

    public function exportPdf(Request $request)
    {
        $payload = $this->buildReportData($request);
        $html = view('reports.pdf.administration', $payload)->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'laporan-administrasi-' . now()->format('Ymd-His') . '.pdf';

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function buildReportData(Request $request): array
    {
        $type = $request->get('type', 'students');
        $from = $request->get('from');
        $to = $request->get('to');

        $data = collect();
        $summary = [];

        if ($type === 'teachers') {
            $data = Teacher::with('user')->orderBy('id')->get();
        } elseif ($type === 'payments') {
            $query = Payment::with('student.user')->orderBy('payment_date', 'desc');

            if ($from) {
                $query->whereDate('payment_date', '>=', $from);
            }

            if ($to) {
                $query->whereDate('payment_date', '<=', $to);
            }

            $data = $query->get();
            $summary['total'] = $data->sum('amount');
        } elseif ($type === 'schedules') {
            $data = Schedule::with(['classRoom', 'subject', 'teacher.user'])
                ->orderBy('day')
                ->orderBy('start_time')
                ->get();
        } else {
            $type = 'students';
            $data = Student::with(['user', 'classRoom'])->orderBy('id')->get();
        }

        $summary['count'] = $data->count();

        return [
            'type' => $type,
            'from' => $from,
            'to' => $to,
            'data' => $data,
            'summary' => $summary,
        ];
    }
}
