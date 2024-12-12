@extends('layouts.master')

@section('css')
    <style>
        .description {
            display: inline-block;
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            vertical-align: bottom;
        }
    </style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Rooms | </h4>
                <span class="text-muted mt-1 tx-13 mr-3 mb-0">&nbsp;rooms list</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0" data-toggle="tooltip" data-placement="bottom" title="Add New Room">
                <button type="button" class="modal-effect btn btn-primary btn-icon ml-2" data-effect="effect-fall" data-toggle="modal" href="#addRoomModal">
                    <i class="mdi mdi-plus"></i>
                </button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-warning btn-icon ml-2" data-toggle="tooltip" data-placement="bottom" title="Refresh" onclick="location.reload()">
                    <i class="mdi mdi-refresh"></i>
                </button>
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
                        <form id="addRoomForm" data-action="{{ route('rooms.store') }}" data-method="POST" enctype="multipart/form-data" data-parsley-validate>
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="nbr">Room Number <span class="tx-danger">*</span></label>
                                    <input type="text" id="nbr" name="nbr" placeholder="Room number..." class="form-control" required
                                           data-parsley-required-message="Room number is required">
                                    <div class="error text-danger" id="nbr-error"></div>
                                </div>
                        
                                <div class="form-group col-md-6">
                                    <label for="floor">Floor <span class="tx-danger">*</span></label>
                                    <input type="number" id="floor" name="floor" placeholder="Floor..." class="form-control" required
                                           data-parsley-type="integer" data-parsley-required-message="Floor is required">
                                    <div class="error text-danger" id="floor-error"></div>
                                </div>
                        
                                <div class="form-group col-md-6">
                                    <label for="price">Price <span class="tx-danger">*</span></label>
                                    <input type="number" id="price" name="price" placeholder="Price..." class="form-control" required
                                           data-parsley-type="number" data-parsley-required-message="Price is required">
                                    <div class="error text-danger" id="price-error"></div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="type">Room Type <span class="tx-danger">*</span></label>
                                    <select id="type" name="type" class="form-control" required data-parsley-required-message="Room type is required">
                                        <option value="single">Single</option>
                                        <option value="double">Double</option>
                                        <option value="suite">Suite</option>
                                    </select>
                                    <div class="error text-danger" id="type-error"></div>
                                </div>
                        
                                <div class="form-group col-md-6">
                                    <label for="status">Status <span class="tx-danger">*</span></label>
                                    <select id="status" name="status" class="form-control" required data-parsley-required-message="Status is required">
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
                                              data-parsley-type="string" data-parsley-required-message="Description is required if provided"></textarea>
                                    <div class="error text-danger" id="description-error"></div>
                                </div>
                        
                                <div class="form-group col-md-12">
                                    <input class="custom-file-input" id="customFile" type="file" name="images[]" accept="image/jpeg, image/png, image/jpg" multiple>
                                    <label style="margin: 0px 14px;" class="custom-file-label" for="customFile" id="file-count-label">Choose files</label>
                                    <div class="error text-danger" id="images-error"></div>
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

        <div class="modal fade" id="editRoomModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Edit Room</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for Editing an Existing Room with Parsley Validation -->
                        <form id="editRoomForm" action="" data-method="POST" enctype="multipart/form-data" data-parsley-validate>
                            @csrf
                            @method('PUT')
        
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="edit-nbr">Room Number <span class="tx-danger">*</span></label>
                                    <input type="text" id="edit-nbr" name="nbr" placeholder="Room number..." class="form-control" required
                                           data-parsley-required-message="Room number is required">
                                    <div class="error text-danger" id="edit-nbr-error"></div>
                                </div>
        
                                <div class="form-group col-md-6">
                                    <label for="edit-floor">Floor <span class="tx-danger">*</span></label>
                                    <input type="number" id="edit-floor" name="floor" placeholder="Floor..." class="form-control" required
                                           data-parsley-type="integer" data-parsley-required-message="Floor is required">
                                    <div class="error text-danger" id="edit-floor-error"></div>
                                </div>
        
                                <div class="form-group col-md-6">
                                    <label for="edit-price">Price <span class="tx-danger">*</span></label>
                                    <input type="text" id="edit-price" name="price" placeholder="Price..." class="form-control" 
       required data-parsley-type="number" data-parsley-required-message="Price is required"
       data-parsley-pattern="^\d+(\.\d{1,2})?$" data-parsley-pattern-message="Please enter a valid price (up to 2 decimal places)">
                                    <div class="error text-danger" id="edit-price-error"></div>
                                </div>
                            </div>
        
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="edit-type">Room Type <span class="tx-danger">*</span></label>
                                    <select id="edit-type" name="type" class="form-control" required data-parsley-required-message="Room type is required">
                                        <option value="single">Single</option>
                                        <option value="double">Double</option>
                                        <option value="suite">Suite</option>
                                    </select>
                                    <div class="error text-danger" id="edit-type-error"></div>
                                </div>
        
                                <div class="form-group col-md-6">
                                    <label for="edit-status">Status <span class="tx-danger">*</span></label>
                                    <select id="edit-status" name="status" class="form-control" required data-parsley-required-message="Status is required">
                                        <option value="available">Available</option>
                                        <option value="reserved">Reserved</option>
                                        <option value="maintenance">Maintenance</option>
                                        <option value="occupied">Occupied</option>
                                    </select>
                                    <div class="error text-danger" id="edit-status-error"></div>
                                </div>
        
                                <div class="form-group col-md-12">
                                    <label for="edit-description">Description</label>
                                    <textarea id="edit-description" name="description" placeholder="Room description..." class="form-control"
                                              data-parsley-type="string" data-parsley-required-message="Description is required if provided"></textarea>
                                    <div class="error text-danger" id="edit-description-error"></div>
                                </div>
        
                                <div class="form-group col-md-12">
                                    <input class="custom-file-input" id="edit-customFile" type="file" name="images[]" accept="image/jpeg, image/png, image/jpg" multiple>
                                    <label style="margin: 0px 14px;" class="custom-file-label" for="edit-customFile" id="edit-file-count-label">Choose files</label>
                                    <div class="error text-danger" id="edit-images-error"></div>
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
        
        <div class="modal fade" id="deleteRoomModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        <i class="mdi mdi-alert-circle-outline tx-100 tx-danger mg-t-20 d-inline-block"></i>
                        <h4 class="tx-danger mg-b-20">Confirm Deletion</h4>
                        <p class="mg-b-20">Are you sure you want to delete this room?</p>
                        
                        <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}">
        
                        <button type="button" class="btn btn-danger" id="confirmDeleteRoom">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection

