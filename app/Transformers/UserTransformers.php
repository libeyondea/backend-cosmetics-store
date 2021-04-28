<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;

class UserTransformers extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'user_name' => $user->user_name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'address' => $user->address,
            'district' => $user->district,
            'ward' => $user->ward,
            'city' => $user->city,
            'gender' => $user->gender,
            'avatar' => $user->avatar,
            'intro' => $user->intro,
            'profile' => $user->profile,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ];
    }
}
