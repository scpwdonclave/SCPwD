<?php
 
namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BatchAssessment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function candidateMarks(){
        return $this->hasMany('App\CandidateMark', 'bt_assessment_id');
    }
    public function batch(){
        return $this->belongsTo('App\Batch', 'bt_id');
    }
      
}
