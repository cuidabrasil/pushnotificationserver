<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard')
            ->with('profilesTotal', array())
            ->with('profilesTotalThisWeek', array())
            ->with('profilesTotalThisWeekPercent', array())
            ->with('profilesTotalJuridica', array())
            ->with('profilesTotalFisica', array())
            ->with('profilesDate', array())
            ->with('arrayLast7Days_F', array())
            ->with('arrayLast7Days_J', array());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAchei()
    {
        $partnerTotal = \App\Models\Partners::count();
        $matchsTotal = \App\Models\PartnerMatchs::count() / 2;
        $partnerTotalCompleto = \App\Models\Partners::whereNotNull('products')->whereNotNull('interests')->count();
        //$noMatchsTotal = ($matchsTotal > 0 ? $matchsTotal/2 : 0 );
        $noMatchsTotal = \App\Models\PartnerMatchs::distinct('user_one')->count();

        return view('dashboard_achei')
            ->with('partnerTotal', $partnerTotal)
            ->with('matchsTotal', $matchsTotal)
            ->with('partnerTotalCompleto', $partnerTotalCompleto)
            ->with('noMatchsTotal', ($partnerTotalCompleto - $noMatchsTotal));
    }
}
