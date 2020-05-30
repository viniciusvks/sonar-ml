<?php

namespace App\Http\Controllers;

use App\Models\Query;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $queries = Query::all();
        return view('home', ['queries' => $queries]);
    }

}
