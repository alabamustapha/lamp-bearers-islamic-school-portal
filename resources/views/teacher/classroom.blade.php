@extends('layouts.app')

@section('title', $classroom->name)

@section('styles')

@endsection

@section('page-heading')
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $classroom->name }} Students</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('teacher') }}">Home</a>
                </li>
                <li class="active">
                    <a href="{{ url('admin/classrooms/' . $classroom->id) }}">{{ $classroom->name }}</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
            <button type="button" class="btn btn-primary m-t-md" data-toggle="modal" data-target="#edit-student-info">
                                Update classroom
                            </button>
                             <div class="modal inmodal" id="edit-student-info" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content animated bounceInRight">


                                            <form method="POST" class="form" enctype="multipart/form-data" action="{{ url('teacher/classrooms/' . $classroom->id . '/upload_classroom_comments_excel') }}">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                                                 <h4 class="modal-title">{{ $classroom->level->name . ' ' . $classroom->name }}</h4>
                                                 <h3 class="modal-title">Comments and Psychomotor</h3>

                                            </div>

                                            <div class="modal-body">



                                                {{ csrf_field() }}
                                                 <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">
                                                 <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                                 <input type="hidden" name="term" value="{{ $session ? $session->term() : null }}">
                                                 <input type="hidden" name="session_id" value="{{ $session ? $session->id : 0 }}">


                                              @if (count($errors) > 0)
                                                 <!-- Form Error List -->
                                                 <div class="alert alert-danger">
                                                     <strong>Whoops! Something went wrong!</strong>
                                                     <ul>
                                                         @foreach ($errors->all() as $error)
                                                             <li>{{ $error }}</li>
                                                         @endforeach
                                                     </ul>
                                                 </div>
                                             @endif

                                            <div class="row">
                                                <div class="col-md-12">


                                                    <div class="row">

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="control-label" for="comments_psychomotor">Select file</label>
                                                            <input type="file" name="comments_physchomotor" id="comments_psychomotor" class="form-control" required>
                                                        </div>
                                                     </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="control-label">File Type </label>
                                                                <select class="form-control" name="type" required>
                                                                    <option></option>
                                                                    <option value="comments"  {{ old('type') == 'comments' ? 'selected' : '' }}>Comments</option>
                                                                    <option value="psychomotors" {{ old('type') == 'psychomotor' ? 'selected' : '' }}>Psychomotors</option>
                                                                    <option value="attendance" {{ old('type') == 'attendance' ? 'selected' : '' }}>Attendance</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Upload classroom</button>
                                            </div>

                                     </form>
                                     </div>
                                </div>
                            </div>
        </div>
 </div>
@endsection

@section('content')
<div class="wrapper wrapper-content">
@if(isset($session) && !is_null($session) && ($session->term() == 'third' || $session->third_term == 'closed') && $students->count() > 0)
<div class="row m-b-md">
    <div class="col-lg-6">
          @if($classroom->level->rank == $highest_level)

                <form action="{{ url('teacher/classrooms/' . $classroom->id . '/graduate') }}" method="post" id="graduate">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                     <div class="input-group m-b"><span class="input-group-btn">

                          <button  type="submit" class="btn btn-primary btn-block" id="promote">Add all students to graduate list</button></span>

                      </div>

                </form>

          @else

              <form action="{{ url('teacher/classrooms/' . $classroom->id . '/promote') }}" method="post" id="promote">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                     <div class="input-group m-b"><span class="input-group-btn">
                          <button  type="submit" class="btn btn-primary btn-block" id="promote">Promote all to</button></span>

                          <select class="form-control" name="promoted_to_classroom_id">
                             @foreach($classrooms as $promoted_to_classroom)
                                 @if($classroom->level->rank < $promoted_to_classroom->level->rank)
                                     <option value="{{ $promoted_to_classroom->id }}">{{ $promoted_to_classroom->name }}</option>
                                 @endif
                             @endforeach
                          </select>
                      </div>

                </form>

          @endif
        </div>

    <div class="col-lg-6">
        <form action="{{ url('teacher/classrooms/' . $classroom->id . '/repeat') }}" method="post" id="repeat">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
                <div class="input-group m-b"><span class="input-group-btn">
                     <button  type="submit" class="btn btn-warning btn-block" id="repeat-all">Repeat to</button></span>
                     <input type="hidden" name="repeated_to_classroom_id" value="{{ $classroom->id }}">
                 </div>
        </form>
    </div>
