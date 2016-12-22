@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')

@endsection

@section('content')

<div class="lock-word animated fadeInDown">
    <span class="first-word">LOCKED</span><span>SCREEN</span>
</div>
    <div class="middle-box text-center lockscreen animated fadeInDown">
        <div>
            <div class="m-b-md">
            {{--<img alt="image" class="img-circle circle-border" src="{{ asset('img/logo.jpg') }}">--}}
            </div>
            <p>Your are in lock screen.You need to enter a valid licence key to continue.</p>
            <form class="m-t" role="form" action="{{ url('add_licence') }}" method="post">
            {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" name="licence_key" class="form-control" min="16" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width">Validate Licence</button>
            </form>
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