@section('content')
<div class="d-flex flex-column">
    <form method="GET" action="{{ route('rooms.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by room number or description">
            </div>
            <div class="col-md-2">
                <select name="type" class="form-control">
                    <option value="">All Types</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->type }}" {{ request('type') == $type->type ? 'selected' : '' }}>
                            {{ ucfirst($type->type) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->status }}" {{ request('status') == $status->status ? 'selected' : '' }}>
                            {{ ucfirst($status->status) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" data-toggle="tooltip" data-placement="bottom" title="Search" class="btn btn-primary btn-with-icon btn-block w-100">
                    <i class="mdi mdi-magnify"></i> Search
                </button>
            </div>
        </div>
    </form>

    <div class="row row-sm">
        @foreach ($rooms as $room)
            <div class="col-md-6 col-lg-6 col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="pro-img-box">
                            <div class="d-flex product-sale d-flex justify-content-between">
                                <div style="position: relative; z-index: 100;" class="badge text-capitalize font-weight-bolder
                                    @if($room->status == 'available') bg-success-gradient
                                    @elseif($room->status == 'reserved') bg-warning-gradient
                                    @elseif($room->status == 'maintenance') bg-danger-gradient
                                    @elseif($room->status == 'occupied') bg-info-gradient
                                    @endif
                                ">
                                    {{ $room->status }}
                                </div>
                                <div class="dropdown">

                                    <span data-toggle="dropdown" id="dropdownMenuButton" aria-expanded="false" aria-haspopup="true" style="position: relative; z-index: 100; right: 25px;cursor: pointer;" class="badge badge-dark">
                                        <i class="fe fe-align-right px-1" style="font-size: 13px;" data-toggle="tooltip" data-placement="bottom" title="Actions"></i>
                                    </span>
                                    <div  class="dropdown-menu tx-13">
                                        <span class="dropdown-item" style="cursor: pointer;" onclick="openEditModal({{ $room->id }})">Update</span>
                                        <span style="cursor: pointer;" class="dropdown-item" onclick="deleteRoom({{ $room->id }})">Delete</span>
                                    </div>
                                </div>
                            </div>
                            <div id="carouselExample2-{{ $room->id }}" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @php
                                        $images = json_decode($room->images);
                                    @endphp
                            
                                    @if(!empty($images) && count($images) > 0)
                                        @foreach($images as $index => $image)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <div style="position: relative; height: 200px; overflow: hidden;">
                                                    <img 
                                                        style="object-fit: cover; width: 100%; height: 100%;" 
                                                        alt="Room image" 
                                                        class="d-block w-100" 
                                                        src="{{ $image }}"
                                                        onerror="this.onerror=null; this.src='{{ URL::asset('assets/img/photos/13.jpg') }}'; this.parentNode.querySelector('.fallback-text').style.display = 'block';"
                                                    >
                                                    {{-- <img 
                                                        style="object-fit: cover; width: 100%; height: 100%;" 
                                                        alt="Room image" 
                                                        class="d-block w-100" 
                                                        src="{{ URL::asset($image) }}"
                                                        onerror="this.onerror=null; this.src='{{ URL::asset('assets/img/photos/13.jpg') }}'; this.parentNode.querySelector('.fallback-text').style.display = 'block';"
                                                    > --}}
                                                    <div class="fallback-text text-light w-100 text-center" 
                                                         style="font-size: 17px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: none;">
                                                        No Image Available
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="carousel-item active">
                                            <div style="position: relative; height: 200px; overflow: hidden;">
                                                <img 
                                                    style="object-fit: cover; width: 100%; height: 100%;" 
                                                    alt="No image available" 
                                                    class="d-block w-100" 
                                                    src="{{ URL::asset('assets/img/photos/13.jpg') }}"
                                                >
                                                <div class="fallback-text text-light w-100 text-center" 
                                                     style="font-size: 17px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                    No Image Available
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <a class="carousel-control-prev" href="#carouselExample2-{{ $room->id }}" role="button" data-slide="prev">
                                    <i class="fa fa-angle-left fs-30" aria-hidden="true"></i>
                                </a>
                                <a class="carousel-control-next" href="#carouselExample2-{{ $room->id }}" role="button" data-slide="next">
                                    <i class="fa fa-angle-right fs-30" aria-hidden="true"></i>
                                </a>
                            </div>                            
                            {{-- <a href="#" class="adtocart" style="left: 43% !important;"> <i class="las la-notes-medical"></i>
                            </a> --}}
                            <div class="adtocart d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <strong>
                                    ${{ $room->price}}
                                </strong>
                            </div>
                        </div>
                        <div class="pt-3">
                            <div class="d-flex justify-content-between align-items-center pt-3 pb-1 px-1">
                                <span class="font-weight-bold tx-16 text-uppercase">{{ $room->nbr }}</span>
                                <span>
                                    
                                    <span style="font-size: 12px !important;" class="text-capitalize font-weight-bold badge badge-dark">
                                        {{ $room->type }}
                                    </span>
                                </span>
                            </div>
                            <span class="text-secondary font-weight-normal tx-13 px-1 description" title="{{ $room->description }}" data-toggle="tooltip" data-placement="bottom">
                                {{ $room->description }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Custom Pagination -->
    <ul class="pagination product-pagination mr-auto float-left">
        <!-- Previous Page Link -->
        <li class="page-item page-prev {{ $rooms->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $rooms->previousPageUrl() }}" tabindex="-1">Prev</a>
        </li>

        <!-- Page Number Links -->
        @for ($i = 1; $i <= $rooms->lastPage(); $i++)
            <li class="page-item {{ $rooms->currentPage() == $i ? 'active' : '' }}">
                <a class="page-link" href="{{ $rooms->appends(request()->except('page'))->url($i) }}">{{ $i }}</a>
            </li>
        @endfor

        <!-- Next Page Link -->
        <li class="page-item page-next {{ $rooms->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $rooms->nextPageUrl() }}">Next</a>
        </li>
    </ul>
</div>
@endsection

@section('js')
<!--Internal  Parsley.min js -->
<script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>

<script>
    $(document).ready(function() {
        'use strict';

        $('#addRoomForm').parsley();

        $('#customFile').on('change', function() {
            var fileCount = $(this)[0].files.length;
            var label = fileCount === 0 ? 'Choose files' : fileCount + ' file(s) selected';
            $('#file-count-label').text(label);

            var files = $(this)[0].files;
            var valid = true;
            var typeErrorFiles = [];
            var sizeErrorFiles = [];

            $.each(files, function(index, file) {
                if (!file.type.match('image/jpeg') && !file.type.match('image/png') && !file.type.match('image/jpg')) {
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
                errorMessages.push("File " + typeErrorFiles.join(', ') + " must be of type jpeg, png, or jpg.");
            }
            if (sizeErrorFiles.length > 0) {
                errorMessages.push("File " + sizeErrorFiles.join(', ') + " is too large. Maximum size is 2MB.");
            }

            if (!valid) {
                $('#images-error').html(errorMessages.join('<br>'));
            } else {
                $('#images-error').text('');
            }
        });

        $('#addRoomForm').on('submit', function(event) {
            event.preventDefault();

            if ($(this).parsley().isValid() && $('#images-error').text() === '') {
        
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
                        window.location.reload();
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

        $('#editRoomForm').off('submit').on('submit', function(event) {
            event.preventDefault();

            const action = $(this).attr('action'); // Use 'action' instead of 'data-action'
            const formData = new FormData(this); // Use FormData for handling files

            // Clear previous error messages
            $('.error.text-danger').text('');

            $.ajax({
                url: action,
                method: "POST", // Use POST with method override for PUT
                data: formData,
                processData: false, // Prevent jQuery from automatically processing the data
                contentType: false, // Ensure correct content type for file upload
                success: function(response) {
                    $('#editRoomModal').modal('hide');
                    window.location.reload(); // Reload to reflect changes
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $(`#edit-${key}-error`).text(value[0]); // Match error field IDs
                        });
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                }
            });
        });
    });

    function openEditModal(roomId) {
        $.ajax({
            url: `/rooms/${roomId}/edit`,
            method: "GET",
            success: function(room) {
                // Populate the form fields with room data
                $('#editRoomForm #edit-nbr').val(room.nbr);
                $('#editRoomForm #edit-floor').val(room.floor);
                $('#editRoomForm #edit-price').val(room.price);
                
                // Set select values
                $('#editRoomForm #edit-type').val(room.type);
                $('#editRoomForm #edit-status').val(room.status);

                $('#editRoomForm #edit-description').val(room.description);

                // Set the form action URL for updating the room
                $('#editRoomForm').attr('action', `/rooms/${roomId}`);
                
                // Show the edit modal
                $('#editRoomModal').modal('show');
            },
            error: function(xhr) {
                // Handle errors (e.g., room not found)
                console.error('Failed to fetch room data:', xhr.responseText);
                alert('Error fetching room data. Please try again.');
            }
        });
    }


    function deleteRoom(roomId) {
        $('#deleteRoomModal').modal('show');

        $('#confirmDeleteRoom').off('click').on('click', function () {
            const csrfToken = $('#csrf-token').val();

            $.ajax({
                url: `/rooms/${roomId}`,
                method: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    $('#deleteRoomModal').modal('hide');
                    window.location.reload();
                },
                error: function(xhr) {
                    alert("Failed to delete the room. Please try again.");
                }
            });
        });
    }

</script>
@endsection