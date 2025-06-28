<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormEntry extends Model
{
    use HasFactory;

    protected $table = 'form_entrys';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'kana_name',
        'phone_number',
        'birth_day',
        'email',
        'additional_info',
        'gender',
        'address',
        'job_number',
        'applied_at'
    ];

    public function getAppliedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y/m/d H:i');
    }
}
