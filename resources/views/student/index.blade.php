@extends('layouts.app')

@section('title', 'Students')

@section('styles')
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('page-heading')
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Current Active School Students</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('admin') }}">Home</a>
                </li>
                <li class="active">
                    <a href="#">All students currently in school</a>
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
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Searchable list of students</h5>
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
                                        <table class="table table-striped table-bordered table-hover students-dataTables" >
                                        <thead>
                                        <tr>
                                            <th>Admin Number</th>
                                            <th>Name</th>
                                            <th>Sex</th>
                                            <th>Class</th>
                                            <th>House</th>
                                            <th>Parent</th>
                                            {{--<th>Action</th>--}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($students as $student)

                                        <tr class="">
                                            <td>
                                                {{ $student->admin_number }}
                                            </td>
                                            <td>
                                                <a class="link-info" href="{{ url('admin/students/' . $student->id) }}" target="_blank" title="{{ "View" . ' ' . $student->name . ' details' }}">{{ $student->name }}</a>
                                            </td>
                                            <td>
                                                {{ $student->sex }}
                                            </td>
                                            <td>
                                                @if(isset($student->classroom) && !is_null($student->classroom))
                                                <a class="link-info" href="{{ url('admin/classrooms/' . $student->classroom->id) }}" target="_blank" title="{{ "View" . ' ' . $student->classroom->name . ' classroom' }}">{{ $student->classroom->name }}</a>
                                                @else
                                                {{ $student->status }}
                                                @endif
                                            </td>
                                            <td>
                                                <a class="link-info" href="{{ url('admin/houses/' . $student->house->id) }}" target="_blank" title="{{ "View" . ' ' . $student->house->name . ' sport house details' }}">{{ $student->house->name }}</a>
                                            </td>
                                            <td>
                                                @if($student->guardian)
                                                    <a class="link-info" href="{{ url('admin/guardians/' . $student->guardian->id) }}" target="_blank" title="{{ "View" . ' ' . $student->name . ' guardian details' }}">{{ $student->guardian->name or 'N/A'}}</a>
                                                @endif
                                            </td>
                                            {{--<td class="center">--}}
                                                {{--<div class="btn-group">--}}
                                                      {{--<a type="button" class="btn btn-outline btn-xs btn-primary" href="{{ url('admin/students/' . $student->id) }}" target="_blank">View</a>--}}
                                                      {{--<a type="button" class="btn btn-outline btn-xs btn-primary" href="{{ url('admin/students/' . $student->id . '/edit') }}" target="_blank">Edit</a>--}}
                                                {{--</div>--}}
                                            {{--</td>--}}

                                        </tr>
                                       @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <tr>
                                                <th>Admin Number</th>
                                                <th>Name</th>
                                                <th>Sex</th>
                                                <th>Class</th>
                                                <th>House</th>
                                                <th>Parent</th>
                                                {{--<th>Action</th>--}}
                                            </tr>
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


            $('.students-dataTables').DataTable({

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