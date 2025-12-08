@php
    $totalUsers = App\Models\User::count();
    $users = App\Models\User::orderBy('id', 'desc')->paginate(10);


    
    $totalBalance = App\Models\User::sum('wallet_balance');
    $newUsers = App\Models\User::where('created_at', '>=', now()->subDays(30))->count();
@endphp

@extends('adminlte::page')

@section('title', 'Users Management')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">
            <i class="fas fa-users mr-2"></i>
            Users Management
        </h1>
        
    </div>
@stop

@section('content')
<!-- Statistics Cards -->

<div class="row mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalUsers }}</h3>
                <p>Total Users</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
   
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>Usd {{ number_format($totalBalance, 2) }}</h3>
                <p>Total Collected</p>
            </div>
            <div class="icon">
                <i class="fas fa-coins"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $newUsers }}</h3>
                <p>New This Month</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
        </div>
    </div>
</div>


<!-- Users Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-list mr-1"></i>
            All Users
        </h3>
        <div class="card-tools">
    <form method="GET" action="{{ route('admin.users') }}">
        <div class="input-group input-group-sm" style="width: 250px;">
            <input type="text" name="search" class="form-control float-right" 
                   placeholder="Search users..." value="{{ request('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap" id="usersTable">
            <thead class="bg-light">
                <tr>
                    <th>ID</th>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Country</th>
                    <th>Phone</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <div class="user-avatar">
                            @if($user->avatar)
                                <img src="{{ asset($user->avatar) }}" alt="Avatar" class="img-circle" width="35" height="35">
                            @else
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 35px; height: 35px; font-size: 14px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <strong>{{ $user->name }}</strong>
                        @if($user->email_verified_at)
                            <i class="fas fa-check-circle text-success ml-1" title="Verified"></i>
                        @endif
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->country ?? 'Not provided' }}</td>
                    <td>{{ $user->phone ?? 'Not provided' }}</td>
                    <td>
                        <span class="badge badge-success badge-lg">
                            USD {{ number_format($user->wallet_balance ?? 0, 2) }}
                        </span>
                    </td>
                    <td>
                        @if($user->status == 'active' || !isset($user->status))
                            <span class="badge badge-success">Active</span>
                        @elseif($user->status == 'suspended')
                            <span class="badge badge-warning">Suspended</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <small class="text-muted">{{ $user->created_at->format('M d, Y') }}</small>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-sm" onclick="viewUser({{ $user->id }})" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-warning btn-sm" onclick="updateBalance({{ $user->id }}, '{{ $user->name }}', {{ $user->wallet_balance ?? 0 }})" title="Update Balance">
                                <i class="fas fa-coins"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="editUser({{ $user->id }})" title="Edit User">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteUser({{ $user->id }})" title="Delete User">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No users found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                
                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() ?? 0 }} users
            </div>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Update Balance Modal -->
