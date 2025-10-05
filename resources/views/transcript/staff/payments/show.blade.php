@extends('layouts.staff')

@section('title', 'Payment Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Payment Details Card -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-credit-card mr-2"></i>
                        Payment Details - {{ $payment->order_id }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('transcript.staff.payments') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Payments
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Payment Information -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Payment Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Order ID:</strong></td>
                                    <td>{{ $payment->order_id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Transaction ID:</strong></td>
                                    <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Amount:</strong></td>
                                    <td>₦{{ number_format($payment->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($payment->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($payment->status == 'approved')
                                            <span class="badge badge-success">Approved</span>
                                        @elseif($payment->status == 'failed')
                                            <span class="badge badge-danger">Failed</span>
                                        @elseif($payment->status == 'refunded')
                                            <span class="badge badge-secondary">Refunded</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Fee Type:</strong></td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $payment->feeType->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Description:</strong></td>
                                    <td>{{ $payment->description ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Date:</strong></td>
                                    <td>{{ $payment->created_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                                @if($payment->updated_at != $payment->created_at)
                                <tr>
                                    <td><strong>Last Updated:</strong></td>
                                    <td>{{ $payment->updated_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>

                        <!-- Student Information -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Student Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Student Name:</strong></td>
                                    <td>{{ $payment->payer_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Matric Number:</strong></td>
                                    <td>{{ $payment->student->matric_no ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $payment->payer_email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>{{ $payment->payer_phone ?? 'N/A' }}</td>
                                </tr>
                                @if($payment->student)
                                <tr>
                                    <td><strong>Faculty:</strong></td>
                                    <td>{{ $payment->student->faculty ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Department:</strong></td>
                                    <td>{{ $payment->student->department ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Graduation Year:</strong></td>
                                    <td>{{ $payment->student->graduation_year ?? 'N/A' }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="btn-group" role="group">
                                @can('manage_transcript_payments', $staff)
                                @if($payment->status == 'pending')
                                <button class="btn btn-success" onclick="verifyPayment({{ $payment->id }})">
                                    <i class="fas fa-check"></i> Verify Payment
                                </button>
                                <button class="btn btn-danger" onclick="rejectPayment({{ $payment->id }})">
                                    <i class="fas fa-times"></i> Reject Payment
                                </button>
                                @endif
                                
                                @if($payment->status == 'approved')
                                @can('process_transcript_refunds', $staff)
                                <button class="btn btn-warning" onclick="processRefund({{ $payment->id }})">
                                    <i class="fas fa-undo"></i> Process Refund
                                </button>
                                @endcan
                                @endif
                                @endcan

                                <button class="btn btn-info" onclick="printPayment()">
                                    <i class="fas fa-print"></i> Print Receipt
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment History Card -->
            @if(isset($paymentHistory) && $paymentHistory->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-2"></i>
                        Payment History
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Date</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                    <th>Staff</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paymentHistory as $history)
                                <tr>
                                    <td>{{ $history->created_at->format('M d, Y H:i:s') }}</td>
                                    <td>{{ $history->action }}</td>
                                    <td>
                                        <span class="badge badge-{{ $history->status == 'approved' ? 'success' : ($history->status == 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($history->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $history->staff_name ?? 'System' }}</td>
                                    <td>{{ $history->notes ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Verification Modal -->
<div class="modal fade" id="verifyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verify Payment</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to verify this payment?</p>
                <div class="form-group">
                    <label for="verifyNotes">Verification Notes (Optional)</label>
                    <textarea class="form-control" id="verifyNotes" rows="3" placeholder="Add any notes about the verification..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmVerify">Verify Payment</button>
            </div>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Payment</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reject this payment?</p>
                <div class="form-group">
                    <label for="rejectReason">Rejection Reason <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="rejectReason" rows="3" placeholder="Please provide a reason for rejection..." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmReject">Reject Payment</button>
            </div>
        </div>
    </div>
</div>

<!-- Refund Modal -->
<div class="modal fade" id="refundModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Process Refund</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="refundForm">
                    <div class="form-group">
                        <label for="refundReason">Refund Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="refundReason" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="refundAmount">Refund Amount <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="refundAmount" step="0.01" max="{{ $payment->amount }}" value="{{ $payment->amount }}" required>
                        <small class="form-text text-muted">Maximum refund amount: ₦{{ number_format($payment->amount, 2) }}</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="confirmRefund">Process Refund</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function verifyPayment(paymentId) {
    $('#verifyModal').modal('show');
}

function rejectPayment(paymentId) {
    $('#rejectModal').modal('show');
}

function processRefund(paymentId) {
    $('#refundModal').modal('show');
}

function printPayment() {
    window.print();
}

document.getElementById('confirmVerify').addEventListener('click', function() {
    const notes = document.getElementById('verifyNotes').value;
    
    fetch(`{{ route('transcript.staff.payments.verify', $payment->id) }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            notes: notes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error verifying payment: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while verifying the payment.');
    });
    
    $('#verifyModal').modal('hide');
});

document.getElementById('confirmReject').addEventListener('click', function() {
    const reason = document.getElementById('rejectReason').value;
    
    if (!reason.trim()) {
        alert('Please provide a reason for rejection.');
        return;
    }
    
    fetch(`{{ url('transcript/staff/payments') }}/{{ $payment->id }}/reject`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            reason: reason
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error rejecting payment: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while rejecting the payment.');
    });
    
    $('#rejectModal').modal('hide');
});

document.getElementById('confirmRefund').addEventListener('click', function() {
    const reason = document.getElementById('refundReason').value;
    const amount = document.getElementById('refundAmount').value;
    
    if (!reason.trim() || !amount) {
        alert('Please fill in all required fields.');
        return;
    }
    
    if (parseFloat(amount) > {{ $payment->amount }}) {
        alert('Refund amount cannot exceed the original payment amount.');
        return;
    }
    
    fetch(`{{ url('transcript/staff/payments') }}/{{ $payment->id }}/refund`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            reason: reason,
            amount: amount
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error processing refund: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while processing the refund.');
    });
    
    $('#refundModal').modal('hide');
});
</script>
@endsection