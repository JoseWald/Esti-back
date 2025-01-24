<?php

namespace App\Models;


use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Registration extends Model
{
    use HasApiTokens , HasFactory , Notifiable;

    protected $fillable = [
        'photo_path',
        'year',
        'department',
        'first_name',
        'last_name',
        'birth_date',
        'birth_place',
        'address',
        'nationality',
        'phone',
        'email',
        'father_name',
        'father_job',
        'mother_name',
        'mother_job',
        'parent_contact',
        'invoice_path',
        'grade_sheet_path',
        'state'
    ];
}
