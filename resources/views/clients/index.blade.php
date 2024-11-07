@extends('layouts.master')
@section('css')
<style>
    .clients_table #clientsTable_filter{
        width: 100%;
    }
    .clients_table #clientsTable_filter input{
        margin: 0px;
        width: 100%;
    }
    .phone_select_input  .iti--allow-dropdown{
        width: 100% !important;
    }
    #clientsTable{
        width:99%;
    }
    #addClientsModal .iti__flag-container .iti__selected-flag{
        height: 37px;
        width: 70px;
    }
</style>
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">

<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css')}}">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Clients</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ clients list</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0"  data-toggle="tooltip" data-placement="bottom" title="Add New Client">
                <button type="button" class="modal-effect btn btn-primary btn-icon ml-2" data-effect="effect-fall" data-toggle="modal" href="#addClientsModal">
                    <i class="mdi mdi-plus"></i>
                </button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-warning btn-icon ml-2" data-toggle="tooltip" data-placement="bottom" title="Refresh" onclick="location.reload()">
                    <i class="mdi mdi-refresh"></i>
                </button>
            </div>
        </div>
        <div class="modal" id="addClientsModal">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
                        <h6 class="modal-title">Add New Client</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for Adding a New Client -->
                        <form id="addClientForm" data-action="{{ route('clients.store') }}" data-method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="cin">CIN <span class="tx-danger">*</span></label>
                                <input type="text" id="cin" name="cin" placeholder="cin..." class="form-control" required 
                                       data-parsley-required-message="CIN is required">
                                <div class="error text-danger" id="cin-error"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="first_name">First Name <span class="tx-danger">*</span></label>
                                <input type="text" id="first_name" name="first_name" placeholder="first name..." class="form-control" required 
                                       data-parsley-required-message="First name is required">
                                <div class="error text-danger" id="first_name-error"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="last_name">Last Name <span class="tx-danger">*</span></label>
                                <input type="text" id="last_name" name="last_name" placeholder="last name..." class="form-control" required 
                                       data-parsley-required-message="Last name is required">
                                <div class="error text-danger" id="last_name-error"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="email..." class="form-control"
                                       data-parsley-type="email" data-parsley-type-message="Enter a valid email address">
                                <div class="error text-danger" id="email-error"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">Phone <span class="tx-danger">*</span></label>
                                <div class="input-group phone_select_input">
                                    <input type="tel" id="phone" name="phone" class="form-control" required 
                                           data-parsley-required-message="Phone number is required">
                                </div>
                                <div class="error text-danger" id="phone-error"></div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="submit" class="btn ripple btn-primary">Save changes</button>
                                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                            </div>
                        </form>                                         
                    </div>
				</div>
			</div>
		</div>

        <div class="modal" id="editClientModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Edit Client</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editClientForm" method="POST">
                            @csrf
                            @method('PUT')
        
                            <!-- Client form fields -->
                            <div class="form-group">
                                <label for="cin">CIN</label>
                                <input type="text" id="cin" name="cin" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-control">
                            </div>
        
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control">
                            </div>
        
                             <div class="form-group">
                                <label for="phone">Phone</label>
                                <div class="input-group phone_select_input">
                                    <input type="tel" id="phone" name="phone" class="form-control" required 
                                           data-parsley-required-message="Phone number is required">
                                </div>
                                <div class="error text-danger" id="phone-error"></div>
                            </div>
        
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="deleteClientModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        <i class="mdi mdi-alert-circle-outline tx-100 tx-danger mg-t-20 d-inline-block"></i>
                        <h4 class="tx-danger mg-b-20">Confirm Deletion</h4>
                        <p class="mg-b-20">Are you sure you want to delete this client?</p>
                        
                        <!-- Hidden CSRF token input -->
                        <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}">
        
                        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
<div>
    <div class="col-xl-12 clients_table">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">Clients List</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="clientsTable" class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">CIN</th>
                                <th class="border-bottom-0">First Name</th>
                                <th class="border-bottom-0">Last Name</th>
                                <th class="border-bottom-0">Email</th>
                                <th class="border-bottom-0">Phone</th>
                                <th class="border-bottom-0">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td class="py-3" style="vertical-align: middle;">{{ $client->cin }}</td>
                                    <td class="py-3" style="vertical-align: middle;">{{ $client->first_name }}</td>
                                    <td class="py-3" style="vertical-align: middle;">{{ $client->last_name }}</td>
                                    <td class="py-3" style="vertical-align: middle;">{{ $client->email ?? 'N/A' }}</td>
                                    <td class="py-3" style="vertical-align: middle;">{{ $client->phone }}</td>
                                    <td style="vertical-align: middle;">
                                        <span class="d-flex">
                                            <button type="button" onclick="openEditModal({{ $client->id }})" class="btn btn-sm btn-primary mx-1 my-0">
                                                <i class="mdi mdi-account-edit" style="font-size: 17px;"></i>
                                            </button>
                                            <button type="button" onclick="deleteClient({{ $client->id }})" class="btn btn-sm btn-danger mx-1">
                                                <i class="mdi mdi-delete" style="font-size: 17px;"></i>
                                            </button>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>                          
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- DataTables Scripts -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

