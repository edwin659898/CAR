<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeptApprovalController extends Controller
{
    public function Forestry()
    {

        $Selectedsite = 'Forestry';
        return view('car.Dept-approval', compact('Selectedsite'));
    }

    public function FSC()
    {

        $Selectedsite = 'FSC';
        return view('car.Dept-approval', compact('Selectedsite'));
    }

    public function Operations()
    {

        $Selectedsite = 'Operations';
        return view('car.Dept-approval', compact('Selectedsite'));
    }

    public function HR()
    {

        $Selectedsite = 'HR';
        return view('car.Dept-approval', compact('Selectedsite'));
    }

    public function IT()
    {

        $Selectedsite = 'IT';
        return view('car.Dept-approval', compact('Selectedsite'));
    }

    public function Communications()
    {

        $Selectedsite = 'Communications';
        return view('car.Dept-approval', compact('Selectedsite'));
    }

    public function Miti_Magazine()
    {

        $Selectedsite = 'Miti Magazine';
        return view('car.Dept-approval', compact('Selectedsite'));
    }

    public function Accounts()
    {

        $Selectedsite = 'Accounts';
        return view('car.Dept-approval', compact('Selectedsite'));
    }

    public function ME()
    {

        $Selectedsite = 'ME';
        return view('car.Dept-approval', compact('Selectedsite'));
    }

    public function QC()
    {

        $Selectedsite = 'Quality Coodinator';
        return view('car.Dept-approval', compact('Selectedsite'));
    }

}
