@extends('student_frontend.layouts.master')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">會議</h4>
                    </div>
                        @foreach($meeting as $row)
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title m-t-0 m-b-10">{{$row['name']}}</h4>
                                    <p class="mb-0">報告繳交日期：{{$row['upload_date']."　".date("H : i",strtotime($row['upload_time']))}}</p>
                                    <p >會議日期：{{$row['meeting_date']."　".date("H : i",strtotime($row['meeting_start'])). " ~ " .date("H : i",strtotime($row['meeting_end']))}}</p>
                                    <a href="{{route('StuMeeting.show',$row['id'])}}" class="btn waves-effect btn-rounded waves-light btn-primary">詳情</a>
                                    @if(auth('student')->user()->role == 0)
                                        @if(strtotime(date("Y-m-d H:i:s")) < strtotime($row['upload_date'].' '.$row['upload_time']))
                                            @if($row[0]=='null')
                                                <a href="{{route('StuMeeting.report',$row['id'])}}" class="btn waves-effect btn-rounded waves-light btn-primary">繳交報告</a>
                                            @else
                                                <a href="{{route('StuMeeting.report',$row['id'])}}" class="btn waves-effect btn-rounded waves-light btn-custom">檢視報告</a>
                                            @endif
                                        @else
                                            <button class="btn btn-rounded btn-secondary disabled">停止繳交</button>
                                        @endif
                                    @else
                                        <a href="#" class="btn waves-effect btn-rounded waves-light btn-primary" style="display: none">繳交報告</a>
                                    @endif
                                    @if(strtotime(date("Y-m-d H:i:s")) > strtotime($row['meeting_date'].' '.$row['meeting_start']) && strtotime(date("Y-m-d H:i:s")) < strtotime($row['meeting_date'].' '.$row['meeting_end']))
                                        <a href="{{route('StuMeeting.scoring_page',$row['id'])}}" class="btn waves-effect btn-rounded waves-light btn-primary" onclick="return(confirm('！評分時間為會議開始至結束，請隨時注意評分時間！'))">進入評分</a>
                                    @else
                                        <a href="{{route('StuMeeting.scoring_page',$row['id'])}}" class="btn waves-effect btn-rounded waves-light btn-primary disabled" onclick="return(confirm('！評分時間為會議開始至結束，請隨時注意評分時間！'))">進入評分</a>
                                    @endif
                                </div>
                            </div>
                        </div><!-- end col -->
                        @endforeach
                    <!-- end row -->
                </div>
            </div> <!-- container-fluid -->
        </div> <!-- content -->
    </div>
@endsection
@section('title','會議')
