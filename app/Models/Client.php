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
        return number_format($this->works->reduce(function($tot, $el){
            if($el->paid) return $tot;
            $partial = $el->number_of_workers * $this->worker_cost_hourly;
            if($el->machines)
                $partial += $this->machine_cost_hourly;
            return $tot + $el->begin_at->floatDiffInRealHours($el->finish_at) * $partial;
        }, 0), 2, '.', ',');
    }
}
