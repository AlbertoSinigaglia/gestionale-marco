<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;
    protected $table = 'works';
    protected $guarded = [];
    protected $casts = [
        'paid' => 'boolean',
        'machines' => 'boolean',
        'day' => 'date',
    ];
    public function getBeginAtAttribute($value){
        return Carbon::createFromTimeString($value);
    }
    public function getFinishAtAttribute($value){
        return Carbon::createFromTimeString($value);
    }
}
