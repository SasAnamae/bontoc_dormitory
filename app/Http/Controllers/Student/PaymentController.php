<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::where('user_id', auth()->id())
            ->latest('paid_at')
            ->paginate(20);

        return view('student.payments.index', compact('payments'));
    }

    public function create()
    {
        return view('student.payments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'months' => 'required|array|max:255',
            'amount' => 'required|numeric|min:0',
            'dorm_fee' => 'required|numeric|min:0',
            'appliances' => 'nullable|string|max:1000',
            'appliance_fee' => 'nullable|numeric|min:0',
            'or_number' => 'nullable|string|max:255',
            'paid_at' => 'required|date',
            'receipt_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $paymentMonth = implode(',',$request->months);

        $photoBase64 = null;

        if ($request->hasFile('receipt_photo')) {
            $file = $request->file('receipt_photo');

            // Read file contents for base64 BEFORE moving
            $base64Content = base64_encode(file_get_contents($file));
            $photoBase64 = 'data:' . $file->getMimeType() . ';base64,' . $base64Content;

            // Now move the file
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('receipt_images');
            $file->move($destinationPath, $filename);
        }


        $payment = Payment::create([
            'user_id' => Auth::id(),
            'payment_month' => $paymentMonth,
            'amount' => $request->amount,
            'dorm_fee' => $request->dorm_fee,
            'appliances' => $request->appliances,
            'appliance_fee' => $request->appliance_fee,
            'status' => 'pending',
            'or_number' => $request->or_number,
            'paid_at' => $request->paid_at,
            'receipt_photo' => $photoBase64,
        ]);
            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\PaymentSubmittedNotification($payment));
            }
        return redirect()->route('student.payments.index')->with('success', 'Payment submitted successfully!');
    }

    public function download(Request $request)
    {
        $user = auth()->user();

        $payments = Payment::with(['cashier'])
            ->where('user_id', $user->id)
            ->latest('paid_at')
            ->get();

        $filename = $request->input('filename', 'my_payments');

        return Excel::download(new PaymentsExport($payments), $filename . '.xlsx');
    }
}

