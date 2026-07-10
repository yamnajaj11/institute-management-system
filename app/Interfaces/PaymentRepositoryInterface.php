<?php

namespace App\Interfaces;

use App\Models\Payment;
use App\Models\PaymentDetail;
use Illuminate\Database\Eloquent\Collection;

interface PaymentRepositoryInterface
{
    /**
     * Get all payments with the associated student relationship.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPayments(): Collection;

    /**
     * Get a single payment by ID with the associated student relationship.
     *
     * @param int $id
     * @return \App\Models\Payment
     */
    public function getPaymentById($id): Payment;

    /**
     * Get the total paid amount for a specific student.
     *
     * @param int $studentId
     * @return float
     */
    public function getStudentTotalPaidAmount($studentId): float;

    /**
     * Delete a payment by ID.
     *
     * @param int $id
     * @return void
     */
    public function deletePayment($id): void;

    /**
     * Create a new payment record.
     *
     * @param array $details
     * @return \App\Models\Payment
     */
    public function createPayment(array $details): Payment;

    /**
     * Update an existing payment with new details.
     *
     * @param int $id
     * @param array $newDetails
     * @return \App\Models\Payment
     */
    public function updatePayment($id, array $newDetails): Payment;

    /**
     * Get the payment history for a specific payment ID, including related details.
     *
     * @param int $id
     * @return \App\Models\Payment
     */
    public function getPaymentHistoryById($id): Payment;
    
    /**
     * Create a new payment detail record for an existing payment.
     *
     * @param int $paymentId
     * @param array $details
     * @return \App\Models\PaymentDetail
     */
    public function createPaymentDetail(int $paymentId, array $details): PaymentDetail;

    /**
     * Apply a new payment to an existing payment record.
     *
     * @param int $paymentId
     * @param array $details
     * @return \App\Models\Payment
     */
    public function applyNewPayment(int $paymentId, array $details): Payment;
}
