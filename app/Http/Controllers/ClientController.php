<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create(Request $request){
        Client::create($request->except('_token'));
        return redirect()->back();
    }
    public function works(Client $client){
        $all = $client->works()->orderBy('paid', 'asc')->orderBy('day', 'desc')->get();
        $total = $all->reduce(function($tot, $el) use ($client){
            if($el->paid) return $tot;
            $partial = $el->number_of_workers * $client->worker_cost_hourly;
            if($el->machines)
                $partial += $client->machine_cost_hourly;
            return $tot + $el->begin_at->floatDiffInRealHours($el->finish_at) * $partial;
        }, 0);
        return view('works')
            ->with('works', $all)
            ->with('client', $client)
            ->with('total', $total);
    }



    public function delete(Client $client){
        $client->forceDelete();
        return redirect()->back();
    }
    public function edit(Client $client){
        return view('client.edit')->with('client', $client);
    }
    public function update(Client $client, Request $request){
        $client->update($request->except('_token'));
        return redirect()->route('home');
    }
}
