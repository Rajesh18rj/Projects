<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageDashboardController extends Controller
{
    public function __invoke()
        {
            $purchasedCourses = auth()->user()->courses;            #this (courses) get from User Model method , we define how this method gonna work
            

            return view('dashboard',compact('purchasedCourses'));
        }
}
