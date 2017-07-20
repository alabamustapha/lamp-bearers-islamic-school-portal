@extends('layouts.result')

@section('title',  $student->name)

@section('result-heading')

@section('result-heading')
<img src="{{ asset('img/banner.jpg') }}" class="m-b-xs" alt="profile" width="100%">
  <div class="row m-b-xs m-t-xs">
                <div class="col-xs-12">

                    <div class="col-xs-5">
                        <table class="table small m-b-xs result-table">
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
                                {{-- commnet out position--}}
                                {{--<td>--}}
                                    {{--Position: <strong> {{ $student->first_term_position($results->first()->session_id) }} </strong>--}}
                                {{--</td>--}}
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-2">

                        <div class="profile-image">
                            <img src="{{ has_image($student) ? asset('storage/' . $student->image) : asset('storage/images/' . strtolower($student->sex) . '.png') }}" class="img-rounded m-b-md" alt="profile">
                        </div>

                    </div>
                    <div class="col-xs-5">

                                        <table class="table small m-b-xs result-table">
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
                                                    No. of days School opened: <strong> {{ "108" }} </strong>
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
        <table class="table table-bordered small result-table" id="subject-scores">
            <thead>
            <tr>
                <th>Subjects</th>
                <th class="text-center">1st Term</th>
                <th class="text-center">2nd Term</th>
                {{--<th class="text-center">CA1/20</th>--}}
                {{--<th class="text-center">CA2/20</th>--}}
                <th class="text-center">CA Total</th>
                <th class="text-center">Exam/60</th>
                <th class="text-center">Grand Total</th>
                <th class="text-center">Session Avg</th>
                <th class="text-center">Class Highest</th>
                <th class="text-center">Class Average</th>
                <th class="text-center">Position</th>
                <th class="text-center">Grade</th>
                <th class="text-center">Remarks</th>
            </tr>
            </thead>
            <tbody>
            @foreach($results as $result)
            <tr>
                <td>{{ $result->subject->name }}</td>
                <td class="text-center">{{ str_pad($result->first_term_total(), 2, '0', 0) }}</td>
                <td class="text-center">{{ str_pad($result->second_term_total(), 2, '0', 0) }}</td>
                {{--<td class="text-center">{{ str_pad($result->first_ca, 2, '0', 0) }}</td>--}}
                {{--<td class="text-center">{{ str_pad($result->second_ca, 2, '0', 0) }}</td>--}}
                <td class="text-center">{{ str_pad($result->first_ca + $result->second_ca, 2, '0', 0)}}</td>
                <td class="text-center">{{ str_pad($result->exam, 2, '0', 0) }}</td>
                <td class="text-center">{{ str_pad($result->total(), 2, '0', 0) }}</td>
                <td class="text-center">{{ round(($result->first_term_total() + $result->second_term_total() + $result->total()) / 3, 1) }}</td>
                <td class="text-center">{{ str_pad($result->class_highest_mark(), 2, '0', 0) }}</td>
                <td class="text-center">{{ round($result->class_average(), 1) }}</td>
                <td class="text-center">{{ $result->position() }}</td>
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
             {{--<tr>--}}
                {{--<td></td>--}}
                {{--<td>Session avg</td>--}}
                {{--<td>{{  $student->term_percentage($student->first_term_results($results->first()->session_id)) +--}}
                        {{--$student->term_percentage($student->second_term_results($results->first()->session_id)) +--}}
                        {{--$student->term_percentage($results)--}}
                   {{--}}</td>--}}
                {{--<td></td>--}}
                {{--<td></td>--}}
                {{--<td></td>--}}
                {{--<td></td>--}}
                {{--<td></td>--}}
                {{--<td></td>--}}
                {{--<td></td>--}}
                {{--<td></td>--}}
            {{--</tr>--}}
            </tbody>
        </table>
@endsection

@section('result-footer')


