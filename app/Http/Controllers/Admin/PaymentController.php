<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\ApplyPaymentRequest;
use App\Interfaces\PaymentRepositoryInterface;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private PaymentRepositoryInterface $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Display a listing of the payments.
     */
    public function index()
    {
        $payments = $this->paymentRepository->getAllPayments();
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
    $users = User::where('role', 'student')->get();
        return view('admin.payments.create', compact('users'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(PaymentRequest $request)
    {
        try {
            $this->paymentRepository->createPayment($request->validated());

            return redirect()->route('admin.payments.index')->with('success', __('admin.payment_created_successfully'));
        } catch (\Exception $e) {
            Log::error('Error creating payment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the payment: ' . $e->getMessage());
        }
    }

    /**
     * Display the form to apply a new payment to an existing record.
     */
    public function apply(Payment $payment)
    {
        return view('admin.payments.apply', compact('payment'));
    }

    /**
     * Process the new payment amount and update the record.
     */
    public function processApply(ApplyPaymentRequest $request, Payment $payment)
    {
        // التحقق من أن المبلغ لا يتجاوز المبلغ المتبقي (مهم لضمان عدم تجاوز الحد الأقصى)
        if ($request->validated('new_amount') > $payment->remaining_amount) {
            return redirect()->route('admin.payments.apply', $payment->id)
                ->with('error', __('admin.amount_exceeds_remaining'));
        }

        try {
            // استخدام الدالة في الريبوستري التي تتولى كل العمليات (إضافة التفصيل وتحديث المبلغ)
            $this->paymentRepository->applyNewPayment($payment->id, [
                'new_amount' => $request->validated('new_amount'),
                'payment_date' => $request->validated('payment_date'),
            ]);

            return redirect()->route('admin.payments.index')->with('success', __('admin.payment_applied_successfully'));
        } catch (\Exception $e) {
            Log::error('Error applying payment: ' . $e->getMessage());
            return redirect()->route('admin.payments.apply', $payment->id)
                ->with('error', 'An error occurred while applying the payment: ' . $e->getMessage());
        }
    }

    public function history($id)
    {
        $payment = $this->paymentRepository->getPaymentHistoryById($id);
        
        return view('admin.payments.history', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $payment = $this->paymentRepository->getPaymentById($id);
        $students = User::all();
        return view('admin.payments.edit', compact('payment', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentRequest $request, $id)
    {
        try {
            $this->paymentRepository->updatePayment($id, $request->validated());

            return redirect()->route('admin.payments.index')->with('success', __('admin.payment_updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Error updating payment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the payment.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->paymentRepository->deletePayment($id);
        return redirect()->route('admin.payments.index')->with('success', __('admin.payment_deleted_successfully'));
    }

    /**
     * Search for users based on a query.
     */
    public function searchUsers(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'like', "%{$query}%")
                    ->select('id', 'name')
                    ->get();

        return response()->json($users);
    }
}
