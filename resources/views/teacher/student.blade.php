@extends('layouts.app')

@section('title', $classroom->name)

@section('page-heading')
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $student->name }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('teacher') }}">Home</a>
                </li>
                <li class="active">
                    <a href="{{ url('admin/classrooms/' . $classroom->id) }}">{{ $classroom->name }}</a>
                </li>
                <li class="active">
                    <a href="{{ url('admin/classrooms/' . $classroom->id) }}">{{ $classroom->name }}</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
 </div>
@endsection

@section('content')

<div class="wrapper wrapper-content">

@if(isset($session) && !is_null($session) && $session->term() == 'third')
<div class="row m-b-md">
    <div class="col-lg-6">
            <form action="{{ url('teacher/classrooms/' . $classroom->id . '/students/'.$student->id.'/promote') }}" method="post" id="promote">
            {{ csrf_field() }}
                 <div class="input-group m-b"><span class="input-group-btn">
                     <button  type="submit" class="btn btn-primary btn-block" id="promote">Promote to</button></span> <select class="form-control" name="promoted_to_classroom_id">
                        @foreach($classrooms as $promoted_to_class)
                            @if($promoted_to_class->level->rank > $classroom->level->rank)
                                <option value="{{ $promoted_to_class->id }}">{{ $promoted_to_class->name }}</option>
                            @endif
                        @endforeach
                     </select>
                 </div>

            </form>
        </div>

    <div class="col-lg-6">
        <form action="{{ url('teacher/classrooms/' . $classroom->id . 'students/'.$student->id.'/repeat') }}" method="post" id="repeat-all">
        {!! csrf_field() !!}
                <div class="input-group m-b"><span class="input-group-btn">
                     <button  type="submit" class="btn btn-warning btn-block" id="repeat">Repeat student</button></span>
                     <input type="hidden" name="repeated_to_classroom_id" value="{{ $classroom->id }}">
                 </div>
        </form>
    </div>
</div>
@endif

@include('layouts.partials.student.profile')


<div class="row m-t-sm">
    @if(isset($session) && !is_null($session) && ($student->term_results($session->id, 'first')->count() > 0) )
    <div class="col-lg-4">
    <a href="{{ url('teacher/classrooms/'.$classroom->id .'/students/'.$student->id.'/results?session_id=' . $session->id . '&&term=' . 'first') }}" title="click to view results" target="_blank">
        <div class="widget lazur-bg p-lg text-center">
            <div class="m-b-md">
                <i class="fa fa-graduation-cap fa-4x"></i>
                <h1 class="m-xs">{{ round($student->term_percentage($student->term_results($session->id, 'first')),2) . '%' }}</h1>
                <h3 class="font-bold no-margins">
                    1st Term Results
                </h3>
                <small>Total subject recorded: {{ $student->term_results($session->id, 'first')->count() }}</small>
            </div>
        </div>
      </a>
    </div>
    @endif

    @if(isset($session) && !is_null($session) && ($student->term_results($session->id, 'second')->count() > 0) )
    <div class="col-lg-4">
    <a href="{{ url('teacher/classrooms/'.$classroom->id .'/students/'.$student->id.'/results?session_id=' . $session->id . '&&term=' . 'second') }}" title="click to view results" target="_blank">
        <div class="widget lazur-bg p-lg text-center">
            <div class="m-b-md">
                <i class="fa fa-graduation-cap fa-4x"></i>
                <h1 class="m-xs">{{ round($student->term_percentage($student->term_results($session->id, 'second')), 2) . '%' }}</h1>
                <h3 class="font-bold no-margins">
                    2nd Term Results
                </h3>
                <small>Total subject recorded: {{ $student->term_results($session->id, 'second')->count() }}</small>
            </div>
        </div>
      </a>
    </div>
    @endif

    @if(isset($session) && !is_null($session) && ($student->term_results($session->id, 'third')->count() > 0) )
    <div class="col-lg-4">
    <a href="{{ url('teacher/classrooms/'.$classroom->id .'/students/'.$student->id.'/results?session_id=' . $session->id . '&&term=' . 'third') }}" title="click to view results" target="_blank">
        <div class="widget lazur-bg p-lg text-center">
            <div class="m-b-md">
                <i class="fa fa-graduation-cap fa-4x"></i>
                <h1 class="m-xs">{{ round($student->term_percentage($student->term_results($session->id, 'third')), 2) . '%' }}</h1>
                <h3 class="font-bold no-margins">
                    3rd Term Results
                </h3>
                <small>Total subject recorded: {{ $student->term_results($session->id, 'third')->count() }}</small>
            </div>
        </div>
      </a>
    </div>
    @endif

</div>

</div>

@endsection