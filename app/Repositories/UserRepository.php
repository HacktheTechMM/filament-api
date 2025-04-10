<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository{

    public function updateUser($data,$id){
        $user=User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function uploadImage($data){
        $user=auth()->user();
        if ($user->avatar_url) {
         throw new \Exception('User already has an avatar');
        }else {
            $user->avatar_url=$data['avatar_url'];
            $user->save();
            return $user;
        }

    }

    public function getUser($id){
        $user=User::findOrFail($id);
        return $user;
    }

}
