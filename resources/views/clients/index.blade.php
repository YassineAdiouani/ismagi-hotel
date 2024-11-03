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
                <button type="button" class="modal-effect btn btn-primary btn-icon ml-2" data-effect="effect-fall" data-toggle="modal" href="#modaldemo8">
                    <i class="mdi mdi-plus"></i>
                </button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-warning btn-icon ml-2" data-toggle="tooltip" data-placement="bottom" title="Refresh" onclick="location.reload()">
                    <i class="mdi mdi-refresh"></i>
                </button>
            </div>
        </div>
        <div class="modal" id="modaldemo8">
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
                        <form action="{{ route('clients.store') }}" method="POST"  data-parsley-validate="">
                            @csrf
                            <div class="form-group">
                                <label for="cin">CIN <span class="tx-danger">*</span></label>
                                <input type="text" id="cin" name="cin" placeholder="cin..." class="form-control" required="">
                            </div>
                            <div class="form-group">
                                <label for="first_name">First Name <span class="tx-danger">*</span></label>
                                <input type="text" id="first_name" name="first_name" placeholder="first name..." class="form-control" required="">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name <span class="tx-danger">*</span></label>
                                <input type="text" id="last_name" name="last_name" placeholder="last name..." class="form-control" required="">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="email..." class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone <span class="tx-danger">*</span></label>
                                <div class="input-group phone_select_input">
                                    <input type="tel" id="phone" name="phone"  class="form-control" required="">
								</div>
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
                                    <td>{{ $client->cin }}</td>
                                    <td>{{ $client->first_name }}</td>
                                    <td>{{ $client->last_name }}</td>
                                    <td>{{ $client->email ?? 'N/A' }}</td>
                                    <td>{{ $client->phone }}</td>
                                    <td>
                                        <!-- Action buttons (e.g., edit, delete) -->
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
</script>
@endsection