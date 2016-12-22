@extends('layouts.app')

@section('title', $guardian->name)

@section('styles')
     <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
     <link href="{{ asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('page-heading')
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $guardian->name . ' ' . $guardian->guardian_id }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('admin') }}">Home</a>
                </li>
                <li class="active">
                    <a href="{{ url('admin/guardians/') }}">Guardians</a>
                </li>
                <li class="active">
                    <a href="{{ url('#') }}">{{ $guardian->name }}</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
            <button type="button" class="btn btn-primary m-t-md" data-toggle="modal" data-target="#edit-student-info">
                Edit info
            </button>

        </div>
</div>
@endsection

@section('content')

@include('layouts.partials.guardian.profile')


 <div class="wrapper wrapper-content animated fadeInRight">

            <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>{{ $guardian->name }} -  Active Wards</h5>
                                    </div>
                                    <div class="ibox-content">


                                            <table class="table" >
                                                    <thead>
                                                    <tr>
                                                        <th>Reg. Number</th>
                                                        <th>Name</th>
                                                        <th>Sex</th>
                                                        <th>classroom</th>
                                                        <th>level</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                            @foreach($guardian->students->whereIn('status', ['active', 'promoting', 'repeating', 'promoted', 'repeated']) as $student)
                                                    <tr>
                                                        <td>{{ $student->admin_number }}</td>
                                                        <td>{{ $student->name }}</td>
                                                        <td>{{ $student->sex }}</td>
                                                        <td>{{ $student->classroom->name or "" }}</td>
                                                        <td>{{ $student->classroom->level->name or ""}}</td>
                                                        <td>{{ $student->status }}</td>
                                                    </tr>
                                            @endforeach

                                                </tbody>
                                            </table>

                                    </div>
                                </div>
                            </div>
                        </div>

            <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>{{ $guardian->name }} -  Graduated Wards</h5>
                                    </div>
                                    <div class="ibox-content">


                                            <table class="table" >
                                                    <thead>
                                                    <tr>
                                                        <th>Reg. Number</th>
                                                        <th>Name</th>
                                                        <th>Sex</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                            @foreach($guardian->students->where('status', 'graduated') as $student)
                                                    <tr>
                                                        <td>{{ $student->admin_number }}</td>
                                                        <td>{{ $student->name }}</td>
                                                        <td>{{ $student->sex }}</td>
                                                        <td>{{ $student->status }}</td>
                                                    </tr>
                                            @endforeach

                                                </tbody>
                                            </table>

                                    </div>
                                </div>
                            </div>
                        </div>

</div>



@endsection





@section('scripts')
    <!-- ChartJS-->
    <script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>
    <script>

        $(function () {

           function readURL(input) {
               if (input.files && input.files[0]) {
                   var reader = new FileReader();

                   reader.onload = function (e) {
                       $('#image_upload_preview').attr('src', e.target.result);
                   }

                   reader.readAsDataURL(input.files[0]);
               }
           }

           $("#inputFile").change(function () {
               readURL(this);
           });



        });

    </script>

@endsection