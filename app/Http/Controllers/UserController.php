<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Partner;
use App\County;

class UserController extends Controller
{
    public function index(){

        $users = User::with('partner')->with('county')->with('facility')->get();
        $partners = Partner::all();
        $counties = County::all();

        $data = array(
            'users' =>$users,
            'counties' => $counties,
            'partners' => $partners,
        );


        return view('users.users')->with($data);
    }

    public function adduserform(){

        $partners = Partner::all();
        $counties = County::all();

        $data = array(
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
            $user->update_at = date('Y-m-d H:i:s');

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
            $user->update_at = date('Y-m-d H:i:s');

            if($user->save()){
                
                return response(['status' => 'success', 'details' => 'User has been reset successfully']);
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
