@extends('layouts.app')

@section('title', 'Guarrdian')

@section('styles')
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('page-heading')
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Welcome, {{ $guardian->title . ' ' . $guardian->name }}</h2>
            <ol class="breadcrumb">
                <li class="active">
                    <a href="{{ url('guardian') }}">Dashboard</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
 </div>
@endsection

@section('content')
<div class="wrapper wrapper-content">


<div class="row">
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right"></span>
                    <h5>Wards</h5>
                </div>
                <div class="ibox-content">

                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="no-margins text-center"> {{ $guardian->students()->where('sex', '=', 'Female')->count() }} <i class="fa fa-female"></i></h1>
                        </div>
                        <div class="col-md-6">
                            <h1 class="no-margins text-center">{{ $guardian->students()->where('sex', '=', 'Male')->count() }} <i class="fa fa-male"></i></h1>
                        </div>

                    </div>

                    <hr>

                    <a href="{{ url('guardian/wards') }}" class="btn btn-block btn-white" target="_blank" title="View wards">View</a>


                </div>
            </div>
        </div>

        <div class="col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-primary pull-right"></span>
                            <h5>Outstanding Payments</h5>
                        </div>
                        <div class="ibox-content">

                        <h1 class="no-margins text-center"> #406,42</h1>

                        <hr>

                        <a href="{{ url('guardian/payments') }}" class="btn btn-block btn-primary">Pay now</a>


                        </div>
                    </div>
                </div>


        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Notifications</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content ibox-heading">
                    <h3><i class="fa fa-bell"></i> New notifications</h3>
                    <small><i class="fa fa-tim"></i> You have 10 new notifications.</small>
                    <hr class="m-t-sm m-b-sm">
                    <a href="guardian/notifications" class="btn btn-block btn-info">View</a>
                </div>
            </div>
        </div>



</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Current Active Wards({{$guardian->students()->whereIn('status',  ['active', 'promoting', 'promoted', 'repeating', 'repeated', 'graduating'] )->count() }})</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                 <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover .teacher-classroom-dataTables" >
                    <thead>
                    <tr>
                        <th>Admin number</th>
                        <th>Wards Name</th>
                        <th>Sex</th>
                        <th>Class</th>
                        <th>House</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($guardian->students()->where('status', '=', 'active')->get() as $student)

                    <tr class="gradeA">
                        <td>{{ $student->admin_number }}</td>
                        <td> <a href="{{ url('guardian/wards/' . $student->id) }}" target="_blank" title="View {{ $student->name }}">{{ $student->name }}</a></td>
                        <td>{{ $student->sex }}</td>
                        <td>{{ $student->classroom->name or "" }}</td>
                        <td>{{ $student->house->name or "" }}</td>

                    </tr>
                   @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Admin number</th>
                        <th>Wards Name</th>
                        <th>Sex</th>
                        <th>Class</th>
                        <th>House</th>
                    </tr>
                    </tfoot>
                    </table>
                        </div>
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


            $('.teacher-classroom-dataTables').DataTable({

                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'students'},
                    {extend: 'pdf', title: 'students'},

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