<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Student;
use App\Models\TeacherScoringStudent;
use App\Models\TeacherScoringTeam;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meeting = Meeting::all()->toArray();
        return view('teacher_frontend.meeting',compact('meeting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $team = Team::all()->toArray();
        return view('teacher_frontend.meetingCreate',compact('team'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $content = $request->input('content');
        $meeting_date = $request->input('meeting_date');
        $meeting_start = $request->input('meeting_start');
        $meeting_end = $request->input('meeting_end');
        $upload_date = $request->input('upload_date');
        $upload_time = $request->input('upload_time');
        $team = $request->input('team');
        $TS = $request->input('TS');
        $PA = $request->input('PA');
        $team_limit = $request->input('team_limit');
        $team_bonus = $request->input('team_bonus');
        $member_limit = $request->input('member_limit');
        $member_bonus = $request->input('member_bonus');

        $team_length = count($team);
        $team_chk = "";
        for($i=0; $i<$team_length; $i++){
            $team_chk = $team_chk . ' ' . $team[$i];
        }

        $meeting = new Meeting;
        $meeting -> name = $name;
        $meeting -> meeting_date = $meeting_date;
        $meeting -> meeting_start = $meeting_start;
        $meeting -> meeting_end = $meeting_end;
        $meeting -> content = $content;
        $meeting -> upload_date = $upload_date;
        $meeting -> upload_time = $upload_time;
        $meeting -> report_team = $team_chk;
        $meeting -> PA = $PA;
        $meeting -> TS = $TS;
        $meeting -> team_limit = $team_limit;
        $meeting -> team_bonus = $team_bonus;
        $meeting -> member_limit = $member_limit;
        $meeting -> member_bonus = $member_bonus;
        $meeting -> save();

        return redirect('/meeting');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $meeting = Meeting::find($id) -> toArray();
        $meeting_reportTeam = $meeting['report_team'];
        $team_chk_arr = explode(" ",$meeting_reportTeam);
        $report_team_show = array();
        for ($i = 1; $i < count($team_chk_arr); $i++){
            $team_name = Team::withTrashed()->where('id',$team_chk_arr[$i])->value('name');
            array_push($report_team_show, $team_name);
        }
        return view('teacher_frontend.meetingShow',compact('meeting','report_team_show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $meeting = Meeting::find($id) -> toArray();
        $team_chk = $meeting['report_team'];
        $team_chk_arr = explode(" ",$team_chk);
        $team_chk_length = count($team_chk_arr);
        $team = Team::all()->toArray();

        return view('teacher_frontend.meetingEdit',compact('meeting','team','team_chk_arr','team_chk_length'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = $request->input('name');
        $content = $request->input('content');
        $meeting_date = $request->input('meeting_date');
        $meeting_start = $request->input('meeting_start');
        $meeting_end = $request->input('meeting_end');
        $upload_date = $request->input('upload_date');
        $upload_time = $request->input('upload_time');
        $team = $request->input('team');
        $TS = $request->input('TS');
        $PA = $request->input('PA');
        $team_limit = $request->input('team_limit');
        $team_bonus = $request->input('team_bonus');
        $member_limit = $request->input('member_limit');
        $member_bonus = $request->input('member_bonus');

        $team_length = count($team);
        $team_chk = "";
        for($i=0; $i<$team_length; $i++){
            $team_chk = $team_chk . ' ' . $team[$i];
        }

        $meeting = Meeting::where('id','=',$id)->first();
        $meeting -> name = $name;
        $meeting -> meeting_date = $meeting_date;
        $meeting -> meeting_start = $meeting_start;
        $meeting -> meeting_end = $meeting_end;
        $meeting -> content = $content;
        $meeting -> upload_date = $upload_date;
        $meeting -> upload_time = $upload_time;
        $meeting -> report_team = $team_chk;
        $meeting -> PA = $PA;
        $meeting -> TS = $TS;
        $meeting -> team_limit = $team_limit;
        $meeting -> team_bonus = $team_bonus;
        $meeting -> member_limit = $member_limit;
        $meeting -> member_bonus = $member_bonus;
        $meeting -> save();

        return redirect('/meeting');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $meeting = Meeting::find($id);
        $meeting -> delete();
        return redirect('meeting');
    }

    public function scoring_page($id)
    {
        $meeting = Meeting::find($id)->toArray();
        $report_team = $meeting['report_team'];
        $report_team_arr = explode(' ',$report_team);
        $report_team_show = array();
        for ($i = 1; $i < count($report_team_arr); $i++){
            $team_name = Team::where('id',$report_team_arr[$i])->get()->toArray();
            array_push($report_team_show, $team_name);
        }
        return view('teacher_frontend.meetingScoring',compact('meeting','report_team','report_team_show'));
    }

    public function score(Request $request){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $team = $request->input('team');
            if ($team == '?????????'){
                $arr = ['null'];
                echo json_encode($arr);
            }else{
                $meeting_id = $request->input('meeting_id');
                $team_id = $team;
                $team_name = Team::where('id',$team_id)->value('name');
                $stu_id = DB::Table('team_member')
                    ->join('student','team_member.student_id','student.id')
                    ->where('team_member.team_id',$team_id)
                    ->where('team_member.deleted_at',null)
                    ->select('team_member.*','student.id','student.student_id','student.name')
                    ->get();
                $stu_id_length = count($stu_id);
                $arr = [];

                $scoring_team = TeacherScoringTeam::whereHas('meeting',function ($q) use ($meeting_id,$team_id){
                    $q->where('meeting_id',$meeting_id)->where('object_team_id',$team_id);
                })->get(['point','feedback'])->toArray();

                if ($scoring_team == null){
                    array_push($arr,$team_name,'0');

                }else{
                    array_push($arr,$team_name,$scoring_team);
                }

                for ($i=0; $i<$stu_id_length; $i++){
                    $scoring_student = TeacherScoringStudent::wherehas('meeting',function ($q)use($meeting_id,$stu_id,$i){
                        $q->where('meeting_id',$meeting_id)->where('object_student_id',$stu_id[$i]->id);

                    })->get(['point','feedback'])->toArray();
                    if ($scoring_student == null){
                        array_push($arr,$stu_id[$i],'0');
                    }
                    else{
                        array_push($arr,$stu_id[$i],$scoring_student);
                    }
                }
                echo json_encode($arr);
            }
        }
    }

    public function scoring_team(Request $request){
        $meeting_id = $request->input('meeting_id');
        $team_id = $request->input('team');
        $score = $request->input('score');
        $feedback = $request->input('feedback');

        $teacher_scoring_team = new TeacherScoringTeam;
        $teacher_scoring_team->meeting_id = $meeting_id;
        $teacher_scoring_team->raters_teacher_id = '1';
        $teacher_scoring_team->object_team_id = $team_id;
        $teacher_scoring_team->point = $score;
        $teacher_scoring_team->feedback = $feedback;
        $teacher_scoring_team->save();

        $arr = ['????????????'];
        echo json_encode($arr);
    }

    public function edit_team(Request $request){
        $meeting_id = $request->input('meeting_id');
        $team_id = $request->input('team');
        $score = $request->input('score');
        $feedback = $request->input('feedback');

        $teacher_scoring_team = TeacherScoringTeam::where('meeting_id',$meeting_id)->where('object_team_id',$team_id)->first();
        $teacher_scoring_team->point = $score;
        $teacher_scoring_team->feedback = $feedback;
        $teacher_scoring_team->save();

        $arr = ['????????????'];
        echo json_encode($arr);
    }

    public function scoring_stu(Request $request){
        $meeting_id = $request->input('meeting_id');
        $id = $request->input('id');
        $score = $request->input('score');
        $feedback = $request->input('feedback');

        $teacher_scoring_student = new TeacherScoringStudent;
        $teacher_scoring_student->meeting_id = $meeting_id;
        $teacher_scoring_student->raters_teacher_id = '1';
        $teacher_scoring_student->object_student_id = $id;
        $teacher_scoring_student->point = $score;
        $teacher_scoring_student->feedback = $feedback;
        $teacher_scoring_student->save();

        $arr = ['????????????'];
        echo json_encode($arr);
    }

    public function edit_stu(Request $request){
        $meeting_id = $request->input('meeting_id');
        $id = $request->input('id');
        $score = $request->input('score');
        $feedback = $request->input('feedback');

        $teacher_scoring_student = TeacherScoringStudent::where('meeting_id',$meeting_id)->where('object_student_id',$id)->first();
        $teacher_scoring_student->point = $score;
        $teacher_scoring_student->feedback = $feedback;
        $teacher_scoring_student->save();

        $arr = ['????????????'];

        echo json_encode($arr);
    }
}
