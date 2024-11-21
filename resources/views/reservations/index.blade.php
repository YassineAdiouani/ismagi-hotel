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
            <h4 class="content-title mb-0 my-auto">Reservations</h4>
            <span class="text-muted mt-1 tx-13 mr-3 mb-0">| Reservations List</span>
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
                                <th>Reservation ID</th>
                                <th>Client Name</th>
                                <th>Room Number</th>
                                <th>Check-In</th>
                                <th>Check-Out</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Actions</th>
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
                    <div class="form-group">
                        <label for="client_id">Client</label>
                        <select id="client_id" name="client_id" class="form-control" required>
                            <option value="" disabled selected>Select a client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->first_name }} {{ $client->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="room_id">Room</label>
                        <select id="room_id" name="room_id" class="form-control" required>
                            <option value="" disabled selected>Select a room</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}">Room {{ $room->nbr }} - {{ $room->type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="check_in">Check-In</label>
                        <input type="date" id="check_in" name="check_in" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="check_out">Check-Out</label>
                        <input type="date" id="check_out" name="check_out" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="total_price">Total Price</label>
                        <input type="number" id="total_price" name="total_price" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="Pending">Pending</option>
                            <option value="Confirmed">Confirmed</option>
                            <option value="Canceled">Canceled</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn ripple btn-primary">Save</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit and Delete Modals would be similar -->
@endsection

@section('js')
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
</script>
@endsection
