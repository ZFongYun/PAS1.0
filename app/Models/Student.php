<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    protected $table = 'student';  //指定資料表

    protected $fillable = [
        'student_ID','name','class','password','team_id','role','position'  //欄位
    ];

    public function student_score(){
        return $this->hasMany('App\Models\StudentScore');
    }

    public function student_scoring_peer(){  //評分者
        return $this->hasMany('App\Models\StudentScoringPeer');
    }

    public function peer_is_student_object(){  //學生評分目標 studnet_scoring_peer.object_student_id
        return $this->hasMany('App\Models\StudentScoringPeer');
    }

    public function student_is_teacher_object(){  //老師評分目標 teacher_scoring_student.object_student_id
        return $this->hasMany('App\Models\StudentScoringPeer');
    }

    public function student_scoring_team(){  //評分者
        return $this->hasMany('App\Models\StudentScoringTeam');
    }

    public function team(){
        return $this->belongsTo('App\Models\Team','team_id');
    }

    public function team_member(){
        return $this->hasMany('App\Models\TeamMember');
    }
}
