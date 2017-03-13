@extends('layouts.app')

@section('title', $student->name)

@section('styles')
<link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('page-heading')
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2> {{ $student->name }} - {{ $classroom->name . '( ' . $r_session->name . ' )' . ' results'}} </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('admin') }}">Home</a>
                </li>
                <li class="active">
                    <a href="{{ url('admin/students/' . $student->id ) }}">{{ $student->name }}</a>
                </li>
            </ol>
        </div>
          <div class="col-lg-2">
            <button type="button" class="btn btn-primary m-t-md" data-toggle="modal" data-target="#edit-student-info">
                Upload Result
            </button>
             <div class="modal inmodal" id="edit-student-info" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated bounceInRight">


                            <form method="POST" class="form" enctype="multipart/form-data" action="{{ url('admin/students/' . $student->id . '/results/session/' . $session->id . '/update_student_term_results_excel') }}">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                                 <h4 class="modal-title">{{ $student->name }}</h4>

                            </div>

                            <div class="modal-body">



                                {{ csrf_field() }}
                                 <input type="hidden" name="classroom_id" value="{{ $student->classroom->id }}">

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
                                            <label class="control-label" for="upload_student_term_results_excel">Select file</label>
                                            <input type="file" name="student_term_results" id="upload_student_term_results_excel" class="form-control" required>
                                        </div>
                                     </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Term </label>
                                                <select class="form-control" name="term" required>
                                                    <option></option>
                                                    <option value="first"  {{ old('term') == 'first' ? 'selected' : '' }}>First</option>
                                                    <option value="second" {{ old('term') == 'second' ? 'selected' : '' }}>Second</option>
                                                    <option value="third"  {{ old('term') == 'third' ? 'selected' : '' }}>Third</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Upload result</button>
                            </div>

                     </form>
                     </div>
                </div>
            </div>
        </div>
 </div>
@endsection

