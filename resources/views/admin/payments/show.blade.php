@extends('layouts.admin')

@section('title', 'Payment Details')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-info">
                            <i class="fas fa-credit-card mr-2 "></i>
                            Payment Details
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to Payments
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0 text-dark">Payment Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Payment ID:</strong></td>
                                                <td><code>{{ $payment->id }}</code></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Payment Intent ID:</strong></td>
                                                <td><code>{{ $payment->payment_intent_id ?? 'N/A' }}</code></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Amount:</strong></td>
                                                <td>
                                                    <span class="h5 text-success">
                                                        ${{ number_format($payment->amount, 2) }}
                                                    </span>
                                                    <span
                                                        class="badge badge-secondary ml-2">{{ strtoupper($payment->currency) }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <td>
                                                    @if ($payment->status === 'succeeded')
                                                        <span class=" bg-success badge-lg">Succeeded</span>
                                                    @elseif($payment->status === 'pending')
                                                        <span class="badge bg-warning badge-lg">Pending</span>
                                                    @elseif($payment->status === 'failed')
                                                        <span class="badge bg-danger badge-lg">Failed</span>
                                                    @else
                                                        <span
                                                            class="badge bg-info badge-lg">{{ ucfirst($payment->status) }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email:</strong></td>
                                                <td>{{ $payment->email ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Order ID:</strong></td>
                                                <td>
                                                    @if ($payment->order_id)
                                                        <a href="{{ route('admin.orders.show', $payment->order_id) }}"
                                                            class="btn btn-sm btn-outline-info">
                                                            View Order #{{ $payment->order_id }}
                                                        </a>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0 text-dark">Timestamps</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Created At:</strong></td>
                                                <td>{{ $payment->created_at->format('M j, Y g:i:s A') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Last Updated:</strong></td>
                                                <td>{{ $payment->updated_at->format('M j, Y g:i:s A') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Time Ago:</strong></td>
                                                <td>{{ $payment->created_at->diffForHumans() }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Actions -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0 text-dark">Actions</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="btn-group" role="group">
                                            @if ($payment->order_id)
                                                <a href="{{ route('admin.orders.show', $payment->order_id) }}"
                                                    class="btn btn-info">
                                                    <i class="fas fa-shopping-cart"></i> View Order
                                                </a>
                                            @endif

                                            <button type="button" class="btn btn-danger"
                                                onclick="deletePayment({{ $payment->id }})">
                                                <i class="fas fa-trash"></i> Delete Payment
                                            </button>

                                            <button type="button" class="btn btn-secondary" onclick="window.print()">
                                                <i class="fas fa-print"></i> Print Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deletePaymentModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this payment record?</p>
                    <div class="alert alert-warning">
                        <strong>Warning:</strong> This action cannot be undone and may affect order records.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete Payment</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let paymentToDelete = null;

        function deletePayment(id) {
            paymentToDelete = id;
            $('#deletePaymentModal').modal('show');
        }

        $('#confirmDelete').click(function() {
            if (paymentToDelete) {
                // Create and submit a form for deletion
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/payments/${paymentToDelete}`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    </script>
@endsection
