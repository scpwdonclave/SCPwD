<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;

class BatchAssessment extends Model
{
    public function candidateMarks(){
        return $this->hasMany('App\CandidateMark', 'bt_assessment_id');
    }
    public function batch(){
        return $this->belongsTo('App\Batch', 'bt_id');
    }

     
}