@section('content')

 <div class="wrapper wrapper-content animated fadeInRight ecommerce">

     <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>First term</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                        <a class="print-link" href="{{ url('admin/students/'. $student->id .'/results?session_id='.$r_session->id.'&&term=first') }}" title="click to print" target="_blank">
                            <i class="fa fa-print"></i>
                        </a>

                    </div>
                </div>
                <div class="ibox-content" style="display: none">
                    <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover subjects-score-dataTables" >
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>CA1</th>
                                    <th>CA2</th>
                                    <th>Exam</th>
                                    <th>Total</th>
                                    <th>Grade</th>
                                    <th>Position</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($first_term_results as $result)
                                <tr class="gradeX">
                                    <td>{{ $result->subject->name }}</td>

                                      <form method="POST" action="{{ url('admin/students/'. $student->id .'/results/session/' . $result->session_id . '/update') }}">

                                          <input type="hidden" name="result_id" value="{{ $result->id }}">
                                          <input type="hidden" name="student_id" value="{{ $student->id }}">
                                          <input type="hidden" name="classroom_id" value="{{ $result->classroom_id }}">
                                          <input type="hidden" name="subject_id" value="{{ $result->subject_id }}">
                                          <input type="hidden" name="teacher_id" value="{{ $result->teacher_id }}">
                                          <input type="hidden" name="session_id" value="{{ $result->session_id }}">
                                          <input type="hidden" name="term" value="{{ $result->term }}">

                                          <td style="width: 13%;">
                                              <div class="input-group">
                                                  <input type="number" name="first_ca" class="form-control first_ca" value="{{ !is_null($result) ? $result->first_ca : '' }}" max="20" min="0"><span class="input-group-addon"><i>/20</i></span>
                                              </div>
                                          </td>
                                          <td style="width: 13%;">
                                              <div class="input-group">
                                                  <input type="number" name="second_ca" class="form-control second_ca" value="{{ !is_null($result) ? $result->second_ca : '' }}" max="20" min="0"><span class="input-group-addon"><i>/20</i></span>
                                              </div>
                                          </td>
                                          <td style="width: 13%;">
                                              <div class="input-group">
                                                  <input type="number" name="exam" class="form-control exam" value="{{ !is_null($result) ? $result->exam : '' }}" max="60" min="0"><span class="input-group-addon"><i>/60</i></span>
                                              </div>
                                          </td>
                                      </form>
                                      <td class="total-score">
                                           {{ !is_null($result) ? $result->total() : '' }}
                                      </td>
                                      <td class="score-grade">
                                        {{ !is_null($result) ? $result->grade() : '' }}
                                      </td>
                                      <td class="score-position">
                                        {{ !is_null($result) ? $result->position() : '' }}
                                      </td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Subject</th>
                                    <th>CA1</th>
                                    <th>CA2</th>
                                    <th>Exam</th>
                                    <th>Total</th>
                                    <th>Grade</th>
                                    <th>Position</th>
                                </tr>
                                </tfoot>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

          <div class="row">
             <div class="col-lg-12">
                 <div class="ibox float-e-margins">
                     <div class="ibox-title">
                         <h5>Second term </h5>
                         <div class="ibox-tools">
                             <a class="collapse-link">
                                 <i class="fa fa-chevron-down"></i>
                             </a>
                             <a class="close-link">
                                 <i class="fa fa-times"></i>
                             </a>
                             <a class="print-link" href="{{ url('admin/students/'. $student->id .'/results?session_id='.$r_session->id.'&&term=second') }}" title="click to print" target="_blank">
                                 <i class="fa fa-print"></i>
                             </a>

                         </div>
                     </div>
                     <div class="ibox-content" style="display: none">
                         <div class="table-responsive">
                                 <table class="table table-striped table-bordered table-hover subjects-score-dataTables" >
                                 <thead>
                                     <tr>
                                         <th>Subject</th>
                                         <th>CA1</th>
                                         <th>CA2</th>
                                         <th>Exam</th>
                                         <th>Total</th>
                                         <th>Grade</th>
                                         <th>Position</th>
                                     </tr>
                                     </thead>
                                     <tbody>
                                     @foreach($second_term_results as $result)
                                     <tr class="gradeX">
                                         <td>{{ $result->subject->name }}</td>

                                           <form method="POST" action="{{ url('admin/students/'. $student->id .'/results/session/' . $result->session_id . '/update') }}">
                                                <input type="hidden" name="result_id" value="{{ $result->id }}">
                                               <input type="hidden" name="student_id" value="{{ $student->id }}">
                                               <input type="hidden" name="classroom_id" value="{{ $result->classroom_id }}">
                                               <input type="hidden" name="subject_id" value="{{ $result->subject_id }}">
                                               <input type="hidden" name="teacher_id" value="{{ $result->teacher_id }}">
                                               <input type="hidden" name="session_id" value="{{ $result->session_id }}">
                                               <input type="hidden" name="term" value="{{ $result->term }}">

                                               <td style="width: 13%;">
                                                   <div class="input-group">
                                                       <input type="number" name="first_ca" class="form-control first_ca" value="{{ !is_null($result) ? $result->first_ca : '' }}" max="20" min="0"><span class="input-group-addon"><i>/20</i></span>
                                                   </div>
                                               </td>
                                               <td style="width: 13%;">
                                                   <div class="input-group">
                                                       <input type="number" name="second_ca" class="form-control second_ca" value="{{ !is_null($result) ? $result->second_ca : '' }}" max="20" min="0"><span class="input-group-addon"><i>/20</i></span>
                                                   </div>
                                               </td>
                                               <td style="width: 13%;">
                                                   <div class="input-group">
                                                       <input type="number" name="exam" class="form-control exam" value="{{ !is_null($result) ? $result->exam : '' }}" max="60" min="0"><span class="input-group-addon"><i>/60</i></span>
                                                   </div>
                                               </td>
                                           </form>
                                           <td class="total-score">
                                                {{ !is_null($result) ? $result->total() : '' }}
                                           </td>
                                           <td class="score-grade">
                                             {{ !is_null($result) ? $result->grade() : '' }}
                                           </td>
                                           <td class="score-position">
                                             {{ !is_null($result) ? $result->position() : '' }}
                                           </td>
                                     </tr>
                                     @endforeach
                                     </tbody>
                                     <tfoot>
                                     <tr>
                                         <th>Subject</th>
                                         <th>CA1</th>
                                         <th>CA2</th>
                                         <th>Exam</th>
                                         <th>Total</th>
                                         <th>Grade</th>
                                         <th>Position</th>
                                     </tr>
                                     </tfoot>
                                 </table>
                         </div>
                     </div>
                 </div>
             </div>
         </div>

              <div class="row">
                 <div class="col-lg-12">
                     <div class="ibox float-e-margins">
                         <div class="ibox-title">
                             <h5>Third term </h5>
                             <div class="ibox-tools">
                                 <a class="collapse-link">
                                     <i class="fa fa-chevron-down"></i>
                                 </a>
                                 <a class="close-link">
                                     <i class="fa fa-times"></i>
                                 </a>
                                 <a class="print-link" href="{{ url('admin/students/'. $student->id .'/results?session_id='.$r_session->id.'&&term=third') }}" title="click to print" target="_blank">
                                     <i class="fa fa-print"></i>
                                 </a>
                             </div>
                         </div>
                         <div class="ibox-content" style="display: none">
                             <div class="table-responsive">
                                     <table class="table table-striped table-bordered table-hover subjects-score-dataTables" >
                                     <thead>
                                         <tr>
                                             <th>Subject</th>
                                             <th>CA1</th>
                                             <th>CA2</th>
                                             <th>Exam</th>
                                             <th>Total</th>
                                             <th>Grade</th>
                                             <th>Position</th>
                                         </tr>
                                         </thead>
                                         <tbody>
                                         @foreach($third_term_results as $result)
                                         <tr class="gradeX">
                                             <td>{{ $result->subject->name }}</td>

                                               <form method="POST" action="{{ url('admin/students/'. $student->id .'/results/session/' . $result->session_id . '/update') }}">
                                                   <input type="hidden" name="result_id" value="{{ $result->id }}">
                                                   <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                   <input type="hidden" name="classroom_id" value="{{ $result->classroom_id }}">
                                                   <input type="hidden" name="subject_id" value="{{ $result->subject_id }}">
                                                   <input type="hidden" name="teacher_id" value="{{ $result->teacher_id }}">
                                                   <input type="hidden" name="session_id" value="{{ $result->session_id }}">
                                                   <input type="hidden" name="term" value="{{ $result->term }}">

                                                   <td style="width: 13%;">
                                                       <div class="input-group">
                                                           <input type="number" name="first_ca" class="form-control first_ca" value="{{ !is_null($result) ? $result->first_ca : '' }}" max="20" min="0"><span class="input-group-addon"><i>/20</i></span>
                                                       </div>
                                                   </td>
                                                   <td style="width: 13%;">
                                                       <div class="input-group">
                                                           <input type="number" name="second_ca" class="form-control second_ca" value="{{ !is_null($result) ? $result->second_ca : '' }}" max="20" min="0"><span class="input-group-addon"><i>/20</i></span>
                                                       </div>
                                                   </td>
                                                   <td style="width: 13%;">
                                                       <div class="input-group">
                                                           <input type="number" name="exam" class="form-control exam" value="{{ !is_null($result) ? $result->exam : '' }}" max="60" min="0"><span class="input-group-addon"><i>/60</i></span>
                                                       </div>
                                                   </td>
                                               </form>
                                               <td class="total-score">
                                                    {{ !is_null($result) ? $result->total() : '' }}
                                               </td>
                                               <td class="score-grade">
                                                 {{ !is_null($result) ? $result->grade() : '' }}
                                               </td>
                                               <td class="score-position">
                                                 {{ !is_null($result) ? $result->position() : '' }}
                                               </td>
                                         </tr>
                                         @endforeach
                                         </tbody>
                                         <tfoot>
                                         <tr>
                                             <th>Subject</th>
                                             <th>CA1</th>
                                             <th>CA2</th>
                                             <th>Exam</th>
                                             <th>Total</th>
                                             <th>Grade</th>
                                             <th>Position</th>
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

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var $student_score = $('input.first_ca, input.second_ca, input.exam');


                    $student_score.change(function(){

                       //alert($(this).val());
                      $update_score = $(this);
                      $form = $(this).closest('tr').children('form');
                      $form_url = $form.attr('action');

                       $.ajax({
                             type: "POST",
                             url: $form_url,
                             data: $form.serialize(),
                             beforeSend: function(){
                                    //alert('before');
                             },
                             success: function(data){

                                    $update_score.closest('tr').children('.total-score').text(data.total);
                                    $update_score.closest('tr').children('.score-grade').text(data.grade);
                                    $update_score.closest('tr').children('.score-position').text(data.position);

                                }
                       });

                    });


        $('.subjects-score-dataTables').DataTable({

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

                  });

         </script>
@endsection