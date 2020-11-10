<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function works() : HasMany{
        return $this->hasMany(Work::class);
    }
    public function getAmountAttribute(){
        return number_format($this->works->reduce(function($tot, $work){
            if($work->paid) return $tot;
            $partial = $work->number_of_workers * $this->worker_cost_hourly;
            if($work->machines)
                $partial += $this->machine_cost_hourly;
            return $tot + $work->begin_at->floatDiffInRealHours($work->finish_at) * $partial + $work->disposal;
        }, 0), 2, '.', ',');
    }
    public function getTotalHoursToPayAttribute(){
        return $this->works->reduce(function($tot, $work){
            return $tot + $work->begin_at->floatDiffInRealHours($work->finish_at) * $work->number_of_workers;
        }, 0);
    }
}