</div>


@endif

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>List of all students in {{ $classroom->name }}</h5>
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
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                    <tr>
                                        <th>Admin NO.</th>
                                        <th>Name </th>
                                        <th>Sex </th>
                                        <th>House</th>
                                        <th>Parent</th>
                                        @if(isset($session) && !is_null($session) && ($session->term() == 'third' || $session->third_term == 'closed'))
                                        <th>Overall (%)</th>
                                        <th>Promote</th>
                                        <th>Repeat</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($students as $student)
                                    <tr class="gradeA">
                                        <td>{{ $student->admin_number }}</td>
                                        <td><a class="" href="{{ url('teacher/classrooms/' .  $classroom->id  . '/students/' . $student->id ) }}" title="{{ 'View ' . $student->name . ' profile' }}">{{ $student->name }}</a></td>
                                        <td>{{ $student->sex }}</td>
                                        <td>{{ $student->house->name }}</td>
                                        <td>{{ $student->guardian->name or 'N/A' }}</td>

                                        @if(isset($session) && !is_null($session) && ($session->term() == 'third' || $session->third_term == 'closed'))
                                        <td></td>
                                        <td>
                                            @if($classroom->level->rank == $highest_level)

                                                <form action="{{ url('teacher/classrooms/' . $classroom->id  . '/students/'. $student->id .  '/graduate') }}" method="post" id="graduate">
                                                {{ csrf_field() }}
                                                {{ method_field('PUT') }}
                                                     <div class="input-group m-b"><span class="input-group-btn">

                                                          <button  type="submit" class="btn btn-primary btn-block" id="promote">Add to graduate list</button></span>

                                                      </div>

                                                </form>

                                          @else
                                            <form action="{{ url('teacher/classrooms/' . $classroom->id . '/students/'. $student->id .  '/promote') }}" method="post" id="repeat">
                                            {{ csrf_field() }}
                                            {{ method_field('PUT') }}
                                                    <div class="input-group m-b"><span class="input-group-btn">
                                                         <button  type="submit" class="btn btn-primary btn-block" id="repeat-all">Promote to</button></span>
                                                         <select class="form-control" name="promoted_to_classroom_id">
                                                          @foreach($classrooms as $promoted_to_classroom)
                                                              @if($classroom->level->rank < $promoted_to_classroom->level->rank)
                                                                  <option value="{{ $promoted_to_classroom->id }}">{{ $promoted_to_classroom->name }}</option>
                                                              @endif
                                                          @endforeach
                                                         </select>
                                                     </div>
                                            </form>
                                            @endif
                                        </td>
                                        <td>
                                             <form action="{{ url('teacher/classrooms/' . $classroom->id . '/students/'. $student->id .  '/repeat') }}" method="post" id="repeat">
                                                {{ csrf_field() }}
                                                {{ method_field('PUT') }}
                                                        <div class="input-group m-b"><span class="input-group-btn">
                                                             <button  type="submit" class="btn btn-warning btn-block" id="repeat-all">Repeat class</button></span>
                                                             <input type="hidden" name="repeated_to_classroom_id" value="{{ $classroom->id }}">
                                                         </div>
                                                </form>
                                        </td>
                                        @endif
                                    </tr>
                                   @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Admin NO.</th>
                                        <th>Name </th>
                                        <th>Sex </th>
                                        <th>House</th>
                                        <th>Parent</th>
                                        @if(isset($session) && !is_null($session) && ($session->term() == 'third' || $session->third_term == 'closed'))
                                        <th>Overall (%)</th>
                                        <th>Promote</th>
                                        <th>Repeat</th>
                                        @endif
                                    </tr>
                                    </tfoot>
                                    </table>
                                        </div>
            </div>
        </div>
    </div>

