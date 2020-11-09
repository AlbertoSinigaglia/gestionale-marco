<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create(Request $request, Client $client){
        if(Carbon::parse($request->begin_at)->greaterThan(Carbon::parse($request->finish_at))){
            return redirect()->back()->withErrors([
                'date' => "L'ora di inizio non può essere successiva all'ora di fine"
            ])->withInput($request->all());
        }

        $client->works()->create($this->normalizeInput($request)->toArray());
        return redirect()->back();
    }
    public function toggle(Work $work){
        $work->update([
            'paid' => !$work->paid
        ]);
        return redirect()->back();
    }
    public function delete(Work $work){
        $work->forceDelete();
        return redirect()->back();
    }
    public function edit(Work $work){
        return view('work.edit')->with('work', $work);
    }
    public function update(Work $work, Request $request){
        if(Carbon::parse($request->begin_at)->greaterThan(Carbon::parse($request->finish_at))){
            return redirect()->back()->withErrors([
                'date' => "L'ora di inizio non può essere successiva all'ora di fine"
            ])->withInput($request->all());
        }

        $work->update($this->normalizeInput($request)->toArray());
        return redirect()->route('client', ['client' => $work->client->id]);
    }

    /**
     * @param Request $request
     */
    public function normalizeInput(Request $request): \Illuminate\Support\Collection
    {
        $data = collect($request->only([
            'number_of_workers',
            'machines',
            'paid',
            'begin_at',
            'finish_at',
            'day',
            'disposal',
            'description'
        ]));
        if ($data->has('machines'))
            $data->put('machines', 1);
        else
            $data->put('machines', 0);


        if ($data->has('paid'))
            $data->put('paid', 1);
        else
            $data->put('paid', 0);
        return $data;
    }
}
