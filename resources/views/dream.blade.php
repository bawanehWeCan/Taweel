@extends('layouts.main')
@section('title', $dream->name.' - Edit Role')
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
                                <a href="#">{{ __('الاحلام')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <!-- clean unescaped data is to avoid potential XSS risk -->
                                {{ clean($dream->name, 'titles')}}
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
                <div class="card-header"><h3>{{ $dream->name }}</h3></div>
                <div class="card-body">
                    	
                        <div class="row">
                            <div class="col-sm-5">
                                الاسم :
                            </div>
                            <div class="col-md-5">
                                {{ $dream->name }}
                            </div>
                            
                        </div>


                        <div class="row">
                            <div class="col-sm-5">
                                التصنيف :
                            </div>
                            <div class="col-md-5">
                                {{ $dream->cat->name }}
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                المشاهدات :
                            </div>
                            <div class="col-md-5">
                                {{ $dream->views }}
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                العمر :
                            </div>
                            <div class="col-md-5">
                                {{ $dream->age }}
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                الجنس :
                            </div>
                            <div class="col-md-5">
                                {{ $dream->sex }}
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                الحاله الاجتماعيه :
                            </div>
                            <div class="col-md-5">
                                {{ $dream->social_status }}
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                الحاله الصحية :
                            </div>
                            <div class="col-md-5">
                                {{ $dream->health_status }}
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                اطفال :
                            </div>
                            <div class="col-md-5">
                                {{ $dream->kids }}
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                ابناء :
                            </div>
                            <div class="col-md-5">
                                {{ $dream->parents }}
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                اخوه و اخوات :
                            </div>
                            <div class="col-md-5">
                                {{ $dream->brothers }}
                            </div>
                            
                        </div>


                        <div class="row">
                            <div class="col-sm-5">
                                المحتوى
                            </div>
                            <div class="col-md-5">
                                {{ $dream->content }}
                            </div>
                            
                        </div>
                            <form class="forms-sample" method="POST" action="{{route('changecat')}}">
                        @csrf
                        <div style="height:40px"></div>
                        <h3>اختر التصنيف</h3>

                        <div class="row">
                                <div class="col-sm-5">
                                <select class="form-control" name="category_id">
                                        @foreach(  $cats as $cat )
                                            <option @if( $dream->category_id == $cat->id ) selected @endif value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                </select>
                                </div>
                                <div class="col-md-5">
                                    <input type="hidden" name="dream_id" value="{{ $dream->id }}">
                                    <div class="form-group">
                                            <input type="submit" class="btn btn-primary btn-rounded" value="{{ __('تحديد')}}" />
                                    </div>
                                </div>
                                
                        </div>

                       


                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card sale-card" >

                        <div class="card-block text-center">

                            <form class="forms-sample" method="POST" action="{{url('addreplay')}}">
                                @csrf
                                <div class="form-group">
                                <textarea rows="10" class="form-control is-valid" name="content">بسم الله والصلاة والسلام على رسول الله 
الرؤى جند من جنود الله ، وآية من آيات الله ، أحيانا تكون تحذير ،وأحيانا تكون بشرى وبشارة ،وأحيانا تكون تثبيت وزيادة يقين .
والاحلام منها ما  يكون من الشيطان  ليحزن الرائي ويخوفه ، ومنها ما يكون حديث نفس 


ونهاية فاعلم أن الرؤيا ان شاء الله وقعت وان لم يشأ لم تقع. 
وأن بعض الرؤى تحققت بعد ٤٠ عام .
فلا يستعجل أحدكم بعدم وقوع الرؤيا ، وكلها بيد الله سبحانه. 
</textarea>
                                <div class="form-check">
                                <input class="form-check-input" name="status" type="checkbox" value="yes" id="flexCheckDisabled"  />
                                <label class="form-check-label" for="flexCheckDisabled">تعليم ك مفسر</label>
                                </div>
                                </div>
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="dream_id" value="{{ $dream->id }}">
                                <div class="form-group">
	                                	<button type="submit" class="btn btn-primary btn-rounded">{{ __('ارسال')}}</button>
	                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">

                    @foreach ( $dream->replays as $replay )

                        <div class="card sale-card" style="width:70%;float:{{ $replay->side }}">
                            <div class="card-header" >
                                <h3>{{ $replay->user->name }}</h3>
                            </div>
                            <div class="card-block text-center">
                                {!! $replay->content !!}
                            </div>
                        </div>
                        <div style="clear:both"></div>
                        
                    @endforeach
                    
                </div>
            </div>

        </div>
	</div>
</div>

@endsection
