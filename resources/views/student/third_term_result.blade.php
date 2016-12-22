@extends('layouts.result')

@section('title',  $student->name)

@section('result-heading')

@section('result-heading')
<img src="{{ asset('img/banner.jpg') }}" class="m-b-xs" alt="profile" width="100%">
  <div class="row m-b-xs m-t-xs">
                <div class="col-md-12">

                    <table class="table small m-b-xs">
                        <tbody>
                        <tr>
                            {{--<td rowspan="3">--}}
                                {{--<div class="profile-image">--}}
                                    {{--<img src="{{ is_file(asset('storage/' . $student->image)) ? asset('storage/' . $student->image) : asset('storage/images/' . strtolower($student->sex) . '.png') }}" class="img-rounded m-b-md" alt="profile">--}}
                                {{--</div>--}}
                            {{--</td>--}}
                            <td>
                                Name: <strong> {{ $student->name }} </strong>
                            </td>
                            <td>
                                Reg Number: <strong> {{ $student->admin_number }} </strong>
                            </td>
                            <td>
                                Class: <strong> {{ $results->first()->classroom->name }} </strong>
                            </td>
                        </tr>
                        <tr>
                           <td>
                                Academic year: <strong> {{ $results->first()->session->name }} </strong>
                            </td>
                            <td>
                                Position: <strong> {{ $student->third_term_position($results->first()->session_id) }} </strong>
                            </td>
                            <td>
                              <strong>Term</strong> {{ ucfirst($results->first()->term) }}
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
@endsection

@section('result-body')
        <table class="table small table-bordered result-table" >
            <thead>
            <tr>
                <th>Subjects</th>
                <th>1st term</th>
                <th>2nd term</th>
                <th class="text-center">CA1/20</th>
                <th class="text-center">CA2/20</th>
                <th class="text-center">CA Total</th>
                <th class="text-center">Exam/60</th>
                <th class="text-center">Grand Total</th>
                <th>Session Avg</th>
                <th class="text-center">Grade</th>
                {{--<th class="text-center">Position</th>--}}
                <th class="text-center">Remarks</th>
            </tr>
            </thead>
            <tbody>
            @foreach($results as $result)
            <tr>
                <td>{{ $result->subject->name }}</td>
                <td class="text-center">{{ str_pad($result->first_term_total(), 2, '0', 0) }}</td>
                <td class="text-center">{{ str_pad($result->second_term_total(), 2, '0', 0) }}</td>
                <td class="text-center">{{ str_pad($result->first_ca, 2, '0', 0) }}</td>
                <td class="text-center">{{ str_pad($result->second_ca, 2, '0', 0) }}</td>
                <td class="text-center">{{ str_pad($result->first_ca + $result->second_ca, 2, '0', 0)}}</td>
                <td class="text-center">{{ str_pad($result->exam, 2, '0', 0) }}</td>
                <td class="text-center">{{ str_pad($result->total(), 2, '0', 0) }}</td>
                <td class="text-center">{{ round(($result->first_term_total() + $result->second_term_total() + $result->total()) / 3, 1) }}</td>
                <td class="text-center">{{ grade(($result->first_term_total() + $result->second_term_total() + $result->total()) / 3) }}</td>
                {{--<td class="text-center">{{ $result->position() }}</td>--}}
                <td class="text-center">{{ remark(($result->first_term_total() + $result->second_term_total() + $result->total()) / 3) }}</td>
            </tr>
            @endforeach
             <tr>
                <td></td>
                <td>Total Mark</td>
                <td>
                {{
                    $student->third_term_results($results->first()->session->id)->sum('first_ca') +
                    $student->third_term_results($results->first()->session->id)->sum('second_ca') +
                    $student->third_term_results($results->first()->session->id)->sum('exam')
                }}
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Average</td>
                <td>{{ round($student->term_percentage($results), 2)  }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Percentage</td>
                <td>{{ round($student->term_percentage($results), 0) . '%' }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
             <tr>
                <td></td>
                <td>Session avg</td>
                <td>{{ round(
                        ($student->term_percentage($student->first_term_results($results->first()->session_id)) +
                        $student->term_percentage($student->second_term_results($results->first()->session_id)) +
                        $student->term_percentage($results))/3, 2)
                   }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
@endsection

@section('result-footer')
<table class="table table-bordered small">
    <tr>
        <td>RATING SCALES</td>
        <td>70-100 Excellent</td>
        <td>60-69 Very Good</td>
        <td>50-59 Good</td>
        <td>45-49 Fair</td>
        <td>40-44 Poor</td>
        <td>00-39 Fail</td>
    </tr>
</table>


<table class="table small">
            <tr>
                <td>Grade</td>
                <td>{{ grade(round($student->term_percentage($results), 0)) }}</td>
            </tr>
            <tr>
                <td>No. of Student in Class</td>
                <td>{{ $results->first()->classroom_students_count() }}</td>
            </tr>
            <tr>
                <td>Next Term Begin</td>
                <td></td>
            </tr>
            <tr>
                <td>Teacher's Comment</td>
                <td height="20">{{
                    third_term_remark(
                            round(
                                ($student->term_percentage($student->first_term_results($results->first()->session_id)) +
                                 $student->term_percentage($student->second_term_results($results->first()->session_id)) +
                                 $student->term_percentage($results))/3, 2),

                            $results->first()->session_id,
                            $student
                            )
                }}</td>
            </tr>
            <tr>
                <td>Head Teacher's Sign</td>
                <td><img src="{{ asset('img/sign.png') }}" width="80px" height="35px"></td>
            </tr>
        </table>
@endsection