<div class="modal fade" id="updateBalanceModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">
                    <i class="fas fa-coins mr-2"></i>
                    Update User Balance
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="updateBalanceForm">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-user-circle fa-3x text-muted"></i>
                        <h5 class="mt-2" id="modalUserName"></h5>
                    </div>
                    
                    <div class="form-group">
                        <label for="currentBalance">Current Balance</label>
                        <input type="text" class="form-control" id="currentBalance" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="balanceAction">Action</label>
                        <select class="form-control" id="balanceAction" name="action" required>
                            <option value="">Select Action</option>
                            <option value="add">Add to Balance</option>
                            <option value="subtract">Subtract from Balance</option>
                            <option value="set">Set New Balance</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="amount">Amount (Usd)</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="amount" name="amount" placeholder="Enter amount" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="reason">Reason for Change</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Enter reason for balance update..." required></textarea>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Preview:</strong> <span id="balancePreview">Select an action to see preview</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-1"></i> Update Balance
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus mr-2"></i>
                    Add New User
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="addUserForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="initialBalance">Initial Balance (Usd)</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="initialBalance" name="balance" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-1"></i> Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .table th {
        border-top: none;
    }
    .badge-lg {
        font-size: 0.9em;
        padding: 0.5em 0.8em;
    }
    .user-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-group .btn {
        margin-right: 2px;
    }
    .small-box {
        border-radius: 10px;
    }
    .modal-header {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .card {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
</style>
@stop

@section('js')
<script>
let currentUserId = null;
let currentUserBalance = 0;

// Update Balance Modal Functions
function updateBalance(userId, userName, balance) {
    currentUserId = userId;
    currentUserBalance = parseFloat(balance);
    
    $('#modalUserName').text(userName);
    $('#currentBalance').val('Usd ' + number_format(balance, 2));
    $('#balanceAction').val('');
    $('#amount').val('');
    $('#reason').val('');
    $('#balancePreview').text('Select an action to see preview');
    
    $('#updateBalanceModal').modal('show');
}

// Balance Preview Calculation
$('#balanceAction, #amount').on('change keyup', function() {
    const action = $('#balanceAction').val();
    const amount = parseFloat($('#amount').val()) || 0;
    let preview = '';
    
    if (action && amount > 0) {
        let newBalance = currentUserBalance;
        
        switch(action) {
            case 'add':
                newBalance = currentUserBalance + amount;
                preview = `Current: Usd ${number_format(currentUserBalance, 2)} + Usd ${number_format(amount, 2)} = Usd ${number_format(newBalance, 2)}`;
                break;
            case 'subtract':
                newBalance = currentUserBalance - amount;
                preview = `Current: Usd ${number_format(currentUserBalance, 2)} - Usd ${number_format(amount, 2)} = Usd ${number_format(newBalance, 2)}`;
                if (newBalance < 0) {
                    preview += ' <span class="text-danger">(Negative Balance!)</span>';
                }
                break;
            case 'set':
                newBalance = amount;
                preview = `New Balance: Usd ${number_format(newBalance, 2)}`;
                break;
        }
    } else {
        preview = 'Select an action to see preview';
    }
    
    $('#balancePreview').html(preview);
});

// Update Balance Form Submit
// Update Balance Form Submit
$('#updateBalanceForm').on('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        _token: $('input[name="_token"]').val(),
        action: $('#balanceAction').val(),
        amount: $('#amount').val(),
        reason: $('#reason').val()
    };
    
    $.ajax({
        url: '{{ route("admin.users.update-balance", ["user" => ":user"]) }}'.replace(':user', currentUserId),
        method: 'POST',
        data: formData,
        success: function(response) {
            $('#updateBalanceModal').modal('hide');
            toastr.success('Balance updated successfully!');
            location.reload();
        },
        error: function(xhr) {
            const errors = xhr.responseJSON.errors;
            let errorMessage = 'Error updating balance:';
            
            if (errors) {
                Object.keys(errors).forEach(key => {
                    errorMessage += '\n- ' + errors[key][0];
                });
            }
            
            toastr.error(errorMessage);
        }
    });
});

// Add User Form Submit
$('#addUserForm').on('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        _token: $('input[name="_token"]').val(),
        name: $('#name').val(),
        email: $('#email').val(),
        phone: $('#phone').val(),
        balance: $('#initialBalance').val(),
        password: $('#password').val()
    };
    
  
});

// Other Functions
function viewUser(userId) {
    window.location.href = `/admin/users/${userId}`;
}

function editUser(userId) {
    window.location.href = `/admin/users/${userId}/edit`;
}

function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        $.ajax({
            url: `/admin/users/${userId}`,
            method: 'DELETE',
            data: {
                _token: $('input[name="_token"]').val()
            },
            success: function(response) {
                toastr.success('User deleted successfully!');
                location.reload();
            },
            error: function(xhr) {
                toastr.error('Error deleting user!');
            }
        });
    }
}

// Search Functionality
$('#searchInput').on('keyup', function() {
    const value = $(this).val().toLowerCase();
    $('#usersTable tbody tr').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});

// Number formatting helper function
function number_format(number, decimals = 2) {
    return parseFloat(number).toLocaleString('en-US', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    });
}

// Initialize tooltips
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@stop