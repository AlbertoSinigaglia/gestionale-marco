<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $all = Work::orderBy('created_at', 'desc')->get();
        $total = $all->reduce(function($tot, $el){
            if($el->paid) return $tot;
            $partial = $el->number_of_workers * 8;
            if($el->machines)
                $partial += 5;
            return $tot + $el->begin_at->floatDiffInRealHours($el->finish_at) * $partial;
        }, 0);
        return view('home')
            ->with('works', Work::orderBy('created_at', 'desc')->get())
            ->with('total', $total);
    }
    public function create(Request $request){
        if(Carbon::parse($request->begin_at)->greaterThan(Carbon::parse($request->finish_at))){
            return redirect()->back()->withErrors([
                'date' => "L'ora di inizio non può essere successiva all'ora di fine"
            ])->withInput($request->all());
        }

        Work::create($this->normalizeInput($request)->toArray());
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
        return view('edit')->with('work', $work);
    }
    public function update(Work $work, Request $request){
        if(Carbon::parse($request->begin_at)->greaterThan(Carbon::parse($request->finish_at))){
            return redirect()->back()->withErrors([
                'date' => "L'ora di inizio non può essere successiva all'ora di fine"
            ])->withInput($request->all());
        }

        $work->update($this->normalizeInput($request)->toArray());
        return redirect()->route('home');
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
            'day'
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
