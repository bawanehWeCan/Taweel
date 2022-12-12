@extends('layouts.main') 
@section('title', 'Users')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    @endpush

    
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-users bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('الاحلام')}}</h5>
                        </div>
                    </div>
                </div>
             
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-body">
                        <table id="dreams_table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('الاسم')}}</th>
                                    <th>{{ __('التصنيف')}}</th>
                                    <th>{{ __('عدد المشاهدات')}}</th>
                                    <th>{{ __('مميز')}}</th>
                                    <th>{{ __('حلم مغلق')}}</th>
                                    <th>{{ __('يوجد رد جديد')}}</th>
                                    <th>{{ __('المؤول')}}</th>
                                    <th>{{ __('')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <!--server side users table script-->
    <script src="{{ asset('js/custom.js?v=1') }}"></script>
    @endpush
@endsection
