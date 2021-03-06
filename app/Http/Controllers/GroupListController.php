<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $teamName = Team::all('name')->toArray();
        $teamId = Team::all('id')->toArray();

        $team_length = count($teamId);

        $arr_leader = array();
        $arr_member = array();
        $arr_team = array($teamName);
        $arr_id = array($teamId);

//        foreach ($teamId as $id){
//            $student = Student::whereHas('team',function ($q) use ($id) {
//                $q->where('team_id',$id);
//            })->get(['name','role'])->toArray();
//            $student_length = count($student);
//            $leader = "";
//            $member = "";
//
//            for ($i = 0; $i < $student_length; $i++){
//                if ($student[$i]['role'] == 0){
//                    $leader = $leader." ".$student[$i]['name'];
//                }else if($student[$i]['role'] == 1){
//                    $member = $member." ".$student[$i]['name'];
//                }
//
//            }
//            array_push($arr_leader,$leader);
//            array_push($arr_member,$member);
//        }
        foreach ($teamId as $id){
            $team_member = TeamMember::with(array('student'=>function($query){
                $query->select('id','name');
            }))->whereHas('team',function ($q) use ($id) {
                $q->where('team_id',$id);
            })->get(['student_id','role'])->toArray();
            $student_length = count($team_member);
            $leader = "";
            $member = "";
            for ($i = 0; $i < $student_length; $i++){
                if ($team_member[$i]['role'] == 0){
                    $leader = $leader." ".$team_member[$i]['student']['name'];
                }else if($team_member[$i]['role'] == 1){
                    $member = $member." ".$team_member[$i]['student']['name'];
                }
            }
            array_push($arr_leader,$leader);
            array_push($arr_member,$member);
        }

        return view('teacher_frontend.GroupList',compact('arr_id','arr_team','arr_leader','arr_member','team_length'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $student = Student::where('team_id',null)->get();
        return view('teacher_frontend.GroupListCreate',compact('student'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(isset($_POST['student'])){
            $leader = 0;
            $member = 0;

            foreach($_POST['student'] as $studentId){
                $role = $request->input('role'.$studentId);
                if($role==0){
                    $leader++;
                }else{
                    $member++;
                }
            }
            if($leader != 0){
                if($leader >=2){
                    // ????????????
                    return back()->with('error','?????????????????????????????????');
                }else{
                    // ????????????
                    $team_name = $request->input('name');
                    $team = new Team;
                    $team -> name = $team_name;
                    $team -> save();
                    $team_id = Team::where('name',$team_name)->value('id');

                    foreach($_POST['student'] as $studentId){
                        $role = $request->input('role'.$studentId);
                        $position = $request->input('position'.$studentId);

                        $team_member = new TeamMember;
                        $team_member -> student_id = $studentId;
                        $team_member -> team_id = $team_id;
                        $team_member -> role = $role;
                        $team_member -> position = $position;
                        $team_member -> save();
                        $student = Student::find($studentId);
//                        $student -> role = $role;
//                        $student -> position = $position;
                        $student -> team_id = $team_id;
                        $student -> save();
                    }
                    return redirect('GroupList');
                }
            }else{
                // ???????????????
                return back()->with('repeat','???????????????');
            }
        }else{
            return back()->with('warning','???????????????');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team_name = Team::where('id',$id)->value('name');
//        $student = Student::whereHas('team',function ($q) use ($id) {
//            $q->where('team_id',$id);
//        })->get(['id','name','student_id','role','position'])->toArray();
//        $student_length = count($student);

        $team_member = TeamMember::with(array('student'=>function($query){
            $query->select('id','name','student_id');
        }))->with(array('team'=>function($query){
            $query->select('id','name');
        }))->whereHas('team',function ($q) use ($id) {
            $q->where('team_id',$id);
        })->get(['id','student_id','team_id','role','position'])->toArray();
        $team_member_length = count($team_member);

        return view('teacher_frontend.GroupListShow',compact('team_name','team_member_length','team_member'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team_name = Team::where('id',$id)->value('name');
        $team_id = Team::where('id',$id)->value('id');
//        $student = Student::whereHas('team',function ($q) use ($id) {
//            $q->where('team_id',$id);
//        })->get(['id','name','student_id','role','position'])->toArray();
//        $student_length = count($student);

        $team_member = TeamMember::with(array('student'=>function($query){
            $query->select('id','name','student_id');
        }))->with(array('team'=>function($query){
            $query->select('id','name');
        }))->whereHas('team',function ($q) use ($id) {
            $q->where('team_id',$id);
        })->get(['id','student_id','team_id','role','position'])->toArray();
        $team_member_length = count($team_member);

        return view('teacher_frontend.GroupListEdit',compact('team_name','team_id','team_member_length','team_member'));
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
        $leader = 0;
        $member = 0;
        foreach($_POST['hidden_id'] as $hiddenId){
            $role = $request->input('role'.$hiddenId);
            if($role==0){
                $leader++;
            }else{
                $member++;
            }
        }
        if($leader != 0){
            if($leader >=2){
                // ????????????
                return back()->with('error','?????????????????????????????????');
            }else{
                // ???????????? ????????????
                foreach($_POST['hidden_id'] as $hiddenId){
                    $role = $request->input('role'.$hiddenId);
                    $position = $request->input('position'.$hiddenId);
                    $team_name = $request->input('name');

                    $team = Team::find($id);
                    $team -> name = $team_name;
                    $team -> save();

//                    $student = Student::find($hiddenId);
//                    $student -> role = $role;
//                    $student -> position = $position;
//                    $student -> save();
                    $team_member = TeamMember::find($hiddenId);
                    $team_member -> role = $role;
                    $team_member -> position = $position;
                    $team_member -> save();
                }

                return redirect('GroupList');
            }
        }else{
            // ???????????????
            return back()->with('repeat','???????????????');
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $student = DB::table('student')->where('team_id', '=', $id)
//            ->update(array('team_id' => null,'role' => null,'position' => null));
        $student = DB::table('student')->where('team_id', '=', $id)
            ->update(array('team_id' => null));

        $team_member = TeamMember::where('team_id',$id)->delete();

        $team = Team::find($id);
        $team -> delete();

        return redirect('GroupList');

    }

    public function plus_page($id)
    {
        $team_name = Team::where('id',$id)->value('name');
        $team_id = Team::where('id',$id)->value('id');
        $student = Student::where('team_id',null)->get();
        return view('teacher_frontend.GroupListPlus',compact('team_name','team_id','student'));
    }

    public function plus(Request $request,$id)
    {
        if(isset($_POST['student'])){
            foreach($_POST['student'] as $studentId){
                $position = $request->input('position'.$studentId);
                $student = Student::find($studentId);
//                $student -> position = $position;
//                $student -> role = '1';  //????????????
                $student -> team_id = $id;
                $student -> save();

                $team_member = new TeamMember;
                $team_member -> student_id = $studentId;
                $team_member -> team_id = $id;
                $team_member -> role = '1';
                $team_member -> position = $position;
                $team_member -> save();
            }
            return redirect('GroupList');
        }else{
            return back()->with('warning','???????????????');
        }
    }

    public function destroy_member($id)
    {
        $student = Student::find($id);
        $student -> team_id = null;
//        $student -> role = null;
//        $student -> position = null;
        $student -> save();

        $team_member = TeamMember::where('student_id',$id)->first();
        $team_member -> delete();

        return back();
    }
}
