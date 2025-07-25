<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaymentsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $payments;

    public function __construct($payments)
    {
        $this->payments = $payments;
    }

    public function collection()
    {
        return $this->payments->map(function ($payment) {
            $schedule = $payment->schedule;
            $user = $payment->user;

            $pivot = $schedule->students->firstWhere('id', $user->id)?->pivot;

            $baseRate = $schedule->rate ?? 0;
            $additionalFee = $pivot?->additional_fee ?? 0;
            $totalDue = $pivot?->total_due ?? ($baseRate + $additionalFee);

            return [
                'Payment ID'      => $payment->id,
                'Student Name'    => $user->name ?? 'N/A',
                'Course & Year'   => $user->occupantProfile?->course_section ?? 'N/A',
                'Room'            => $user->reservations->first()?->room?->name ?? 'N/A',
                'Schedule Name'   => $schedule->name ?? 'N/A',
                'Base Rate (₱)'   => number_format($baseRate, 2),
                'Additional Fee (₱)' => number_format($additionalFee, 2),
                'Total Due (₱)'   => number_format($totalDue, 2),
                'Amount Paid (₱)' => number_format($payment->amount ?? 0, 2),
                'Status'          => ucfirst($payment->status ?? 'Unpaid'),
                'OR Number'       => $payment->or_number ?? '—',
                'Paid At'         => $payment->paid_at ? $payment->paid_at->format('M d, Y H:i') : 'Not Yet Paid',
                'Cashier Name'    => $payment->cashier->name ?? 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Payment ID',
            'Student Name',
            'Course & Year',
            'Room',
            'Schedule Name',
            'Base Rate (₱)',
            'Additional Fee (₱)',
            'Total Due (₱)',
            'Amount Paid (₱)',
            'Status',
            'OR Number',
            'Paid At',
            'Cashier Name',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [ // Header row styling
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2E86C1'],
                ],
            ],
        ];
    }
}

