<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Request;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password'];

    public function GetCustomerID()
    {
        return self::where(
            'api_token',
            '=',
            Request::bearerToken()
        )->first();
    }

    public function UpdateProfile(
        $customer_id,
        $customer
    ) {
        $customerRec = self::find($customer_id);
        if ($customerRec) {
            $customerRec->firstname =
                $customer['firstname'];
            $customerRec->lastname =
                $customer['lastname'];
            $customerRec->email =
                $customer['email'];
            $customerRec->save();
        }
    }

    public function UpdateProfileImage(
        $customer_id,
        $filename
    ) {
        $customerRec = self::find($customer_id);
        if ($customerRec) {
            $customerRec->image = $filename;
                $customerRec->save();
    }
}