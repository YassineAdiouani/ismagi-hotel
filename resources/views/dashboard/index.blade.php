@extends('layouts.master')

@section('css')
    <link href="https://cdn.materialdesignicons.com/7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
    <!-- Link to the custom toast styles -->
    <link rel="stylesheet" href="{{ URL::asset('assets/custom/toast.css') }}">

    <!-- Select2 CSS -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <style>
        .phone_select_input .iti--allow-dropdown {
            width: 100% !important;
        }

        #addClientsModal .iti__flag-container .iti__selected-flag {
            height: 37px;
            width: 70px;
        }
    </style>
@endsection

@section('page-header')
    <div class="pos-relative toast-place">

    </div>
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Hi, welcome back ! |</h4>
                <span class="text-muted mt-1 tx-13 mr-3 mb-0">&nbsp;Dashboard</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div style="margin-right: 20px">
                <label class="tx-13 text-secondary">Clients</label>
                <h5 class="clients_counter" style="margin-top: -10px">{{ $totalClients }}</h5>
            </div>
            <div style="margin-right: 20px">
                <label class="tx-13 text-secondary">Rooms</label>
                <h5 class="rooms_counter" style="margin-top: -10px">{{ $totalRooms }}</h5>
            </div>
            <div class="pr-1 mb-3 mb-xl-0" data-toggle="tooltip" data-placement="bottom" title="Reserve Room">
                <button type="button" class="modal-effect btn btn-danger btn-icon ml-2" data-effect="effect-fall"
                    data-toggle="modal" href="#addReservationModal">
                    <i class="las la-notes-medical"></i>
                </button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0" data-toggle="tooltip" data-placement="bottom" title="Add New Client">
                <button type="button" class="modal-effect btn btn-primary btn-icon ml-2" data-effect="effect-fall"
                    data-toggle="modal" href="#addClientsModal">
                    <i class="fe fe-user-plus"></i>
                </button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0" data-toggle="tooltip" data-placement="bottom" title="Add New Room">
                <button type="button" class="modal-effect btn btn-info btn-icon ml-2" data-effect="effect-fall"
                    data-toggle="modal" href="#addRoomModal">
                    <i class="mdi mdi-home-plus-outline"></i>
                </button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-warning btn-icon ml-2" data-toggle="tooltip" data-placement="bottom"
                    title="Refresh" onclick="location.reload()">
                    <i class="mdi mdi-refresh"></i>
                </button>
            </div>
        </div>

        <div class="modal fade" id="addClientsModal">
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
                                <input type="text" id="cin" name="cin" placeholder="cin..."
                                    class="form-control" required data-parsley-required-message="CIN is required">
                                <div class="error text-danger" id="cin-error"></div>
                            </div>
                            <div class="form-group">
                                <label for="first_name">First Name <span class="tx-danger">*</span></label>
                                <input type="text" id="first_name" name="first_name" placeholder="first name..."
                                    class="form-control" required data-parsley-required-message="First name is required">
                                <div class="error text-danger" id="first_name-error"></div>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name <span class="tx-danger">*</span></label>
                                <input type="text" id="last_name" name="last_name" placeholder="last name..."
                                    class="form-control" required data-parsley-required-message="Last name is required">
                                <div class="error text-danger" id="last_name-error"></div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="email..."
                                    class="form-control" data-parsley-type="email"
                                    data-parsley-type-message="Enter a valid email address">
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
                                <button class="btn ripple btn-secondary" data-dismiss="modal"
                                    type="button">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addRoomModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Add New Room</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for Adding a New Room with Parsley Validation -->
                        <form id="addRoomForm" data-action="{{ route('rooms.store') }}" data-method="POST"
                            enctype="multipart/form-data" data-parsley-validate>
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="nbr">Room Number <span class="tx-danger">*</span></label>
                                    <input type="text" id="nbr" name="nbr" placeholder="Room number..."
                                        class="form-control" required
                                        data-parsley-required-message="Room number is required">
                                    <div class="error text-danger" id="nbr-error"></div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="floor">Floor <span class="tx-danger">*</span></label>
                                    <input type="number" id="floor" name="floor" placeholder="Floor..."
                                        class="form-control" required data-parsley-type="integer"
                                        data-parsley-required-message="Floor is required">
                                    <div class="error text-danger" id="floor-error"></div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="price">Price <span class="tx-danger">*</span></label>
                                    <input type="number" id="price" name="price" placeholder="Price..."
                                        class="form-control" required data-parsley-type="number"
                                        data-parsley-required-message="Price is required">
                                    <div class="error text-danger" id="price-error"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="type">Room Type <span class="tx-danger">*</span></label>
                                    <select id="type" name="type" class="form-control" required
                                        data-parsley-required-message="Room type is required">
                                        <option value="single">Single</option>
                                        <option value="double">Double</option>
                                        <option value="suite">Suite</option>
                                    </select>
                                    <div class="error text-danger" id="type-error"></div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="status">Status <span class="tx-danger">*</span></label>
                                    <select id="status" name="status" class="form-control" required
                                        data-parsley-required-message="Status is required">
                                        <option value="available">Available</option>
                                        <option value="reserved">Reserved</option>
                                        <option value="maintenance">Maintenance</option>
                                        <option value="occupied">Occupied</option>
                                    </select>
                                    <div class="error text-danger" id="status-error"></div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="description" placeholder="Room description..." class="form-control"
                                        data-parsley-minlength="8" data-parsley-maxlength="255"
                                        data-parsley-required-message="Description is required if provided"></textarea>
                                    <div class="error text-danger" id="description-error"></div>
                                </div>

                                <div class="form-group col-md-12">
                                    <input class="custom-file-input" id="customFile" type="file" name="images[]"
                                        accept="image/jpeg, image/png, image/jpg" multiple>
                                    <label style="margin: 0px 14px;" class="custom-file-label" for="customFile"
                                        id="file-count-label">Choose files</label>
                                    <div class="error text-danger" id="images-error"></div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn ripple btn-primary">Save changes</button>
                                <button class="btn ripple btn-secondary" data-dismiss="modal"
                                    type="button">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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

    </div>
