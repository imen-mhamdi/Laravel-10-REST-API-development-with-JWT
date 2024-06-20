<?php
namespace App\Customs\Services;

use Illuminate\Support\Facades\Hash;


class PasswordService {

    private function validateCurrentPassword($current_password){
        if(!password_verify($current_password,auth()->user()->password)){
            response()->json([
                'status'=>'failed',
                'message'=>"Password didn't match the current password",
            ])->send();
            exit;
        }
    }
    
    public function changePassword($data)
    {

       #password current_password
       $this->validateCurrentPassword($data['current_password']);
       $updatePassword=auth()->user()->update([
        'password'=>Hash::make($data['password'])
       ]);
       if ($updatePassword){
        return response()->json([
            'status'=>'success',
            'message'=>'password updated successfuly'
        ]);
       }else {
        return response()->json([
            'status'=>'failed',
            'message'=>'an error occured while updating password '
        ]);
       }
    }
}
