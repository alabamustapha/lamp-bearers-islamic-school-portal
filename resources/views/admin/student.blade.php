@extends('layouts.app')

@section('title', $student->name)

@section('styles')
     <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
     <link href="{{ asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('page-heading')
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $student->name . ' ' . $student->admin_number }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('admin') }}">Home</a>
                </li>
                <li class="active">
                    <a href="{{ url('admin/students/') }}">Students</a>
                </li>
                <li class="active">
                    <a href="{{ url('#') }}">{{ $student->name }}</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
            <button type="button" class="btn btn-primary m-t-md" data-toggle="modal" data-target="#edit-student-info">
                Edit info
            </button>
             <div class="modal inmodal" id="edit-student-info" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated bounceInRight">

                            <form method="POST" class="form" enctype="multipart/form-data" action="{{ url('admin/students/' . $student->id) }}">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                                 <img id="image_upload_preview" data-holder-rendered="true" src="{{ has_image($student) ? asset('storage/' . $student->image) : asset('storage/images/' . strtolower($student->sex) . '.png') }}"  class="img-circle circle-border m-b-md" alt="student passport" width="100px">


                                 <h4 class="modal-title">{{ $student->name }}</h4>


                                <div class="fileinput fileinput-new form-group m-t-sm m-b-xs" data-provides="fileinput">
                                    <span class="btn btn-default btn-file"><span class="fileinput-new">Select a new passport</span><span class="fileinput-exists">Change</span><input type="file" name="image" id="inputFile"></span>
                                    <span class="fileinput-filename"></span>
                                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                </div>


                            </div>

                            <div class="modal-body">



                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

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
                                        <div class="col-lg-6 col-md-6">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Surname *</label>

                                                 <input placeholder="surname" class="form-control input-lg" type="text" name="surname" value="{{ trim(explode(' ', $student->name)[0]) }}" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">First name *</label>
                                                <input placeholder="first name" class="form-control input-lg" type="text" name="first_name" value="{{ trim(explode(' ', $student->name)[1]) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Middle name *</label>
                                                <input placeholder="middle name" class="form-control input-lg" type="text" name="middle_name" value="{{ isset(explode(' ', $student->name)[2]) ? trim(explode(' ', $student->name)[2]) : null }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Sex *</label>
                                                <select class="form-control input-lg" name="sex" required="">
                                                    <option></option>
                                                    <option value="Male" {{ $student->sex == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Female" {{ $student->sex == 'Female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="font-normal control-label">DOB *</label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="dob" class="form-control input-lg" name="dob" value="{{ $student->dob->format('m/d/Y') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Phone</label>
                                                <div class="input-group">
                                                   <span class="input-group-addon"><i class="fa fa-phone"></i></span><input type="tel" placeholder="phone" class="form-control input-lg" name="phone"  value="{{ $student->phone }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                           <div class="row">
                               <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                          <div class="input-group">
                                              <span class="input-group-addon"><i class="fa fa-at"></i></span><input type="email" placeholder="email" name="email" class="form-control input-lg" value="{{ $student->email }}">
                                          </div>
                                    </div>
                                </div>
                                   <div class="col-lg-4">
                                       <div class="form-group">
                                           <label class="control-label">Class *</label>
                                           <select class="form-control input-lg" name="classroom_id" required="">
                                           <option>--select--</option>
                                           @foreach($classrooms as $classroom)
                                               <option value="{{ $classroom->id }}" {{ $student->classroom_id == $classroom->id ? 'selected' : ''}}>{{ $classroom->name }}</option>
                                           @endforeach
                                           </select>
                                       </div>
                                   </div>

                                   <div class="col-lg-4">
                                       <div class="form-group">
                                           <label class="control-label">Sport house *</label>
                                           <select class="form-control input-lg" name="house_id" required="">
                                               <option>--select--</option>
                                               @foreach($houses as $house)
                                               <option value="{{ $house->id }}" {{ $student->house_id == $house->id ? 'selected' : ''}}>{{ $house->name }}</option>
                                               @endforeach
                                           </select>
                                       </div>
                                   </div>

                               </div>
                               <div class="row">
                                   <div class="col-lg-6">
                                      <div class="form-group">
                                          <label class="control-label">Guardian phone</label>
                                          <input type="text" id="guardian_phone" class="form-control input-lg" name="guardian_phone" value="{{ $student->guardian->phone or old('guardian_phone') }}">
                                      </div>
                                  </div>
                                   <div class="col-lg-6">
                                      <div class="form-group">
                                          <label class="control-label">Guardian </label>
                                          <select class="form-control input-lg" name="guardian_id" readonly="readonly">
                                                @if($student->guardian != null)
                                                    <option value="{{ $student->guardian->id }}">{{ $student->guardian->name }}</option>
                                                @endif
                                          </select>
                                      </div>
                                  </div>
                               </div>
                               <div class="row">
                                <div class="col-lg-6">
                                   <div class="form-group">
                                       <label class="control-label">Address *</label>
                                       <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-home"></i></span><input type="text" placeholder="address" class="form-control input-lg" name="address" required value="{{ $student->address }}">
                                       </div>
                                   </div>
                               </div>
                                <div class="col-lg-6">
                                       <div class="form-group">
                                           <label class="control-label">Status *</label>
                                           <select class="form-control input-lg" name="status">
                                               <option value="">--select-</option>
                                               <option value="active" {{ $student->status == 'active' ? 'selected' : ''}}>Active</option>
                                               <option value="left" {{ $student->status == 'left' ? 'selected' : ''}}>Left</option>
                                               <option value="graduated" {{ $student->status == 'graduated' ? 'selected' : ''}}>Graduated</option>
                                               <option value="dismissed" {{ $student->status == 'dismissed' ? 'selected' : ''}}>Dismissed</option>
                                               <option value="deactivated" {{ $student->status == 'deactivated' ? 'selected' : ''}}>Deactivated</option>
                                           </select>
                                       </div>
                                   </div>

                               </div>
                           <div class="row">
                               <div class="col-lg-12">
                                   <div class="form-group">
                                       <label class="control-label">Comment</label>
                                       <textarea class="form-control" name="comment" placeholder="note about students">{{ $student->comment }}</textarea>
                                   </div>
                               </div>
                           </div>



                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
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

@if(isset($session) && !is_null($session) && ($session->term() == 'third' || $session->third_term == 'closed'))
{{--<div class="row m-b-md">--}}
    {{--<div class="col-lg-6">--}}
            {{--<form action="{{ url('admin/students/' . $student->id . '/promote') }}" method="post" id="promote">--}}
            {{--{{ csrf_field() }}--}}
                 {{--<div class="input-group m-b"><span class="input-group-btn">--}}
                      {{--<button  type="submit" class="btn btn-primary btn-block" id="promote">Promote to</button></span>--}}

                      {{--<select class="form-control" name="promoted_to_classroom_id">--}}
                         {{--@foreach($classrooms as $promoted_to_classroom)--}}
                             {{--@if($student->classroom->level->rank < $promoted_to_classroom->level->rank)--}}
                                 {{--<option value="{{ $promoted_to_classroom->id }}">{{ $promoted_to_classroom->name }}</option>--}}
                             {{--@endif--}}
                         {{--@endforeach--}}
                      {{--</select>--}}
                  {{--</div>--}}

            {{--</form>--}}
        {{--</div>--}}

    {{--<div class="col-lg-6">--}}
        {{--<form action="{{ url('admin/students/' . $student->id . '/repeat') }}" method="post" id="repeat">--}}
        {{--{!! csrf_field() !!}--}}
                {{--<div class="input-group m-b"><span class="input-group-btn">--}}
                     {{--<button  type="submit" class="btn btn-warning btn-block" id="repeat-all">Repeat to</button></span>--}}
                     {{--<select class="form-control" name="repeated_to_classroom_id">--}}
                     {{--@foreach($classrooms as $repeated_to_class)--}}
                         {{--@if($student->classroom->level->rank >= $repeated_to_class->level->rank )--}}
                             {{--<option value="{{ $repeated_to_class->id }}">{{ $repeated_to_class->name }}</option>--}}
                         {{--@endif--}}
                     {{--@endforeach--}}
                     {{--</select>--}}
                 {{--</div>--}}
        {{--</form>--}}
    {{--</div>--}}
{{--</div>--}}
@endif

</div>



@include('layouts.partials.student.profile')


 <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Academic history</h5>
                        </div>
                        <div class="ibox-content">


                                <table class="table" >
                                        <thead>
                                        <tr>
                                            <th>Class</th>
                                            <th>Level</th>
                                           <th>action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                @foreach($sessions as $session)
                                        <tr>
                                            <td>{{ $student->session_classroom($session->id)->name }}</td>
                                            <td>{{ $student->session_classroom($session->id)->level->name }}</td>
                                            <td class="text-left">

                                                <div class="btn-group">
                                                    {{--<a class="btn btn-white" type="button" href="{{ url('admin/students/'. $student->id .'/results/session/'.$session->id.'/edit') }}">Edit</a>--}}
                                                    <a class="btn btn-primary" type="button" href="{{ url('admin/students/'. $student->id .'/results/session/'.$session->id.'/view') }}">View</a>
                                                    {{--<a class="btn btn-white" type="button" href="{{ url('admin/students/'.$student->id.'/results/session/'.$session->id.'/print') }}">Print</a>--}}
                                                </div>
                                            </td>
                                        </tr>
                                @endforeach

                                    </tbody>
                                </table>

                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>School Fees Payment history</h5>
                        </div>
                        <div class="ibox-content">


                                <table class="table" >
                                        <thead>
                                        <tr>
                                            <th>Session</th>
                                            <th>Class</th>
                                            <th>First term</th>
                                            <th>Second term</th>
                                            <th>Third term</th>
                                           <th>action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                @foreach($sessions as $class_session)
                                        <tr>
                                            <td>{{ $class_session->name }}</td>
                                            <td>{{ $student->session_classroom($class_session->id)->name }}</td>
                                            <td>{{ isset($session) && $class_session->id == $session->id ? $student->classroom->first_term_charges : 0 }}</td>
                                            <td>{{ isset($session) && $class_session->id == $session->id ? $student->classroom->second_term_charges : 0 }}</td>
                                            <td>{{ isset($session) && $class_session->id == $session->id ? $student->classroom->third_term_charges : 0 }}</td>
                                            <td class="text-left">
                                                <div class="btn-group">
                                                    {{--<a class="btn btn-white" type="button" href="{{ url('admin/students/'. $student->id .'/results/session/'.$session->id.'/edit') }}">Edit</a>--}}
                                                    <a class="btn btn-primary" type="button" href="{{ url('admin/students/'. $student->id .'/results/session/'.$session->id.'/view') }}">View</a>
                                                    {{--<a class="btn btn-white" type="button" href="{{ url('admin/students/'.$student->id.'/results/session/'.$session->id.'/print') }}">Print</a>--}}
                                                </div>
                                            </td>
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
    <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>
    <script>


        $(document).ready(function(){

                           $.ajaxSetup({
                               headers: {
                                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                               }
                           });

                                    guardian_phone = $('#guardian_phone');

                                    guardian_phone.focusout(function(){

                                       var phone = $(this).val();

                                       if(phone.length == 0){
                                           $('#guardian_phone').parent().removeClass('has-success');
                                           $('#guardian_phone').parent().removeClass('has-error');
                                           $("select[name='guardian_id']").children().remove();
                                       }

                                       $.ajax({
                                             type: "POST",
                                             data: {"phone":phone},
                                             url: window.location.protocol + "//" + window.location.host + "/get_guardian_id/" + phone,
                                             success: function(data){

                                                if(parseInt(data) == 0){

                                                    $('#guardian_phone').parent().removeClass('has-success');
                                                    $('#guardian_phone').parent().addClass('has-error');
                                                    $("select[name='guardian_id']").children().remove();

                                                }else{
                                                    $('#guardian_phone').parent().removeClass('has-error');
                                                    $('#guardian_phone').parent().addClass('has-success');
                                                    $("select[name='guardian_id']").children().remove();
                                                    $("select[name='guardian_id']").append("<option value='" + data.id + "' selected='selected'>" + data.name + "</option>");
                                                }

                                             }
                                           });

                                    });

                                    guardian_phone.keyup(function(){

                                       var phone = $(this).val();

                                       if(phone.length == 0){
                                           $('#guardian_phone').parent().removeClass('has-success');
                                           $('#guardian_phone').parent().removeClass('has-error');
                                           $("select[name='guardian_id']").children().remove();
                                       }

                                       $.ajax({
                                             type: "POST",
                                             data: {"phone":phone},
                                             url: window.location.protocol + "//" + window.location.host + "/get_guardian_id/" + phone,
                                             success: function(data){

                                                if(parseInt(data) == 0){

                                                    $('#guardian_phone').parent().removeClass('has-success');
                                                    $('#guardian_phone').parent().addClass('has-error');
                                                    $("select[name='guardian_id']").children().remove();

                                                }else{
                                                    $('#guardian_phone').parent().removeClass('has-error');
                                                    $('#guardian_phone').parent().addClass('has-success');
                                                    $("select[name='guardian_id']").children().remove();
                                                    $("select[name='guardian_id']").append("<option value='" + data.id + "' selected='selected'>" + data.name + "</option>");
                                                }

                                             }
                                           });

                                    });

                $('#dob').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true
                });

                $('#date_admitted').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true
                });

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