@endsection

@php
    $statusColors = [
        'available' => 'bg-success-gradient',
        'reserved' => 'bg-warning-gradient',
        'maintenance' => 'bg-danger-gradient',
        'occupied' => 'bg-info-gradient',
    ];
    $statusIcons = [
        'available' => 'icon-check',
        'reserved' => 'icon-calendar',
        'maintenance' => 'icon-wrench',
        'occupied' => 'icon-close',
    ];

    $typeColors = [
        'single' => 'bg-secondary-gradient',
        'double' => 'bg-info-gradient',
        'suite' => 'bg-purple-gradient',
    ];
    $typeIcons = [
        'single' => 'icon-user',
        'double' => 'icon-people',
        'suite' => 'icon-diamond',
    ];
@endphp

@section('content')
    <div class="mb-2 mx-1">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Room Statuses</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Room Statuses -->
        @foreach ($statusTotals as $status => $total)
            <div class="col-lg-3 col-md-6">
                <div class="card {{ $statusColors[$status] ?? 'bg-info-gradient' }}">
                    <div class="card-body">
                        <div class="counter-status d-flex md-mb-0">
                            <div class="counter-icon">
                                <i class="{{ $statusIcons[$status] ?? 'icon-settings' }}"></i>
                            </div>
                            <div class="mx-5">
                                <h5 class="tx-13 tx-white-8 mb-3">{{ ucfirst($status) }}</h5>
                                <h2 class="counter mb-0 text-white">{{ $total }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mb-2 mx-1">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Rooms Types</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Room Types -->
        @foreach ($typeTotals as $type => $total)
            <div class="col-lg-4 col-md-6">
                <div class="card {{ $typeColors[$type] ?? 'bg-success-gradient' }}">
                    <div class="card-body">
                        <div class="counter-status d-flex md-mb-0">
                            <div class="counter-icon">
                                <i class="{{ $typeIcons[$type] ?? 'icon-key' }}"></i>
                            </div>
                            <div class="mx-5">
                                <h5 class="tx-13 tx-white-8 mb-3">{{ ucfirst($type) }}</h5>
                                <h2 class="counter mb-0 text-white">{{ $total }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row row-sm row-deck">
        <div class="col-md-12 col-lg-4 col-xl-4">
            <div class="card card-dashboard-eight pb-2">
                <h6 class="card-title">Top Reserved Rooms</h6>
                <span class="d-block mg-b-10 text-muted tx-12">Most reserved rooms based on the number of
                    reservations</span>
                <div class="list-group">
                    @foreach ($topReservedRooms as $room)
                        <div class="list-group-item">
                            <i
                                class="{{ $typeColors[$room->type] ?? 'bg-success-gradient' }} text-white p-2 bx-border-circle {{ $typeIcons[$room->type] ?? 'icon-key' }}"></i>
                            <p>{{ $room->nbr }} ({{ ucfirst($room->type) }})</p>
                            <span class="d-flex">{{ $room->reservation_count }} Reservations &nbsp;<span
                                    class="text-muted">(${{ number_format($room->price, 2) }})</span></span>
                        </div>
                    @endforeach

                    @if ($topReservedRooms->isEmpty())
                        <div class="list-group-item">
                            <p>No data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-8 col-xl-8">
            <div class="card card-table-two">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mb-1">Top Clients</h4>
                </div>
                <span class="tx-12 text-muted mb-3">This is a list of your top clients by reservations and spending.</span>
                <div class="table-responsive country-table">
                    <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                        <thead>
                            <tr>
                                <th class="wd-lg-5p">#Id</th>
                                <th class="wd-lg-25p">CIN</th>
                                <th class="wd-lg-25p">Client Name</th>
                                <th class="wd-lg-25p tx-right">Reservations</th>
                                <th class="wd-lg-25p tx-right">Total Spent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topClients as $client)
                                <tr>
                                    <td>{{ $client->id }}</td>
                                    <td>{{ $client->cin }}</td>
                                    <td>{{ $client->full_name }}</td>
                                    <td class="tx-right tx-medium tx-inverse">{{ $client->reservation_count }}</td>
                                    <td class="tx-right tx-medium tx-inverse">
                                        ${{ number_format($client->total_spent, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
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
        $(document).ready(function() {
            'use strict';

            const phoneInput = document.querySelector("#phone");
            window.intlTelInput(phoneInput, {
                initialCountry: "ma",
                preferredCountries: ["ma"],
                utilsScript: "{{ URL::asset('assets/plugins/telephoneinput/utils.js') }}"
            });

            $('#addClientForm').parsley();

            $('#addClientForm').on('submit', function(event) {
                event.preventDefault();
                if ($(this).parsley().isValid()) {
                    $('.error').text('');

                    const formData = $(this).serialize();
                    const action = $(this).data('action');
                    const method = $(this).data('method');

                    $.ajax({
                        url: action,
                        method: method,
                        data: formData,
                        success: function(response) {
                            $('#addClientsModal').modal('hide');

                            $('#addClientForm')[0].reset();
                            $('#addClientForm').parsley().reset();
                            showCustomToast("The client was added successfully!",
                                'Notification', 4000);
                            var clientsCounter = $('.clients_counter');
                            if (clientsCounter.length) {
                                var currentCount = parseInt(clientsCounter.html(),
                                    10); // Get current count and parse as integer
                                if (!isNaN(currentCount)) {
                                    clientsCounter.html(currentCount + 1); // Increment by 1
                                }
                            }
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
                }
            });
        });

        $(document).ready(function() {

            $('#customFile').on('change', function() {
                var fileCount = $(this)[0].files.length;
                var label = fileCount === 0 ? 'Choose files' : fileCount + ' file(s) selected';
                $('#file-count-label').text(label);

                var files = $(this)[0].files;
                var valid = true;
                var typeErrorFiles = [];
                var sizeErrorFiles = [];

                $.each(files, function(index, file) {
                    if (!file.type.match('image/jpeg') && !file.type.match('image/png') && !file
                        .type.match('image/jpg')) {
                        valid = false;
                        typeErrorFiles.push(index + 1);
                    }

                    if (file.size > 2048 * 1024) {
                        valid = false;
                        sizeErrorFiles.push(index + 1);
                    }
                });

                var errorMessages = [];

                if (typeErrorFiles.length > 0) {
                    errorMessages.push("File " + typeErrorFiles.join(', ') +
                        " must be of type jpeg, png, or jpg.");
                }
                if (sizeErrorFiles.length > 0) {
                    errorMessages.push("File " + sizeErrorFiles.join(', ') +
                        " is too large. Maximum size is 2MB.");
                }

                if (!valid) {
                    $('#images-error').html(errorMessages.join('<br>'));
                } else {
                    $('#images-error').text('');
                }
            });

            $('#addRoomModal').parsley();

            $('#addRoomForm').on('submit', function(event) {
                event.preventDefault();

                if ($(this).parsley().isValid()) {

                    $('.error').text('');

                    let formData = new FormData(this);
                    const action = $(this).data('action');
                    const method = $(this).data('method');

                    $.ajax({
                        url: action,
                        type: method,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('#addRoomModal').modal('hide');
                            $('#addRoomForm')[0].reset();
                            showCustomToast("The room was added successfully!", 'Notification',
                                4000);
                            var roomsCounter = $('.rooms_counter');
                            if (roomsCounter.length) {
                                var currentCount = parseInt(roomsCounter.html(), 10);
                                if (!isNaN(currentCount)) {
                                    roomsCounter.html(currentCount + 1);
                                }
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                $.each(errors, function(key, error) {
                                    $(`#${key}-error`).text(error[0]);
                                });
                            }
                        }
                    });
                }
            });
        });

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
