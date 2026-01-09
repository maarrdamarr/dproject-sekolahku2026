<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Content;
use App\Models\Gallery;
use App\Models\Letter;
use App\Models\News;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Setting;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class AllReportController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.reports.index', $this->buildReportData($request));
    }

    public function exportPdf(Request $request)
    {
        $payload = $this->buildReportData($request);
        $html = view('reports.pdf.admin', $payload)->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'laporan-admin-' . now()->format('Ymd-His') . '.pdf';

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function buildReportData(Request $request): array
    {
        $type = $request->get('type', 'users');
        $from = $request->get('from');
        $to = $request->get('to');

        $data = collect();
        $summary = [];

        if ($type === 'students') {
            $data = Student::with(['user', 'classRoom'])->orderBy('id')->get();
        } elseif ($type === 'teachers') {
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
        } elseif ($type === 'news') {
            $data = News::latest()->get();
        } elseif ($type === 'announcements') {
            $data = Announcement::latest()->get();
        } elseif ($type === 'galleries') {
            $data = Gallery::latest()->get();
        } elseif ($type === 'letters') {
            $data = Letter::latest()->get();
        } elseif ($type === 'contents') {
            $data = Content::latest()->get();
        } elseif ($type === 'settings') {
            $data = Setting::orderBy('key')->get();
        } else {
            $type = 'users';
            $data = User::orderBy('id')->get();
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
