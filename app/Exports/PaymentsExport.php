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
            $user = $payment->user;

            return [
                'Payment ID'     => $payment->id,
                'Student Name'   => $user->name ?? 'N/A',
                'Course & Year'  => $user->occupantProfile?->course ?? 'N/A' . ' ' . $user->occupantProfile?->year_section ?? 'N/A',
                'Room'           => $user->reservations->first()?->room?->name ?? 'N/A',
                'Amount (₱)'     => number_format($payment->amount, 2),
                'OR Number'      => $payment->or_number ?? '—',
                'Paid Date'      => $payment->paid_at ? $payment->paid_at->format('M d, Y') : 'Not Yet Paid',
                'Remarks'        => $payment->remarks ?? '—',
                'Cashier'        => $payment->cashier->name ?? 'System',
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
            'Amount (₱)',
            'OR Number',
            'Paid Date',
            'Remarks',
            'Cashier',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
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

