<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Merchant;
use App\Models\Offer;
use App\Models\Physicallyapprove;
use App\Models\UserCommission;
use App\Models\User;
use App\Models\Qrcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class UserCommissionController extends Controller
{
      //Commission List
      public function showCommissionList(){
        $physicallyApprove = Physicallyapprove::where('status','pending')->get();

        return view('backend.userCommission.pendingList',compact('physicallyApprove'));
    }
    public function showUserCommission($id){
        $admin = Admin::where('merchant_id', '0')
        ->orWhereNull('merchant_id')
        ->get();
        // dd($admin);
        $offer = Offer::all();

//        $user = Qrcode::select('user_id', 'id')
//            ->with('user')
//            ->get();
        $uniqueUsers = DB::table('qrcodes')
            ->join('users', 'qrcodes.user_id', '=', 'users.id')
            ->select('users.id', 'users.name')
            ->distinct()
            ->get();
        $merchant = Merchant::all();
        $physicallyApprove = Physicallyapprove::find($id);
        // dd($physicallyApprove[0]->admin_id);
        return view('backend.userCommission.userCommission',compact('admin','offer','uniqueUsers','physicallyApprove','merchant'));
    }
    public function userCommissionStore(Request $request,$id){

        DB::beginTransaction(); 
        try {
            UserCommission::create([
                'fixed_amount' => $request->fixed_amount,
                'percentage_amount' => $request->percentage_amount,
                // 'admin_id' => $request->admin_id,
                'user_id' => $request->user_id,
                'offer_title_id' => $request->offer_title_id,
            ]);
            $physicallyA = Physicallyapprove::find($id);
            $physicallyA->update([
                'status' => 'approved'
            ]);

            // $adminID = Auth::guard('admin')->user()->id;
            // if ($adminID) {

            //     $admin = Admin::find($adminID);
            //     $admin->balance -= (float)$request->fixed_amount;
            //     $admin->balance -= (float)$request->percentage_amount;
            //     $admin->save();
            // }

            // $qrCodes = DB::table('qrcodes')->where('offer_id', $request->offer_title_id)->get();
            // foreach ($qrCodes as $qrCode) {
            //     $user_name = $qrCode->user_id;
            //     if ($user_name) {
            //         $user = User::find($user_name);
            //         $user->balance += (float)$request->fixed_amount;
            //         $user->balance += (float)$request->percentage_amount;
            //         $user->save();
            //     }
            // }
            $adminID = Auth::guard('admin')->user()->id;

if ($adminID) {
    $admin = Admin::find($adminID);
    $admin->balance -= (float)$request->fixed_amount;
    $admin->balance -= (float)$request->percentage_amount;
    $admin->save();
}

        // dd($request->user_id);
  
        
        // $qrCodes = DB::table('physicallyapproves')->where('offer_id',$request->offer_title_id)->get();
        // dd($qrCodes);
        $user_phone = $request->user_id;
        $user = User::where('phone',$user_phone)->get();
        foreach ($user as $users) {
            $user_id = $users->id;
            if ($user_id) {
                $user = User::find($user_id);
                $user->balance += (float)$request->fixed_amount;
                $user->balance += (float)$request->percentage_amount;
                $user->save();
            }
        }

            DB::commit();

            // Redirect or return a success response
            return redirect('/list-commission')->with('message', 'Commission added successfully');
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Handle the error, log it, and return an error response
            return redirect('/list-commission')->with('error', 'An error occurred while adding commission');
        }


    }

}
