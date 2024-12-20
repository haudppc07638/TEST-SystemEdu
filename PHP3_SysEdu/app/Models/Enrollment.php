<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $table = 'enrollments';

    protected $fillable = [
        'full_name',
        'date_of_birth',
        'gender',
        'nation',
        'identity_card',
        'card_issuance_date',
        'card_location',
        'province_city',
        'district',
        'commune_level',
        'house_number',
        'phone',
        'email',
        'sponsor_name',
        'sponsor_phone',
        'first_major_id',
        'application_method_1',
        'second_major_id',
        'application_method_2',
        'year_graduation',
        'provice_city_graduate',
        'district_graduate',
        'commune_level_graduate',
        'recipient',
        'address',
        'front_id_card',
        'back_id_card',
        'graduation_certificate',
    ];
}
