@extends('layouts.app')

@section('title', 'Upcoming Payments')

@section('styles')

@endsection

@section('content')

<div class="wrapper wrapper-content">
<div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       <h5 class="pull-left">Students yet to pay</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="text-center">{{ $students->count() }}</h1>
                        {{--<div class="pull-left font-bold text-success">{{ $total_male_students }} <i class="fa fa-male"></i></div>--}}
                        {{--<div class="pull-right font-bold text-success">{{ $total_female_students }} <i class="fa fa-female"></i></div>--}}
                    </div>
                </div>
            </div>

           <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       <h5 class="pull-left">Upcoming revenue</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="text-center">{{ 'N' . number_format($total_amount) }}</h1>
                        {{--<div class="pull-left font-bold text-success">{{ $total_male_teachers }} <i class="fa fa-male"></i></div>--}}
                        {{--<div class="pull-right font-bold text-success">{{ $total_female_teachers }} <i class="fa fa-female"></i></div>--}}
                    </div>
                </div>
            </div>

             <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       <h5 class="pull-left">Paid revenue</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="text-center">{{ $session ?  'N' . number_format(expected_term_payment($session->id, $term) - $total_amount) : 'N/A'}}</h1>
                        {{--<div class="pull-left font-bold text-success">{{ $total_male_teachers }} <i class="fa fa-male"></i></div>--}}
                        {{--<div class="pull-right font-bold text-success">{{ $total_female_teachers }} <i class="fa fa-female"></i></div>--}}
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       <h5 class="pull-left">Upcoming Percentage</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="text-center">{{ $session ? $total_amount * 100 / expected_term_payment($session->id, $term) . '%': 'N/A'}}</h1>
                        {{--<div class="pull-left font-bold text-success">{{ $total_male_teachers }} <i class="fa fa-male"></i></div>--}}
                        {{--<div class="pull-right font-bold text-success">{{ $total_female_teachers }} <i class="fa fa-female"></i></div>--}}
                    </div>
                </div>
            </div>

    </div>
</div>
                 
@endsection


@section('scripts')




<script>




        toastr.options = {
          "closeButton": true,
          "debug": false,
          "progressBar": true,
          "preventDuplicates": false,
          "positionClass": "toast-top-right",
          "onclick": null,
          "showDuration": "400",
          "hideDuration": "1000",
          "timeOut": "7000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        };

        toastr.success('{{ 'Welcome back admin' }}');
</script>

@endsection