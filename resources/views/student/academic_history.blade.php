@extends('layouts.app')

@section('title', 'Student')

@section('styles')
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">
@endsection

@section('page-heading')
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Student</h2>
            <ol class="breadcrumb">
                <li class="active">
                    <a href="{{ url('Student') }}">Home</a>
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
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>View Summary</h5>
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
                    <div class="text-center">
                        <button data-toggle="modal" class="btn btn-primary" href="#modal-form">View summary</button>
                    </div>
                    {{--<div id="modal-form" class="modal modal-lg">--}}

                        {{--<div class="modal-content">--}}
                            {{--<div class="modal-body">--}}
                                {{--<div id="morris-line-chart"></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                </div>
            </div>
        </div>


            <div class="col-lg-9">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Select session to view results</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form role="form" class="form-inline">
                            <div class="form-group">
                                <label>Session</label>
                                <select name="session_id" class="form-control">
                                    <option value="">--select session--</option>
                                    @foreach($sessions as $session)
                                        <option value="{{ $session->id }}">{{ $session->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Term</label>
                                <select name="session_id" class="form-control">
                                    <option value="all">All</option>
                                    <option value="first">First</option>
                                    <option value="second">Second</option>
                                    <option value="third">Third</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button class="btn btn-primary" type="submit">Show results</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>

</div>
@endsection



@section('scripts')
<script src=" {{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>

<!-- Morris -->
<script src="{{ asset('js/plugins/morris/raphael-2.1.0.min.js') }}"></script>
<script src="{{ asset('js/plugins/morris/morris.js') }}"></script>

<script>
 $(document).ready(function(){

        $(function() {

            Morris.Line({
                element: 'morris-line-chart',
                data: [{ y: '2006', a: 100, b: 90 },
                    { y: '2007', a: 75, b: 65 },
                    { y: '2008', a: 50, b: 40 },
                    { y: '2009', a: 75, b: 65 },
                    { y: '2010', a: 50, b: 40 },
                    { y: '2011', a: 75, b: 65 },
                    { y: '2012', a: 100, b: 90 } ],
                xkey: 'y',
                ykeys: ['a', 'b'],
                labels: ['Series A', 'Series B'],
                hideHover: 'auto',
                resize: true,
                lineColors: ['#54cdb4','#1ab394'],
            });

        });


})


</script>

@endsection