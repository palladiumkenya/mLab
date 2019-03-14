<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Partner;
use App\SubCounty;
use App\County;
use App\Facility;
use Auth;

class UserController extends Controller
{
    public function index(){

        $users = User::with('partner')->with('county')->with('facility.sub_county.county')->where('status', '!=', 'Deleted');
        if(Auth::user()->user_level == 2){
            $users->where('user_level', '>', 2)->where('partner_id', Auth::user()->partner->id); 
            $facilities = Facility::where('partner_id', Auth::user()->partner->id)->get();
        }
        if(Auth::user()->user_level == 3){
            $users->where('user_level', '=', 4)->where('facility_id', Auth::user()->facility->code); 
            $facilities = [];
        }
        $partners = Partner::all();
        if(Auth::user()->user_level < 2){
            $counties = County::all();
            $facilities =[];
        }
        else{
            $cs= SubCounty::join("health_facilities", "health_facilities.Sub_County_ID",  "=",  "sub_county.id")
                ->select('sub_county.county_id')
                ->where('health_facilities.partner_id', Auth::user()->partner->id)
                ->get();


            $cids = [];

            foreach($cs AS $c){
                array_push($cids, $c->county_id);
            }

            $cn = array_unique($cids);

            
            $counties = County::whereIn('id', $cn)->get();
        }

        $subcounties = SubCounty::all();

        $data = array(
            'users' =>$users->get(),
            'counties' => $counties,
            'partners' => $partners,
            'subcounties' => $subcounties,
            'facilities' => $facilities,
            
        );


        return view('users.users')->with($data);
    }

    public function adduserform(){
        $partners = Partner::all();
        $facilities =[];
        if(Auth::user()->user_level < 2){
            $counties = County::all();
        }
        else{
            
            $facilities = Facility::where('partner_id', Auth::user()->partner->id)->get();
            $cs= SubCounty::join("health_facilities", "health_facilities.Sub_County_ID",  "=",  "sub_county.id")
                ->select('sub_county.county_id')
                ->where('health_facilities.partner_id', Auth::user()->partner->id)
                ->get();


            $cids = [];

            foreach($cs AS $c){
                array_push($cids, $c->county_id);
            }

            $cn = array_unique($cids);

            
            $counties = County::whereIn('id', $cn)->get();
        }


        $data = array(
            'facilities' => $facilities,
            'counties' => $counties,
            'partners' => $partners,
        );
        return view('users.adduser')->with($data);
    }

    public function adduser(Request $request){
        try{
            $user = new User;

            $user->f_name = $request->fname;
            $user->l_name = $request->lname;
            $user->email = $request->email;
            $user->phone_no = $request->phone;
            $user->user_level = $request->level;
            if($request->level =='2'){
                $user->partner_id = $request->partner_id;
            }
            if($request->level =='5'){
                $user->county_id = $request->county_id;
            }
            if($request->level =='3'){
                $user->partner_id = Auth::user()->partner->id;
                $user->facility_id = $request->facility_id;
            }
            if($request->level =='4'){
                $user->partner_id = Auth::user()->partner->id;
                $user->facility_id = Auth::user()->facility->code;
            }
            $user->password = bcrypt($request->phone);
            $user->first_login = "Yes";
            $user->status = "Active";

            $msg = "Hello ".$request->fname.", you have been registered successfully on mLab System ".
                "You can access the system at mlab.mhealthkenya.co.ke with Username:".$request->email." and Password: $request->phone";

            $to =$request->phone; 

            if($user->save()){

                $sender = new SenderController;
                $sender->send($to, $msg);

                toastr()->success('User has been saved successfully!');

                return redirect()->route('users');
            }else{
                toastr()->error('An error has occurred please try again later.');

                return back();
            }
        }catch(Exception $e){
            toastr()->error('An error has occurred please try again later.');

            return back();
        }


    }

    public function edituser(Request $request){
        try{
            $user = User::find($request->id);
            if(!empty($request->fname)){
                $user->f_name = $request->fname;
            }
            if(!empty($request->lname)){
                $user->l_name = $request->lname;
            }
            if(!empty($request->email)){
                $user->email = $request->email;
            }
            if(!empty($request->phone)){
                $user->phone_no = $request->phone;
            }
            if(!empty($request->level)){
            $user->user_level = $request->level;
            }
            if($request->level =='2'){
                $user->partner_id = $request->partner_id;
            }
            if($request->level =='5'){
                $user->county_id = $request->county_id;
            }
            if($request->level =='3'){
                $user->facility_id = $request->code;
                $user->partner_id = Auth::user()->partner->id;
            }
            $user->status = $request->status;
            $user->updated_at = date('Y-m-d H:i:s');

            if($user->save()){
                toastr()->success('User has been edited successfully!');

                return redirect()->route('users');
            }else{
                toastr()->error('An error has occurred please try again later.');

                return back();
            }
        }catch(Exception $e){
            toastr()->error('An error has occurred please try again later.');

            return back();
        }


    }

    public function resetuser(Request $request){
        try{
            $user = User::find($request->uid);
            $user->password = bcrypt($user->phone_no);
            $user->first_login = 'Yes';
            $user->updated_at = date('Y-m-d H:i:s');

            if($user->save()){
                
                return response(['status' => 'success', 'details' => 'User has been reset successfully']);
            }else{
                return response(['status' => 'error', 'details' => 'An error has occurred please try again later.']);
            }
        }catch(Exception $e){
            return response(['status' => 'error', 'details' => 'An error has occurred please try again later.']);
        }
    }

    public function deleteuser(Request $request){
        try{
            $user = User::find($request->uid);
            $user->status = "Deleted";
            $user->updated_at = date('Y-m-d H:i:s');

            if($user->save()){
                
                return response(['status' => 'success', 'details' => 'User has been Deleted successfully']);
            }else{
                return response(['status' => 'error', 'details' => 'An error has occurred please try again later.']);
            }
        }catch(Exception $e){
            return response(['status' => 'error', 'details' => 'An error has occurred please try again later.']);
        }
    }

    public function changepass(Request $request){
        try{

            $user = User::find($request->id);

            $user->password = bcrypt($request->new_password);
            $user->first_login = 'No';
            
            if($user->save()){
                toastr()->success('Password has been changed successfully!');

                return back();
            }else{
                toastr()->error('An error has occurred please try again later.');

                return back();
            }

        }catch(Exception $e){
            toastr()->error('An error has occurred please try again later.');

            return back();
        }
    }
}
