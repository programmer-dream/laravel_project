<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Models\Profiles;
use Illuminate\Http\Request;
use DataTables;
use App\Tools;
use App\Models\Tokens;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('landingpage.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('landingpage.create');
    }

    public function edit(LandingPage $landingpage)
    {
       return view('landingpage.edit', compact('landingpage'));
    }

    
    public function deletelandingpage(LandingPage $landingpage)
    { 
        $pageId= $_GET['id'];
        $result = LandingPage::where('id', $pageId)->delete();
        if($result){
            return true;
        }else{
            return false;
        }
    }
}
