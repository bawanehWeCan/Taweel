@extends('layouts.main')
@section('title', $c->name.' - Edit Role')
@section('content')

<div class="container-fluid">
    <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-award bg-blue"></i>
                        <div class="d-inline">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('التصنيف')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <!-- clean unescaped data is to avoid potential XSS risk -->
                                {{ clean($c->name, 'titles')}}
                            </li>

                        </ol>
                    </nav>
                </div>
            </div>
        </div>
	<div class="row clearfix">
        <!-- start message area-->
        @include('include.message')
        <!-- end message area-->
		<div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>{{ __('تعديل التصنيف')}}</h3></div>
                <div class="card-body">
                    <form class="forms-sample" method="POST" action="{{url('cat/update')}}">
                    	@csrf
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="role">{{ __('الاسم')}}<span class="text-red">*</span></label>
                                    <input type="text" class="form-control is-valid" id="role" name="name" value="{{ clean($c->name, 'titles')}}" placeholder="Insert Role">
                                    <input type="hidden" name="id" value="{{$c->id}}" required>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
	</div>
</div>

@endsection
