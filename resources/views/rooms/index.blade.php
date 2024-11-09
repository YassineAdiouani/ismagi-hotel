@extends('layouts.master')
@section('css')
@section('css')

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
    <div class="row row-sm">
        <div class="col-md-6 col-lg-6 col-xl-4  col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="pro-img-box">
                        <div class="d-flex product-sale">
                            <div class="badge bg-pink">New</div>
                            <i class="mdi mdi-heart-outline ml-auto wishlist"></i>
                        </div>
                        <img class="w-100" src="{{URL::asset('assets/img/ecommerce/01.jpg')}}" alt="product-image">
                        <a href="#" class="adtocart"> <i class="las la-shopping-cart "></i>
                        </a>
                    </div>
                    <div class="text-center pt-3">
                        <h3 class="h6 mb-2 mt-4 font-weight-bold text-uppercase">FLOWER POT</h3>
                        <span class="tx-15 ml-auto">
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star-half text-warning"></i>
                            <i class="ion ion-md-star-outline text-warning"></i>
                        </span>
                        <h4 class="h5 mb-0 mt-2 text-center font-weight-bold text-danger">$26 <span class="text-secondary font-weight-normal tx-13 ml-1 prev-price">$59</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-4  col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="pro-img-box">
                        <div class="d-flex product-sale">
                            <i class="mdi mdi-heart text-danger ml-auto wishlist"></i>
                        </div>
                        <img class="w-100" src="{{URL::asset('assets/img/ecommerce/02.jpg')}}" alt="product-image">
                        <a href="#" class="adtocart"> <i class="las la-shopping-cart "></i>
                        </a>
                    </div>
                    <div class="text-center pt-3">
                        <h3 class="h6 mb-2 mt-4 font-weight-bold text-uppercase">Chair</h3>
                        <span class="tx-15 ml-auto">
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star-half text-warning"></i>
                            <i class="ion ion-md-star-outline text-warning"></i>
                        </span>
                        <h4 class="h5 mb-0 mt-2 text-center font-weight-bold text-danger">$35 <span class="text-secondary font-weight-normal tx-13 ml-1 prev-price">$79</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-4  col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="pro-img-box">
                        <div class="d-flex product-sale">
                            <div class="badge bg-success">New</div>
                            <i class="mdi mdi-heart-outline ml-auto wishlist"></i>
                        </div>
                        <img class="w-100" src="{{URL::asset('assets/img/ecommerce/03.jpg')}}" alt="product-image">
                        <a href="#" class="adtocart"> <i class="las la-shopping-cart "></i>
                        </a>
                    </div>
                    <div class="text-center pt-3">
                        <h3 class="h6 mb-2 mt-4 font-weight-bold text-uppercase">Hiking Boots</h3>
                        <span class="tx-15 ml-auto">
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star-half text-warning"></i>
                            <i class="ion ion-md-star-outline text-warning"></i>
                        </span>
                        <h4 class="h5 mb-0 mt-2 text-center font-weight-bold text-danger">$25 <span class="text-secondary font-weight-normal tx-13 ml-1 prev-price">$59</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-4  col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="pro-img-box">
                        <div class="d-flex product-sale">
                            <div class="badge bg-success">New</div>
                            <i class="mdi mdi-heart-outline ml-auto wishlist"></i>
                        </div>
                        <img class="w-100" src="{{URL::asset('assets/img/ecommerce/06.jpg')}}" alt="product-image">
                        <a href="#" class="adtocart"> <i class="las la-shopping-cart "></i>
                        </a>
                    </div>
                    <div class="text-center pt-3">
                        <h3 class="h6 mb-2 mt-4 font-weight-bold text-uppercase">college  bag</h3>
                        <span class="tx-15 ml-auto">
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star-half text-warning"></i>
                            <i class="ion ion-md-star-outline text-warning"></i>
                        </span>
                        <h4 class="h5 mb-0 mt-2 text-center font-weight-bold text-danger">$35 <span class="text-secondary font-weight-normal tx-13 ml-1 prev-price">$69</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-4  col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="pro-img-box">
                        <div class="d-flex product-sale">
                            <i class="mdi mdi-heart ml-auto wishlist text-danger"></i>
                        </div>
                        <img class="w-100" src="{{URL::asset('assets/img/ecommerce/04.jpg')}}" alt="product-image">
                        <a href="#" class="adtocart"> <i class="las la-shopping-cart"></i>
                        </a>
                    </div>
                    <div class="text-center pt-3">
                        <h3 class="h6 mb-2 mt-4 font-weight-bold text-uppercase">Headphones</h3>
                        <span class="tx-15 ml-auto">
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star-half text-warning"></i>
                            <i class="ion ion-md-star-outline text-warning"></i>
                        </span>
                        <h4 class="h5 mb-0 mt-2 text-center font-weight-bold text-danger">$46 <span class="text-secondary font-weight-normal tx-13 ml-1 prev-price">$89</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-4  col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="pro-img-box">
                        <div class="d-flex product-sale">
                            <i class="mdi mdi-heart-outline ml-auto wishlist"></i>
                        </div>
                        <img class="w-100" src="{{URL::asset('assets/img/ecommerce/05.jpg')}}" alt="product-image">
                        <a href="#" class="adtocart"> <i class="las la-shopping-cart "></i>
                        </a>
                    </div>
                    <div class="text-center pt-3">
                        <h3 class="h6 mb-2 mt-4 font-weight-bold text-uppercase">Camera lens</h3>
                        <span class="tx-15 ml-auto">
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star-half text-warning"></i>
                            <i class="ion ion-md-star-outline text-warning"></i>
                        </span>
                        <h4 class="h5 mb-0 mt-2 text-center font-weight-bold text-danger">$159 <span class="text-secondary font-weight-normal tx-13 ml-1 prev-price">$299</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-4  col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="pro-img-box">
                        <div class="d-flex product-sale">
                            <div class="badge bg-purple">New</div>
                            <i class="mdi mdi-heart ml-auto wishlist text-danger"></i>
                        </div>
                        <img class="w-100" src="{{URL::asset('assets/img/ecommerce/09.jpg')}}" alt="product-image">
                        <a href="#" class="adtocart"> <i class="las la-shopping-cart "></i>
                        </a>
                    </div>
                    <div class="text-center pt-3">
                        <h3 class="h6 mb-2 mt-4 font-weight-bold text-uppercase">Camera</h3>
                        <span class="tx-15 ml-auto">
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star-half text-warning"></i>
                            <i class="ion ion-md-star-outline text-warning"></i>
                        </span>
                        <h4 class="h5 mb-0 mt-2 text-center font-weight-bold text-danger">$129 <span class="text-secondary font-weight-normal tx-13 ml-1 prev-price">$189</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-4  col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="pro-img-box">
                        <div class="d-flex product-sale">
                            <i class="mdi mdi-heart-outline ml-auto wishlist"></i>
                        </div>
                        <img class="w-100" src="{{URL::asset('assets/img/ecommerce/11.jpg')}}" alt="product-image">
                        <a href="#" class="adtocart"> <i class="las la-shopping-cart "></i>
                        </a>
                    </div>
                    <div class="text-center pt-3">
                        <h3 class="h6 mb-2 mt-4 font-weight-bold text-uppercase">Handbag</h3>
                        <span class="tx-15 ml-auto">
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star-half text-warning"></i>
                            <i class="ion ion-md-star-outline text-warning"></i>
                        </span>
                        <h4 class="h5 mb-0 mt-2 text-center font-weight-bold text-danger">$19 <span class="text-secondary font-weight-normal tx-13 ml-1 prev-price">$39</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-4  col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="pro-img-box">
                        <div class="d-flex product-sale">
                            <div class="badge bg-info">New</div>
                            <i class="mdi mdi-heart ml-auto wishlist text-danger"></i>
                        </div>
                        <img class="w-100" src="{{URL::asset('assets/img/ecommerce/07.jpg')}}" alt="product-image">
                        <a href="#" class="adtocart"> <i class="las la-shopping-cart "></i>
                        </a>
                    </div>
                    <div class="text-center pt-3">
                        <h3 class="h6 mb-2 mt-4 font-weight-bold text-uppercase">Laptop</h3>
                        <span class="tx-15 ml-auto">
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star text-warning"></i>
                            <i class="ion ion-md-star-half text-warning"></i>
                            <i class="ion ion-md-star-outline text-warning"></i>
                        </span>
                        <h4 class="h5 mb-0 mt-2 text-center font-weight-bold text-danger">$89 <span class="text-secondary font-weight-normal tx-13 ml-1 prev-price">$120</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <ul class="pagination product-pagination mr-auto float-left">
            <li class="page-item page-prev disabled">
                <a class="page-link" href="#" tabindex="-1">Prev</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item page-next">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </div>
</div>
@endsection

@section('js')

@endsection