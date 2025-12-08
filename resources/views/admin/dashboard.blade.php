@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">
            <i class="fas fa-tachometer-alt mr-2"></i>
            Admin Dashboard
        </h1>
        <div class="btn-group">
            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-download mr-1"></i> Export
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#"><i class="fas fa-file-pdf mr-2"></i>PDF</a>
                <a class="dropdown-item" href="#"><i class="fas fa-file-excel mr-2"></i>Excel</a>
                <a class="dropdown-item" href="#"><i class="fas fa-file-csv mr-2"></i>CSV</a>
            </div>
        </div>
    </div>
@stop

@section('content')
<!-- Welcome Alert -->
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <i class="fas fa-info-circle mr-2"></i>
    <strong>Welcome back!</strong> Here's what's happening with your platform today.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<!-- Statistics Cards Row -->
<div class="row mb-4">
    <!-- Total Users Card -->
    <div class="col-lg-3 col-md-6">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">Total Users</h5>
                        <h2 class="mb-0 font-weight-bold">{{ number_format($totalUsers) }}</h2>
                        <small class="opacity-75">
                            <i class="fas fa-arrow-up mr-1"></i>
                            12% from last month
                        </small>
                    </div>
                    <div class="ml-3">
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-primary-dark">
                <a href="{{ route('admin.users') }}" class="text-white text-decoration-none">
                    <small>View Details <i class="fas fa-arrow-right ml-1"></i></small>
                </a>
            </div>
        </div>
    </div>

    <!-- Total Transactions Card -->
    <div class="col-lg-3 col-md-6">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">Total Transactions</h5>
                        <h2 class="mb-0 font-weight-bold">{{ number_format($totalTransactions) }}</h2>
                        <small class="opacity-75">
                            <i class="fas fa-minus mr-1"></i>
                            No change
                        </small>
                    </div>
                    <div class="ml-3">
                        <i class="fas fa-exchange-alt fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-success-dark">
                <a href="#" class="text-white text-decoration-none">
                    <small>View Details <i class="fas fa-arrow-right ml-1"></i></small>
                </a>
            </div>
        </div>
    </div>

    <!-- STK Push Requests Card -->
    <div class="col-lg-3 col-md-6">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">STK Requests</h5>
                        <h2 class="mb-0 font-weight-bold">{{ number_format($stkPushRequests) }}</h2>
                        <small class="opacity-75">
                            <i class="fas fa-arrow-up mr-1"></i>
                            8% from yesterday
                        </small>
                    </div>
                    <div class="ml-3">
                        <i class="fas fa-mobile-alt fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-warning-dark">
                <a href="#" class="text-white text-decoration-none">
                    <small>View Details <i class="fas fa-arrow-right ml-1"></i></small>
                </a>
            </div>
        </div>
    </div>

    <!-- Total Deposits Card -->
    <div class="col-lg-3 col-md-6">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">Total Deposits</h5>
                        <h2 class="mb-0 font-weight-bold">KSh {{ number_format($totalDeposits, 2) }}</h2>
                        <small class="opacity-75">
                            <i class="fas fa-arrow-up mr-1"></i>
                            15% from last week
                        </small>
                    </div>
                    <div class="ml-3">
                        <i class="fas fa-coins fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-info-dark">
                <a href="#" class="text-white text-decoration-none">
                    <small>View Details <i class="fas fa-arrow-right ml-1"></i></small>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Analytics Row -->
<div class="row mb-4">
    <!-- Revenue Chart -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Revenue Overview</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="position-relative mb-4">
                    <canvas id="revenue-chart" height="300"></canvas>
                </div>
                <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                        <i class="fas fa-square text-primary"></i> Deposits
                    </span>
                    <span>
                        <i class="fas fa-square text-gray"></i> Withdrawals
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Quick Stats
                </h3>
            </div>
            <div class="card-body">
                <!-- Success Rate -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Success Rate</span>
                        <span class="text-success">
                            {{ $stkPushRequests > 0 ? number_format((App\Models\MpesaStk::where('status', 'success')->count() / $stkPushRequests) * 100, 1) : 0 }}%
                        </span>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success" 
                             style="width: {{ $stkPushRequests > 0 ? (App\Models\MpesaStk::where('status', 'success')->count() / $stkPushRequests) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

                <!-- Average Deposit -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Avg. Deposit</span>
                        <span class="text-info">
                            KSh {{ $stkPushRequests > 0 ? number_format($totalDeposits / App\Models\MpesaStk::where('status', 'success')->count(), 2) : '0.00' }}
                        </span>
                    </div>
                </div>

                <!-- Active Users -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Active Users</span>
                        <span class="text-primary">{{ number_format($totalUsers) }}</span>
                    </div>
                </div>

                <!-- System Status -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>System Status</span>
                        <span class="badge badge-success">Online</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bolt mr-1"></i>
                    Quick Actions
                </h3>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-primary btn-block">
                        <i class="fas fa-user-plus mr-2"></i>Add New User
                    </a>
                    <a href="#" class="btn btn-success btn-block">
                        <i class="fas fa-money-bill-wave mr-2"></i>Process Payment
                    </a>
                    <a href="#" class="btn btn-info btn-block">
                        <i class="fas fa-chart-bar mr-2"></i>View Reports
                    </a>
                    <a href="#" class="btn btn-warning btn-block">
                        <i class="fas fa-cog mr-2"></i>Settings
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history mr-1"></i>
                    Recent STK Push Requests
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Phone</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(App\Models\MpesaStk::latest()->take(10)->get() as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->phone }}</td>
                            <td>KSh {{ number_format($transaction->amount, 2) }}</td>
                            <td>
                                @if($transaction->status == 'success')
                                    <span class="badge badge-success">Success</span>
                                @elseif($transaction->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @else
                                    <span class="badge badge-danger">Failed</span>
                                @endif
                            </td>
                            <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No STK push requests found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-sm btn-primary">
                    <i class="fas fa-list mr-1"></i>View All Transactions
                </a>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .bg-primary-dark {
        background-color: rgba(0, 123, 255, 0.8) !important;
    }
    .bg-success-dark {
        background-color: rgba(40, 167, 69, 0.8) !important;
    }
    .bg-warning-dark {
        background-color: rgba(255, 193, 7, 0.8) !important;
    }
    .bg-info-dark {
        background-color: rgba(23, 162, 184, 0.8) !important;
    }
    .opacity-50 {
        opacity: 0.5;
    }
    .opacity-75 {
        opacity: 0.75;
    }
    .card {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        border: none;
    }
    .card-header {
        background-color: transparent;
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    .btn-block {
        margin-bottom: 10px;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    // Revenue Chart
    var ctx = document.getElementById('revenue-chart').getContext('2d');
    var revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Deposits',
                data: [{{ $totalDeposits * 0.1 }}, {{ $totalDeposits * 0.15 }}, {{ $totalDeposits * 0.12 }}, {{ $totalDeposits * 0.18 }}, {{ $totalDeposits * 0.20 }}, {{ $totalDeposits * 0.17 }}, {{ $totalDeposits }}],
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'KSh ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Auto-refresh every 30 seconds
    setInterval(function() {
        location.reload();
    }, 30000);
});
</script>
@stop