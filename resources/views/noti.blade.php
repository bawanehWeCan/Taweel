@extends('layouts.main')
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
                                <a href="#">{{ __('الاشعارات')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <!-- clean unescaped data is to avoid potential XSS risk -->
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
           

            <div class="row">
                <div class="col-md-12">
                    <div class="card sale-card" >

                        <div class="card-block text-center">

                            <form class="forms-sample" method="POST" action="{{url('sendnoti')}}">
                                @csrf

                                <div class="form-group">
                                    <input class="form-control" type="text" name="title" value="عنوان">
                                </div>

                                <div class="form-group">
                                    <textarea rows="10" class="form-control " name="content">محتوى الرساله</textarea>
                                </div>

                                <div class="form-group">
	                                <button type="submit" class="btn btn-primary btn-rounded">{{ __('ارسال')}}</button>
	                            </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

           

        </div>
	</div>
</div>

@endsection
