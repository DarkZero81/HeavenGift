@extends('layouts.admin')

@section('title', 'Payments Management')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-credit-card mr-2"></i>
                            Payments Management
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.payments.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add New Payment
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($payments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Payment Intent ID</th>
                                            <th>Amount</th>
                                            <th>Currency</th>
                                            <th>Status</th>
                                            <th>Email</th>
                                            <th>Order ID</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payments as $payment)
                                            <tr>
                                                <td>{{ $payment->id }}</td>
                                                <td>
                                                    <code
                                                        class="text-muted">{{ $payment->payment_intent_id ?? 'N/A' }}</code>
                                                </td>
                                                <td>
                                                    <strong class="text-success">
                                                        ${{ number_format($payment->amount, 2) }}
                                                    </strong>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-secondary">{{ strtoupper($payment->currency) }}</span>
                                                </td>
                                                <td>
                                                    @if ($payment->status === 'succeeded')
                                                        <span class="badge bg-success">Succeeded</span>
                                                    @elseif($payment->status === 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @elseif($payment->status === 'failed')
                                                        <span class="badge bg-danger">Failed</span>
                                                    @else
                                                        <span class="badge bg-info">{{ ucfirst($payment->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $payment->email ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($payment->order_id)
                                                        <a href="{{ route('admin.orders.show', $payment->order_id) }}"
                                                            class="btn btn-sm btn-outline-info">
                                                            Order #{{ $payment->order_id }}
                                                        </a>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>{{ $payment->created_at->format('M j, Y g:i A') }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.payments.show', $payment->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="deletePayment({{ $payment->id }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $payments->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                                <h4 class="text-muted">No payments found</h4>
                                <p class="text-muted">When payments are made, they will appear here.</p>
                            </div>
                        @endif
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
                    <p>Are you sure you want to delete this payment record? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
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