</div>

@if(isset($session) && !is_null($session) && ($session->term() == 'third' || $session->third_term == 'closed') && $promoted_students->count() > 0 && $classroom->level->rank != 7)


<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>List of all students to be promoted to {{ $classroom->name }}</h5>
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
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                    <tr>
                                        <th>Admin NO.</th>
                                        <th>Name </th>
                                        <th>Sex </th>
                                        <th>House</th>
                                        <th>Parent</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($promoted_students as $student)
                                    <tr class="gradeA">
                                        <td>{{ $student->admin_number }}</td>
                                        <td><a class="" href="{{ url('teacher/classrooms/' .  $classroom->id  . '/students/' . $student->id ) }}" title="{{ 'View ' . $student->name . ' profile' }}">{{ $student->name }}</a></td>
                                        <td>{{ $student->sex }}</td>
                                        <td>{{ $student->house->name }}</td>
                                        <td>{{ $student->guardian->name }}</td>

                                    </tr>
                                   @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Admin NO.</th>
                                        <th>Name </th>
                                        <th>Sex </th>
                                        <th>House</th>
                                        <th>Parent</th>
                                    </tr>
                                    </tfoot>
                                    </table>
                                        </div>
            </div>
        </div>
    </div>

</div>


@endif


@if(isset($session) && !is_null($session) && ($session->term() == 'third' || $session->third_term == 'closed') && $promoting_students->count() > 0)


<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>List of all students to be promoted</h5>
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
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                    <tr>
                                        <th>Admin NO.</th>
                                        <th>Name </th>
                                        <th>Sex </th>
                                        <th>House</th>
                                        <th>Parent</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($promoting_students as $student)
                                    <tr class="gradeA">
                                        <td>{{ $student->admin_number }}</td>
                                        <td><a class="" href="{{ url('teacher/classrooms/' .  $classroom->id  . '/students/' . $student->id ) }}" title="{{ 'View ' . $student->name . ' profile' }}">{{ $student->name }}</a></td>
                                        <td>{{ $student->sex }}</td>
                                        <td>{{ $student->house->name }}</td>
                                        <td>{{ $student->guardian->name }}</td>

                                    </tr>
                                   @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Admin NO.</th>
                                        <th>Name </th>
                                        <th>Sex </th>
                                        <th>House</th>
                                        <th>Parent</th>
                                    </tr>
                                    </tfoot>
                                    </table>
                                        </div>
            </div>
        </div>
    </div>

</div>


@endif

@if(isset($session) && !is_null($session) && ($session->term() == 'third' || $session->third_term == 'closed') && $repeating_students->count() > 0)


<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>List of all students to be repeated</h5>
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
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                    <tr>
                                        <th>Admin NO.</th>
                                        <th>Name </th>
                                        <th>Sex </th>
                                        <th>House</th>
                                        <th>Parent</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($repeating_students as $student)
                                    <tr class="gradeA">
                                        <td>{{ $student->admin_number }}</td>
                                        <td><a class="" href="{{ url('teacher/classrooms/' .  $classroom->id  . '/students/' . $student->id ) }}" title="{{ 'View ' . $student->name . ' profile' }}">{{ $student->name }}</a></td>
                                        <td>{{ $student->sex }}</td>
                                        <td>{{ $student->house->name }}</td>
                                        <td>{{ $student->guardian->name }}</td>

                                    </tr>
                                   @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Admin NO.</th>
                                        <th>Name </th>
                                        <th>Sex </th>
                                        <th>House</th>
                                        <th>Parent</th>
                                    </tr>
                                    </tfoot>
                                    </table>
                                        </div>
            </div>
        </div>
    </div>

</div>


@endif






</div>
@endsection



@section('scripts')

<script src=" {{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
        <script>
                 $(document).ready(function(){

            $('.dataTables-example').DataTable({
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

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

            /* Init DataTables */
            var oTable = $('#editable').DataTable();
            });


         </script>
@endsection