<div class="row">
    <div class="col-xs-3">
            <table class="table table-bordered small result-table">
                <thead>
                    <th>Pratical Skills</th>
                    <th>Rating</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Handwriting</td>
                        <td>{{ $psychomotor->handwriting or '' }}</td>
                    </tr>
                    <tr>
                        <td>Drawing &amp; Painting</td>
                        <td>{{ $psychomotor->drawing_painting or '' }}</td>
                    </tr>
                    <tr>
                        <td>Games &amp; Sports</td>
                        <td>{{ $psychomotor->games_sports or '' }}</td>
                    </tr>
                    <tr>
                        <td>Computer Appreciation</td>
                        <td>{{ $psychomotor->computer_appreciation or ''}}</td>
                    </tr>
                    <tr>
                        <td>Recitation Skills</td>
                        <td>{{ $psychomotor->recitation_skills or ''}}</td>
                    </tr>
                </tbody>
            </table>
    </div>
    <div class="col-xs-3">
            <table class="table table-bordered small result-table">
                <thead>
                    <th>Character &amp; Development</th>
                    <th>Rating</th>
                </thead>

                <tbody>
                    <tr>
                        <td>Punctuality</td>
                        <td>{{ $psychomotor->punctuality or '' }}</td>
                    </tr>
                    <tr>
                        <td>Neatness</td>
                        <td>{{ $psychomotor->neatness or '' }}</td>
                    </tr>
                    <tr>
                        <td>Politeness</td>
                        <td>{{ $psychomotor->politeness or '' }}</td>
                    </tr>
                    <tr>
                        <td>Cooperation with others</td>
                        <td>{{ $psychomotor->cooperation or '' }}</td>
                    </tr>
                    <tr>
                        <td>Leadership</td>
                        <td>{{ $psychomotor->leadership or '' }}</td>
                    </tr>
                </tbody>
            </table>
    </div>
    <div class="col-xs-3">
            <table class="table table-bordered small result-table">
                <thead>
                    <th>Pratical Skills</th>
                    <th>Rating</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Emotional Stability</td>
                        <td>{{ $psychomotor->emotional_stability or '' }}</td>
                    </tr>
                    <tr>
                        <td>Health</td>
                        <td>{{ $psychomotor->health or '' }}</td>
                    </tr>
                    <tr>
                        <td>Attentiveness</td>
                        <td>{{ $psychomotor->attentiveness or '' }}</td>
                    </tr>
                    <tr>
                        <td>Attitude to work</td>
                        <td>{{ $psychomotor->attitude_to_work or '' }}</td>
                    </tr>

                </tbody>
            </table>
    </div>
        <div class="col-xs-3">

            <canvas id="barChart" heigth="150px"></canvas>

        </div>

</div>
<table class="table table-bordered small result-table">
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


<table class="table small result-table">
            <tr>
                <td colspan="2">Class Teacher's Comment: <strong><em class="text-right">{{ $comment->body or '' }}</em></strong></td>
                {{--<td height="10" style="text-align: left;" colspan="3">{{ "" }}</td>--}}
                {{--<td height="20" style="text-align: left;" colspan="3">{{ class_teacher_remark(round($student->term_percentage($results))) }}</td>--}}
            </tr>
            <tr>
                <td>Date: <strong><em> {{ date('m - d - Y') }} </em></strong></td>
                <td>Signature</td>
                {{--<td><img src="{{ asset('img/sign.png') }}" height="35px"></td>--}}

            </tr>

            <tr>
                <td colspan="2">Head Teacher's Comment: <strong><em>{{ head_teacher_remark(round($student->term_percentage($results))) . ". "}} {{ $student->status == "promoting" ? "Promoted to " . $student->classroom->level->name . " ". $student->classroom->name : " " }} {{ $student->status == "repeating" ? "Repeated to " . $student->classroom->level->name . " ". $student->classroom->name : " " }}</em></strong></td>
                {{--<td height="20" style="text-align: left;" colspan="3">{{ "" }}</td>--}}
            </tr>
            <tr>
                <td>Date</td>
                <td>Signature</td>
                {{--<td><img src="{{ asset('img/sign.png') }}" height="35px"></td>--}}
            </tr>
            <tr>
                <td>Next Term Begin: <strong><em>11th, September 2017</em></strong></td>
                <td>Next Term Fee: {{  'N' . number_format($student->next_term_charges('third')) }}</td>
            </tr>
        </table>


@endsection