<?php

namespace App\Repositories;

use App\Interfaces\PaymentRepositoryInterface;
use App\Models\Payment;
use App\Models\PaymentDetail;
use Illuminate\Database\Eloquent\Collection;

class PaymentRepository implements PaymentRepositoryInterface
{
    /**
     * Get all payments with the associated student relationship.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPayments(): Collection
    {
        return Payment::with('student')->get();
    }

    /**
     * Get a single payment by ID with the associated student relationship.
     *
     * @param int $id
     * @return \App\Models\Payment
     */
    public function getPaymentById($id): Payment
    {
        return Payment::with('student')->findOrFail($id);
    }

    /**
     * Get the total paid amount for a specific student.
     *
     * @param int $studentId
     * @return float
     */
    public function getStudentTotalPaidAmount($studentId): float
    {
        return Payment::where('student_id', $studentId)->sum('paid_amount');
    }

    /**
     * Delete a payment by ID.
     *
     * @param int $id
     * @return void
     */
    public function deletePayment($id): void
    {
        Payment::destroy($id);
    }

    /**
     * Create a new payment record.
     *
     * @param array $details
     * @return \App\Models\Payment
     */
    public function createPayment(array $details): Payment
{
    if (!isset($details['remaining_amount']) && isset($details['total_amount']) && isset($details['paid_amount'])) {
        $details['remaining_amount'] = $details['total_amount'] - $details['paid_amount'];
    }

    if (isset($details['remaining_amount'])) {
        $details['status'] = ($details['remaining_amount'] <= 0) ? 'paid' : 'pending';
    }

    return Payment::create($details);
}


    /**
     * Update an existing payment with new details.
     *
     * @param int $id
     * @param array $newDetails
     * @return \App\Models\Payment
     */
    public function updatePayment($id, array $newDetails): Payment
    {
        $payment = Payment::findOrFail($id);
        $payment->update($newDetails);
        return $payment;
    }

    /**
     * Get the payment history for a specific payment ID, including related details.
     *
     * @param int $id
     * @return \App\Models\Payment
     */
    public function getPaymentHistoryById($id): Payment
    {
        return Payment::with('details')->findOrFail($id);
    }

    /**
     * Create a new payment detail record for an existing payment.
     *
     * @param int $paymentId
     * @param array $details
     * @return \App\Models\PaymentDetail
     */
    public function createPaymentDetail(int $paymentId, array $details): PaymentDetail
    {
        return PaymentDetail::create([
            'payment_id' => $paymentId,
            'amount' => $details['amount'],
            'payment_date' => $details['payment_date'],
        ]);
    }

    /**
     * Apply a new payment to an existing record.
     * This method handles both creating the detail and updating the main payment record.
     *
     * @param int $paymentId
     * @param array $details
     * @return \App\Models\Payment
     */
    public function applyNewPayment(int $paymentId, array $details): Payment
    {
        // 1. العثور على سجل الدفعة الرئيسي
        $payment = Payment::findOrFail($paymentId);

        // 2. إنشاء سجل تفصيلي جديد للدفع
        $this->createPaymentDetail($payment->id, [
            'amount' => $details['new_amount'],
            'payment_date' => $details['payment_date'],
        ]);

        // 3. حساب المبلغ المدفوع الجديد والمتبقي
        $newPaidAmount = $payment->paid_amount + $details['new_amount'];
        $newRemainingAmount = $payment->total_amount - $newPaidAmount;
        
        // 4. إعداد البيانات للتحديث
        $updateData = [
            'paid_amount' => $newPaidAmount,
            'remaining_amount' => $newRemainingAmount,
            'status' => ($newRemainingAmount <= 0) ? 'paid' : 'partially_paid',
        ];

        // 5. تحديث سجل الدفعة الرئيسي
        $payment->update($updateData);

        return $payment;
    }
}
