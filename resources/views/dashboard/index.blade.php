@extends('layouts.master')

@section('css')
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Hi, welcome back! |</h4>
                <span class="text-muted mt-1 tx-13 mr-3 mb-0">&nbsp;Dashboard</span>
            </div>

        </div>
        <div class="d-flex my-xl-auto right-content">
            <div style="margin-right: 20px">
                <label class="tx-13 text-secondary">Clients</label>
                <h5  style="margin-top: -10px">{{ $totalClients }}</h5>
            </div>
            <div>
                <label class="tx-13 text-secondary">Rooms</label>
                <h5  style="margin-top: -10px">{{ $totalRooms }}</h5>
            </div>
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
    </div>
    <!-- breadcrumb -->
@endsection

@php
    $statusColors = [
        'available' => 'bg-success-gradient',
        'reserved' => 'bg-warning-gradient',
        'maintenance' => 'bg-danger-gradient',
        'occupied' => 'bg-secondary-gradient',
    ];
    $statusIcons = [
        'available' => 'icon-check',
        'reserved' => 'icon-calendar',
        'maintenance' => 'icon-wrench',
        'occupied' => 'icon-close',
    ];

    $typeColors = [
        'single' => 'bg-primary-gradient',
        'double' => 'bg-info-gradient',
        'suite' => 'bg-purple-gradient',
    ];
    $typeIcons = [
        'single' => 'icon-user',
        'double' => 'icon-users',
        'suite' => 'icon-diamond',
    ];
@endphp

@section('content')
    <!-- row -->
    <div class="row"> 
        <!-- Room Statuses -->
        @foreach($statusTotals as $status => $total)
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
    
        <!-- Room Types -->
        @foreach($typeTotals as $type => $total)
            <div class="col-lg-3 col-md-6">
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
@endsection

@section('js')

<!--Internal Counters -->
<script src="{{URL::asset('assets/plugins/counters/waypoints.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/counters/counterup.min.js')}}"></script>
<!--Internal Time Counter -->
<script src="{{URL::asset('assets/plugins/counters/jquery.missofis-countdown.js')}}"></script>
<script src="{{URL::asset('assets/plugins/counters/counter.js')}}"></script>

@endsection