<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TokenValue;
use DataTables;

class TokenValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax())
        {
           $searchvalue = $request->search['value'];
           $val = explode('/',$searchvalue);
           if(isset($val[3])){
            $value = $val[3];
           }else{
            $value = $val[0];
           }

            $allPages = TokenValue::latest()->get();
            // $token_name = json_decode($allPages[0]['name'], true);
            // $count = count($token_name);
            // //echo "<pre>"; print_r($token_name); die;
        
            if(!empty($searchvalue)){
             $allPages = TokenValue::orWhere('slug','like','%'.$value."%")->orWhere('id',$value)->latest(); 
            }
            return Datatables::of($allPages)
                ->addColumn('id', function ($row) {
                    return $row->id;
                })
               ->addColumn('name', function ($row) {
                    $row = json_decode($row->name,true);
                    foreach($row as $val){
                        foreach($val as $names){
                            $name[]=$names;
                        }    
                    }
                    return $name;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button class="open btn btn-danger  btn-sm btn-delete" id="datatable-page" data-remote="'.$row->id.'" >Delete</a>';
                    return $btn;
                })

               ->addIndexColumn()
               ->make(true);
        }
        return view('tokensvalue.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tokensvalue.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TokenValue $tokenvalue)
    {
        return view('tokensvalue.edit', compact('tokenvalue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletetokenvalue(TokenValue $tokenvalue)
    {
          $pageId= $_GET['id'];
         $result = TokenValue::where('id', $pageId)->truncate();
        if($result){
            return true;
        }else{
            return false;
        }
    }
}
