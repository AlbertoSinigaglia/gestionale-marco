<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
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
        /*
SELECT clients.id, COALESCE(SUM(works.cost), 0) amount
from clients left join (
    Select works.id, works.client_id, COALESCE(TIMESTAMPDIFF(MINUTE,works.begin_at,works.finish_at), 0) / 60 * (clients.worker_cost_hourly * works.number_of_workers + works.machines * 			clients.machine_cost_hourly) as cost
	from works join clients on works.client_id = clients.id
    where works.paid = 0
) as works on works.client_id = clients.id

group by clients.id
*/

        /*$all = Client::query()->leftJoinSub(function(Builder $sub){
            $sub->selectRaw("
 clients.id, FORMAT(COALESCE(SUM(works.cost), 0),2) amount
from clients left join (
    Select works.id, works.client_id, COALESCE(TIMESTAMPDIFF(MINUTE,works.begin_at,works.finish_at), 0) / 60 * (clients.worker_cost_hourly * works.number_of_workers + works.machines * 			clients.machine_cost_hourly) as cost
	from works join clients on works.client_id = clients.id
    where works.paid = 0
) as works on works.client_id = clients.id

group by clients.id
            ");
        }, 'c1', function ($join) {
            $join->on('clients.id', '=', 'c1.id');
        })->orderBy('name')->get();*/
        $all = Client::orderBy('name')->get();
        return view('home')
            ->with('clients', $all);
    }



}
