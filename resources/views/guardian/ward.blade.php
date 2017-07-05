@extends('layouts.app')

@section('title', $student->name)

@section('page-heading')
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $student->name }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('guardian') }}">Home</a>
                </li>
                <li>
                    <a href="{{ url('guardian/wards') }}">Wards</a>
                </li>
                <li class="active">
                    <a href="{{ url('guardian/wards/' . $student->id) }}">{{ $student->name }}</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
 </div>
@endsection

@section('content')

<div class="wrapper wrapper-content">


@include('layouts.partials.student.profile')


<div class="row m-t-sm">
    <div class="col-lg-6">

       <table class="table table-bordered table-stripped">
        <thead>
            <th>Session</th>
            <th>First Term</th>
            <th>Second Term</th>
            <th>Third Term</th>
            <th>Analytics</th>
        </thead>
        <tbody>
            @foreach($academic_history as $session_name => $session_results)
                <tr>
                    <td>{{ $session_name }}</td>
                    <td>{{ $student->term_percentage($session_results['first_term']) }}</td>
                    <td>{{ $student->term_percentage($session_results['second_term']) }}</td>
                    <td>{{ $student->term_percentage($session_results['third_term']) }}</td>
                    <td>View Analytics</td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    <div class="col-lg-6">

    </div>
</div>

</div>

@endsection