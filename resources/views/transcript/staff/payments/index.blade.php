@extends('layouts.staff')

@section('title', 'Payment Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-credit-card mr-2"></i>
                        Payment Management
                    </h3>
                    <div class="card-tools">
                        @can('generate_payment_reports', $staff)
                        <a href="{{ route('transcript.staff.reports') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-chart-bar"></i> Generate Reports
                        </a>
                        @endcan
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-control" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="failed">Failed</option>
                                <option value="refunded">Refunded</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="feeTypeFilter">
                                <option value="">All Fee Types</option>
                                <option value="transcript">Transcript</option>
                                <option value="verification">Verification</option>
                                <option value="duplicate">Duplicate</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="searchInput" placeholder="Search by student name, matric number, or order ID...">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-block" onclick="filterPayments()">
                                <i class="fas fa-search"></i> Filter
                            </button>
                        </div>
                    </div>

                    <!-- Payments Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="paymentsTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Student</th>
                                    <th>Matric Number</th>
                                    <th>Fee Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Payment Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                <tr>
                                    <td>{{ $payment->order_id }}</td>
                                    <td>{{ $payment->payer_name }}</td>
                                    <td>{{ $payment->student->matric_no ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $payment->feeType->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>₦{{ number_format($payment->amount, 2) }}</td>
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
                                    <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('transcript.staff.payments.show', $payment->id) }}" 
                                               class="btn btn-sm btn-info" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @can('manage_transcript_payments', $staff)
                                            @if($payment->status == 'pending')
                                            <button class="btn btn-sm btn-success" 
                                                    onclick="verifyPayment({{ $payment->id }})" 
                                                    title="Verify Payment">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            @endif
                                            
                                            @if($payment->status == 'approved')
                                            @can('process_transcript_refunds', $staff)
                                            <button class="btn btn-sm btn-warning" 
                                                    onclick="processRefund({{ $payment->id }})" 
                                                    title="Process Refund">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                            @endcan
                                            @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No payments found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if(method_exists($payments, 'links'))
                    <div class="d-flex justify-content-center">
                        {{ $payments->links() }}
                    </div>
                    @endif
                </div>
            </div>
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
                <div id="verificationDetails"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmVerify">Verify Payment</button>
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
                        <label for="refundReason">Refund Reason</label>
                        <textarea class="form-control" id="refundReason" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="refundAmount">Refund Amount</label>
                        <input type="number" class="form-control" id="refundAmount" step="0.01" required>
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
let currentPaymentId = null;

function filterPayments() {
    const status = document.getElementById('statusFilter').value;
    const feeType = document.getElementById('feeTypeFilter').value;
    const search = document.getElementById('searchInput').value;
    
    // Build query parameters
    const params = new URLSearchParams();
    if (status) params.append('status', status);
    if (feeType) params.append('fee_type', feeType);
    if (search) params.append('search', search);
    
    // Reload page with filters
    window.location.href = '{{ route("transcript.staff.payments") }}?' + params.toString();
}

function verifyPayment(paymentId) {
    currentPaymentId = paymentId;
    $('#verifyModal').modal('show');
}

function processRefund(paymentId) {
    currentPaymentId = paymentId;
    $('#refundModal').modal('show');
}

document.getElementById('confirmVerify').addEventListener('click', function() {
    if (currentPaymentId) {
        // Send AJAX request to verify payment
        fetch(`{{ url('transcript/staff/payments') }}/${currentPaymentId}/verify`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
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
    }
});

document.getElementById('confirmRefund').addEventListener('click', function() {
    const reason = document.getElementById('refundReason').value;
    const amount = document.getElementById('refundAmount').value;
    
    if (currentPaymentId && reason && amount) {
        // Send AJAX request to process refund
        fetch(`{{ url('transcript/staff/payments') }}/${currentPaymentId}/refund`, {
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
    }
});

// Search on Enter key
document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        filterPayments();
    }
});
</script>
@endsection