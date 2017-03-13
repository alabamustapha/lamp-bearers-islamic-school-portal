@extends('layouts.app')

@section('title', 'Upcoming Payments')

@section('styles')
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
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
                        <h1 class="text-center">{{ $students ? $students->count() : 'N/A' }}</h1>
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

<div class="row ">
    <div class="col-lg-12">

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Students with upcoming term payments</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <table class="table table-striped table-bordered table-hover students-dataTables">
                    <thead>
                        <tr>
                            <th>Admin. Number</th>
                            <th>Name</th>
                            <th>Classroom</th>
                            <th>Amount</th>
                            <th>Guardian name</th>
                            <th>Guardian Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                   <tbody>

                    @if($students)
                       @foreach($students as $student)
                       <tr>
                           <td>{{ $student->admin_number }}</td>
                           <td>{{ $student->name }}</td>
                           <td>{{ $student->classroom->name }}</td>
                           @if($term == 'first')
                           <td>{{ number_format($student->classroom->first_term_charges) }}</td>
                           @elseif($term == 'second')
                           <td>{{ number_format($student->classroom->second_term_charges) }}</td>
                           @elseif($term == 'third')
                           <td>{{ number_format($student->classroom->third_term_charges) }}</td>
                           @endif
                           <td>{{ $student->guardian->name or 'N/A'}}</td>
                           <td>{{ $student->guardian->phone or 'N/A' }}</td>
                           <td><button>Pay</button></td>
                       </tr>
                       @endforeach
                    @endif

                   </tbody>

            </table>
        </div>
      </div>
    </div>
</div>
</div>
                 
@endsection


@section('scripts')
<script src=" {{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>

<script>
 $(document).ready(function(){


            $('.students-dataTables').DataTable({

                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Debtors'},
                    {extend: 'pdf', title: 'Debtors'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');

                    }
                    }
                ]

            });

})


</script>
@endsection