<?php

namespace App\Http\Controllers\PartnerAuth;
use Auth;
use DB;
use Crypt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\AppHelper;
use App\Complain;
use App\ComplainFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;

class PartnerSupportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['partner','prevent-back-history']); 
    }

    protected function guard()
    {
        return Auth::guard('partner');
    }

    public function registerComplain(){

        $partner = $this->guard()->user();
        return view('common.register-complain')->with(compact('partner'));
    }

    public function insertRegisterComplain(Request $request){

        DB::transaction(function() use ($request){

        $data=DB::table('complains')
        ->select(\DB::raw('SUBSTRING(token_id,3) as token_id'))
        ->where("token_id", "LIKE", "TK%")->get();
        $year =( date('m') > 3) ? date('y').(date('y') + 1) : (date('y')-1).date('y');

        if (count($data) > 0) {

            $priceprod = array();
                foreach ($data as $key=>$data) {
                    $priceprod[$key]=$data->token_id;
                }
                $lastid= max($priceprod);
               
                $new_tokenid = (substr($lastid, 0, 4)== $year) ? 'TK'.($lastid + 1) : 'TK'.$year.'000001' ;
            //dd($new_tpid);
        } else {
            $new_tokenid = 'TK'.$year.'000001';
        }

        $complain= new Complain;
        $complain->token_id=$new_tokenid;
        $complain->username=$this->guard()->user()->spoc_name;
        $complain->userid=$this->guard()->user()->tp_id;
        $complain->rel_id=$this->guard()->user()->id;
        $complain->rel_with="partner";
        $complain->subject=$request->subject;
        $complain->issue=$request->issue;
        $complain->description=$request->description;
        $complain->stage="Initiated";

        $complain->save();

        if($request->hasFile('screen_shot')){
            foreach ($request->screen_shot as $screen_shot) {
               $complain_file=new ComplainFile;
               $complain_file->cmp_id=$complain->id;
               $complain_file->screen_shot=Storage::disk('myDisk')->put('/complainfile', $screen_shot);
               $complain_file->save();
            }   
        }
        alert()->success("We have Received your Complain (ID:<span style='color:blue;font-weight:bold'>".$new_tokenid."</span> ).<br> We will get back to you shortly.", 'Job Done')->html()->autoclose(6000);
        });

         return Redirect()->back();

        
    }

    public function myComplain(){
        $complain=Complain::where([['rel_with','=','partner'],['rel_id','=',$this->guard()->user()->id]])->get();
        $partner = $this->guard()->user();
        return view('common.my-complain')->with(compact('complain','partner'));

    }

    public function viewComplain($id){
        $id= AppHelper::instance()->decryptThis($id);
        $complain=Complain::findOrFail($id);
        $partner = $this->guard()->user();
        return view('common.view-complain-details')->with(compact('complain','partner'));
    }
}
