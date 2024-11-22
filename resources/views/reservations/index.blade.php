@extends('layouts.master')
@section('css')
<style>
    .reservations_table #reservationsTable_filter {
        width: 100%;
    }
    .reservations_table #reservationsTable_filter input {
        margin: 0px;
        width: 100%;
    }
    #reservationsTable {
        width: 99%;
    }
</style>
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Reservations |</h4>
            <span class="text-muted mt-1 tx-13 mr-3 mb-0">&nbsp;Reservations List</span>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="pr-1 mb-3 mb-xl-0" data-toggle="tooltip" title="Add New Reservation">
            <button type="button" class="modal-effect btn btn-primary btn-icon ml-2" data-effect="effect-fall" data-toggle="modal" href="#addReservationModal">
                <i class="mdi mdi-plus"></i>
            </button>
        </div>
        <div class="pr-1 mb-3 mb-xl-0">
            <button type="button" class="btn btn-warning btn-icon ml-2" data-toggle="tooltip" title="Refresh" onclick="location.reload()">
                <i class="mdi mdi-refresh"></i>
            </button>
        </div>
    </div>
</div>
@endsection

@section('content')
<div>
    <div class="col-xl-12 reservations_table">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <h4 class="card-title mg-b-0">Reservations List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="reservationsTable" class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">Reservation ID</th>
                                <th class="border-bottom-0">Client Name</th>
                                <th class="border-bottom-0">Room Number</th>
                                <th class="border-bottom-0">Check-In</th>
                                <th class="border-bottom-0">Check-Out</th>
                                <th class="border-bottom-0">Total Price</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->id }}</td>
                                    <td>{{ $reservation->client->first_name }} {{ $reservation->client->last_name }}</td>
                                    <td>{{ $reservation->room->nbr }}</td>
                                    <td>{{ $reservation->check_in }}</td>
                                    <td>{{ $reservation->check_out }}</td>
                                    <td>{{ $reservation->total_price }}</td>
                                    <td>{{ $reservation->status }}</td>
                                    <td>
                                        <button type="button" onclick="openEditModal({{ $reservation->id }})" class="btn btn-sm btn-primary mx-1">
                                            <i class="mdi mdi-account-edit"></i>
                                        </button>
                                        <button type="button" onclick="deleteReservation({{ $reservation->id }})" class="btn btn-sm btn-danger mx-1">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
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

<!-- Add Reservation Modal -->
<div class="modal fade" id="addReservationModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add New Reservation</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addReservationForm" method="POST" action="{{ route('reservations.store') }}">
                    @csrf

                    <div class="form-group d-flex flex-column w-100">
                        <label for="client_id">Client <span class="tx-danger">*</span></label>
                        <select id="client_id" name="client_id"
                            class="form-control select2-show-search select2-dropdown">
                            <option value="" disabled selected>Select a client</option>
                        </select>
                    </div>

                    <div class="form-group d-flex flex-column w-100">
                        <label for="room_id">Room <span class="tx-danger">*</span></label>
                        <select id="room_id" name="room_id" class="form-control select2">
                            <option value="" disabled selected>Select available room</option>
                        </select>
                    </div>

                    <div class="d-flex flex-row justify-content-between">
                        <div class="form-group w-50 pr-2">
                            <label for="check_in">Check-In <span class="tx-danger">*</span></label>
                            <input type="date" id="check_in" name="check_in" class="form-control">
                        </div>
                        <div class="form-group w-50 pl-2">
                            <label for="check_out">Check-Out <span class="tx-danger">*</span></label>
                            <input type="date" id="check_out" name="check_out" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status <span class="tx-danger">*</span></label>
                        <select id="status" name="status" class="form-control">
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="canceled">Canceled</option>
                        </select>
                    </div>

                    <div class="d-flex flex-row justify-content-between">
                        <div class="form-group w-50 pr-1 pr-2">
                            <label for="payment_method">Payment Method <span class="tx-danger">*</span></label>
                            <select id="payment_method" name="payment_method" class="form-control">
                                <option value="cash">Cash</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="paypal">Paypal</option>
                                <option value="bank_transfer">Bank Transfer</option>
                            </select>
                        </div>
                        <div class="form-group w-50 pl-2">
                            <label for="payment_status">Payment Status <span class="tx-danger">*</span></label>
                            <select id="payment_status" name="payment_status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="total_price">Total Price <span class="tx-danger">*</span></label>
                        <input type="number" id="total_price" name="total_price" class="form-control"
                            value="0.00" readonly>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn ripple btn-primary">Save</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Edit and Delete Modals would be similar -->
