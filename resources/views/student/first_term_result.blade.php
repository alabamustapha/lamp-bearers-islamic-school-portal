@extends('layouts.result')

@section('title',  $student->name)


@section('result-heading')
<img src="{{ asset('img/banner.jpg') }}" class="m-b-xs" alt="profile" width="100%">
  <div class="row m-b-xs m-t-xs">
                <div class="col-sm-12">

                    <div class="col-sm-5">
                        <table class="table small m-b-xs">
                            <tbody>
                            <tr>
                                <td>
                                    Name: <strong> {{ $student->name }} </strong>
                                </td>
                                <td>
                                    Reg Number: <strong> {{ $student->admin_number }} </strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Class: <strong> {{ $results->first()->classroom->level->name . ' ' . $results->first()->classroom->name }} </strong>
                                </td>
                                <td>
                                    House: <strong> {{ $student->house->name }} </strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    No in class: <strong> {{ $results->first()->classroom_students_count() }} </strong>
                                </td>
                                <td>
                                    Position: <strong> {{ $student->first_term_position($results->first()->session_id) }} </strong>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-2">

                        <div class="profile-image">
                            <img src="{{ has_image($student) ? asset('storage/' . $student->image) : asset('storage/images/' . strtolower($student->sex) . '.png') }}" class="img-rounded m-b-md" alt="profile">
                        </div>

                    </div>
                    <div class="col-sm-5">

                                        <table class="table small m-b-xs">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    Academic year: <strong> {{ $results->first()->session->name }} </strong>
                                                </td>
                                                <td>
                                                  <strong>Term</strong> {{ ucfirst($results->first()->term) }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    No. of days School opened: <strong> {{ "" }} </strong>
                                                </td>
                                                <td>
                                                    No. of days present: <strong> {{ "" }} </strong>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    % of days present: <strong> {{ "" }} </strong>
                                                </td>

                                                <td>
                                                    House: <strong> {{ $student->house->name }} </strong>
                                                </td>

                                            </tr>

                                            </tbody>
                                        </table>
                    </div>

                </div>
            </div>
@endsection

@section('result-body')
        <table class="table table-bordered small result-table">
            <thead>
            <tr>
                <th>Subjects</th>
                <th class="text-center">CA1/20</th>
                <th class="text-center">CA2/20</th>
                <th class="text-center">CA Total</th>
                <th class="text-center">Exam/60</th>
                <th class="text-center">Grand Total</th>
                <th class="text-center">Grade</th>
                {{--<th class="text-center">Position</th>--}}
                <th class="text-center">Remarks</th>
            </tr>
            </thead>
            <tbody>
            @foreach($results as $result)
            <tr>
                <td>{{ $result->subject->name }}</td>
                <td class="text-center">{{ str_pad($result->first_ca, 2, '0', 0) }}</td>
                <td class="text-center">{{ str_pad($result->second_ca, 2, '0', 0) }}</td>
                <td class="text-center">{{ str_pad($result->first_ca + $result->second_ca, 2, '0', 0)}}</td>
                <td class="text-center">{{ str_pad($result->exam, 2, '0', 0) }}</td>
                <td class="text-center">{{ str_pad($result->total(), 2, '0', 0) }}</td>
                <td class="text-center">{{ $result->grade() }}</td>
                {{--<td class="text-center">{{ $result->position() }}</td>--}}
                <td class="text-center">{{ $result->remark() }}</td>
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td>Total Mark</td>
                <td>{{
                    $student->first_term_results($results->first()->session_id)->sum('first_ca') +
                    $student->first_term_results($results->first()->session_id)->sum('second_ca') +
                    $student->first_term_results($results->first()->session_id)->sum('exam')
                    }}
                </td>
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
            </tr>
            </tbody>
        </table>


@endsection

@section('result-footer')

<div class="row">
    <div class="col-sm-4">
            <table class="table table-bordered small">
                <thead>
                    <th>Pratical Skills</th>
                    <th>Rating</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Handwriting</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td>Drawing &amp; Painting</td>
                        <td>B</td>
                    </tr>
                    <tr>
                        <td>Games &amp; Sports</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td>Computer Appreciation</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td>Recitation Skills</td>
                    </tr>
                </tbody>
            </table>
    </div>
    <div class="col-sm-4">
            <table class="table table-bordered small">
                <thead>
                    <th>Character &amp; Development</th>
                    <th>Rating</th>
                </thead>

                <tbody>
                    <tr>
                        <td>Punctuality</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td>Neatness</td>
                        <td>B</td>
                    </tr>
                    <tr>
                        <td>Politeness</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td>Cooperation with others</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td>Leadership</td>
                    </tr>
                </tbody>
            </table>
    </div>
    <div class="col-sm-4">
            <table class="table table-bordered small">
                <thead>
                    <th>Pratical Skills</th>
                    <th>Rating</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Emotional Stability</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td>Health</td>
                        <td>B</td>
                    </tr>
                    <tr>
                        <td>Attentiveness</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td>Attitude to work</td>
                        <td>A</td>
                    </tr>

                </tbody>
            </table>
    </div>

</div>
<table class="table table-bordered small">
    <tr>
        <td>RATING SCALES</td>
        <td>70-100 Excellent ( A )</td>
        <td>60-69 Very Good ( B )</td>
        <td>50-59 Good ( C )</td>
        <td>45-49 Fair ( D )</td>
        <td>40-44 Poor ( E )</td>
        <td>00-39 Fail ( F )</td>
    </tr>
</table>


<table class="table small">
            <tr>
                <td>Class Teacher's Comment</td>
                <td height="10" style="text-align: left;" colspan="3">{{ "" }}</td>
                {{--<td height="20" style="text-align: left;" colspan="3">{{ class_teacher_remark(round($student->term_percentage($results))) }}</td>--}}
            </tr>
            <tr>
                <td>Date</td>
                <td></td>
                <td>Signature</td>
                {{--<td><img src="{{ asset('img/sign.png') }}" height="35px"></td>--}}
                <td></td>
            </tr>

            <tr>
                <td>Head Teacher's Comment</td>
                <td height="20" style="text-align: left;" colspan="3">{{ "" }}</td>
            </tr>
            <tr>
                <td>Date</td>
                <td></td>
                <td>Signature</td>
                <td></td>
                {{--<td><img src="{{ asset('img/sign.png') }}" height="35px"></td>--}}
            </tr>
            <tr>
                <td>Next Term Begin</td>
                <td></td>
                <td>Next Term Fee</td>
                <td></td>
            </tr>
        </table>
@endsection