<script src="{{URL::asset('assets/plugins/telephoneinput/telephoneinput.js')}}"></script>
<script src="{{URL::asset('assets/plugins/telephoneinput/inttelephoneinput.js')}}"></script>

<!--Internal  Parsley.min js -->
<script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>

<script>
    $(document).ready(function () {
        $('#clientsTable').DataTable({
            columnDefs: [
                { orderable: false, searchable: false, targets: -1 } // Disable filter and sort for the "Actions" column
            ],
            language: {
                searchPlaceholder: 'Search clients...',
                sSearch: '',
                lengthMenu: '_MENU_',
            },
        });
        const phoneInput = document.querySelector("#phone");
        window.intlTelInput(phoneInput, {
            initialCountry: "ma", // Morocco
            preferredCountries: ["ma"],
            utilsScript: "{{URL::asset('assets/plugins/telephoneinput/utils.js')}}"
        });
    });

    $(function() {
        'use strict';

        $(document).ready(function() {
            $('#addClientForm').parsley();
        });

        // AJAX form submission with Parsley validation
        $('#addClientForm').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            if ($(this).parsley().isValid()) {
                // If form is valid, proceed with AJAX
                $('.error').text(''); // Clear previous error messages

                const formData = $(this).serialize();
                const action = $(this).data('action');
                const method = $(this).data('method');

                $.ajax({
                    url: action,
                    method: method,
                    data: formData,
                    success: function(response) {
                        // Close the modal
                        $('#addClientsModal').modal('hide');
                        
                        // Add the new client to the table
                        loadClientsTable();

                        // Reset the form if needed
                        $('#addClientForm')[0].reset();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) { // Validation error
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                // Display the first error message for each field
                                $(`#${key}-error`).text(value[0]);
                            });
                        }
                    }
                });
            }
        });
    });

    function openEditModal(clientId) {
        $.ajax({
            url: `/clients/${clientId}/edit`,
            method: "GET",
            success: function(client) {
                $('#editClientForm #cin').val(client.cin);
                $('#editClientForm #first_name').val(client.first_name);
                $('#editClientForm #last_name').val(client.last_name);
                $('#editClientForm #email').val(client.email);
                $('#editClientForm #phone').val(client.phone);
                
                // Set the form action URL for updating the client
                $('#editClientForm').attr('data-action', `/clients/${clientId}`);
                
                // Show the edit modal
                $('#editClientModal').modal('show');
            }
        });
    }

    $('#editClientForm').on('submit', function(event) {
        event.preventDefault();
        
        const action = $(this).data('action');
        const formData = $(this).serialize();

        $.ajax({
            url: action,
            method: "PUT",
            data: formData,
            success: function(response) {
                $('#editClientModal').modal('hide');
                loadClientsTable(); // Reload the table data
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $(`#${key}-error`).text(value[0]);
                    });
                }
            }
        });
    });

    function deleteClient(clientId) {
        $('#deleteClientModal').modal('show');

        $('#confirmDelete').off('click').on('click', function () {
            const csrfToken = $('#csrf-token').val(); // Get the CSRF token value

            $.ajax({
                url: `/clients/${clientId}`,
                method: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    $('#deleteClientModal').modal('hide');
                    loadClientsTable(); // Reload the table to reflect changes
                },
                error: function(xhr) {
                    alert("Failed to delete the client. Please try again.");
                }
            });
        });
    }

    const loadClientsTable = () => {
        $.ajax({
            url: "{{ route('clients.index') }}", // Route to fetch clients data
            method: "GET",
            success: function(clients) {
                let rows = '';
                clients.forEach(client => {
                    rows += `
                        <tr>
                            <td>${client.cin}</td>
                            <td>${client.first_name}</td>
                            <td>${client.last_name}</td>
                            <td>${client.email ?? 'N/A'}</td>
                            <td>${client.phone}</td>
                            <td style="vertical-align: middle;">
                                <span class="d-flex">
                                    <button type="button" onclick="openEditModal(${client.id})" class="btn btn-sm btn-primary mx-1 my-0">
                                        <i class="mdi mdi-account-edit" style="font-size: 17px;"></i>
                                    </button>
                                    <button type="button" onclick="deleteClient(${client.id})" class="btn btn-sm btn-danger mx-1">
                                        <i class="mdi mdi-delete" style="font-size: 17px;"></i>
                                    </button>
                                </span>
                            </td>
                        </tr>
                    `;
                });
                $('#clientsTable tbody').html(rows); // Replace table body
            },
            error: function(xhr) {
                alert("Failed to load clients. Please try again.");
            }
        });
    };

</script>
@endsection