@endsection

@section('js')
<!-- DataTables Scripts -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>

<!--Internal Counters -->
<script src="{{ URL::asset('assets/plugins/counters/waypoints.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/counters/counterup.min.js') }}"></script>
<!--Internal Time Counter -->
<script src="{{ URL::asset('assets/plugins/counters/jquery.missofis-countdown.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/counters/counter.js') }}"></script>

<!-- Internal Modal js-->
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>

<script src="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/telephoneinput/inttelephoneinput.js') }}"></script>

<!--Internal  Parsley.min js -->
<script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>

<!-- Link to the custom toast script -->
<script src="{{ URL::asset('assets/custom/toast.js') }}"></script>

<!-- Select2 -->
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#reservationsTable').DataTable({
            columnDefs: [
                { orderable: false, searchable: false, targets: -1 }
            ],
            language: {
                searchPlaceholder: 'Search reservations...',
                sSearch: '',
                lengthMenu: '_MENU_',
            },
        });
    });

    function openEditModal(reservationId) {
        // Implement fetch reservation details via AJAX and show edit modal
    }

    function deleteReservation(reservationId) {
        // Implement delete logic via AJAX and refresh the table
    }

    $(document).ready(function() {
            // Select2 for Clients
            $('#client_id').select2({
                placeholder: 'Select a client',
                ajax: {
                    url: "{{ route('clients.autocomplete') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: `${item.first_name || ''} ${item.last_name || ''}`,
                                    first_name: item.first_name,
                                    last_name: item.last_name,
                                    cin: item.cin
                                };
                            })
                        };
                    }
                },
                templateResult: formatClient,
                templateSelection: formatClientSelection
            });

            function formatClient(client) {
                if (!client.id) {
                    return client.text;
                }
                return $('<option></option>').attr('value', client.id)
                    .html(`${client.first_name} ${client.last_name} <span>(${client.cin})</span>`);
            }

            function formatClientSelection(client) {
                return client.text || `${client.first_name} ${client.last_name}`;
            }

            // Select2 for Rooms
            $('#room_id').select2({
                placeholder: 'Select a room',
                ajax: {
                    url: "{{ route('rooms.autocomplete') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    }
                },
                templateResult: formatRoom,
                templateSelection: formatRoomSelection
            });

            function formatRoom(room) {
                if (!room.id) {
                    return room.text;
                }
                return $('<option></option>').attr('value', room.id)
                    .html(
                        `<span class="d-flex justify-content-between"><span>${room.nbr} (${room.type})</span><span>$${room.price}</span></span>`
                    );
            }

            function formatRoomSelection(room) {
                return room.text || room.name;
            }

            let roomPrice = 0;
            $('#room_id').on('select2:select', function(e) {
                const selectedRoom = e.params.data;
                roomPrice = parseFloat(selectedRoom.price);
                calculateTotalPrice();
            });

            $('#check_in, #check_out').on('change', calculateTotalPrice);

            function calculateTotalPrice() {
                const checkInDate = new Date($('#check_in').val());
                const checkOutDate = new Date($('#check_out').val());

                if (checkInDate && checkOutDate && roomPrice > 0) {
                    const timeDifference = checkOutDate - checkInDate;
                    const dayCount = timeDifference / (1000 * 60 * 60 * 24);

                    if (dayCount > 0) {
                        const totalPrice = dayCount * roomPrice;
                        $('#total_price').val(totalPrice.toFixed(2));
                    } else {
                        $('#total_price').val('0.00');
                    }
                }
            }

            $('#addReservationModal').on('hidden.bs.modal', function() {
                // Reset the form inputs
                $('#addReservationForm')[0].reset();

                // Clear select2 fields (if using select2 for select elements)
                $('#client_id').val(null).trigger('change'); // Reset client_id select2
                $('#room_id').val(null).trigger('change'); // Reset room_id select2
                $('#payment_method').val("cash").trigger('change'); // Reset payment_method select2
                $('#payment_status').val("pending").trigger('change'); // Reset payment_status select2

                // Reset total price field
                $('#total_price').val('0.00');
            });
        });

        $(document).ready(function() {
            let isValid = true;

            $('#addReservationForm').on('submit', function(e) {
                e.preventDefault();
                $('.form-group .error-message').remove();
                isValid = true;

                validateClient();
                validateRoom();
                validateDates();
                validatePaymentMethod();
                validateTotalPrice();

                if (isValid) {
                    const formData = $(this).serialize();

                    $.ajax({
                        url: "{{ route('reservations.store') }}",
                        method: "POST",
                        data: formData,
                        success: function(response) {
                            $('#addReservationForm').modal('hide');
                            $('#addReservationForm')[0].reset();
                            showCustomToast("The reservation was added successfully!", 'Notification',
                                4000);
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                displayErrors(errors);
                            }
                        }
                    });
                }
            });

            $('#client_id').on('change', function() {
                validateClient();
            });

            $('#room_id').on('change', function() {
                validateRoom();
            });

            $('#check_in, #check_out').on('change', function() {
                validateDates();
            });

            $('#payment_method').on('change', function() {
                validatePaymentMethod();
            });

            $('#total_price').on('change', function() {
                validateTotalPrice();
            });

            function showError(selector, message) {
                const errorMessage = `<span class="text-danger error-message">${message}</span>`;
                $(selector).closest('.form-group').append(errorMessage);
                isValid = false;
            }

            function validateClient() {
                if ($('#client_id').val() === null) {
                    showError('#client_id', 'Please select a client.');
                } else {
                    clearError('#client_id');
                }
            }

            function validateRoom() {
                if ($('#room_id').val() === null) {
                    showError('#room_id', 'Please select a room.');
                } else {
                    clearError('#room_id');
                }
            }

            function validateDates() {
                const checkIn = $('#check_in').val();
                const checkOut = $('#check_out').val();

                if (!checkIn) {
                    showError('#check_in', 'Check-in date is required.');
                } else {
                    clearError('#check_in');
                }

                if (!checkOut) {
                    showError('#check_out', 'Check-out date is required.');
                } else if (new Date(checkOut) <= new Date(checkIn)) {
                    showError('#check_out', 'Check-out date must be after the check-in date.');
                } else {
                    clearError('#check_out');
                }
            }

            function validatePaymentMethod() {
                if ($('#payment_method').val() === null) {
                    showError('#payment_method', 'Please select a payment method.');
                } else {
                    clearError('#payment_method');
                }
            }

            function validateTotalPrice() {
                if ($('#total_price').val() <= 0) {
                    showError('#total_price', 'Total price must be greater than 0.');
                } else {
                    clearError('#total_price');
                }
            }

            function clearError(selector) {
                $(selector).closest('.form-group').find('.error-message').remove();
            }

            function displayErrors(errors) {
                for (const [field, messages] of Object.entries(errors)) {
                    const input = $(`[name="${field}"]`);
                    const errorMessage = `<span class="text-danger error-message">${messages[0]}</span>`;
                    input.closest('.form-group').append(errorMessage);
                }
            }
        });
</script>
@endsection
