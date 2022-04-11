<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use DataTables;

final class PageController extends Controller
{
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

            $allPages = Page::latest();
            if(!empty($searchvalue)){
             $allPages = Page::orWhere('slug','like','%'.$value."%")->orWhere('id',$value)->latest(); 
            }
            return Datatables::of($allPages)
                ->addColumn('id', function ($row) {
                    return $row->id;
                })
                ->addColumn('full_url', function ($row) {
                    return $row->full_url.'/';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<input type="text" id="copy_to_clipboard_'.$row->id.'" value="'.$row->full_url.'/" style="opacity: 0;"/><a onclick="copyToClipboard('.$row->id.')" class="copy btn btn btn-secondary btn-sm focus:outline-none">Copy link</a>';
                    $btn .= '<a href="'.$row->full_url.'/" target="_blank" class="open btn btn-success btn-sm">Open</a>';
                    $btn .= '<a href="'.route('pages.edit', ['page' => $row->id]).'" class="open btn btn-info btn-sm">Edit</a>';
                    $btn .= '<button class="open btn btn-danger  btn-sm btn-delete" id="datatable-page" data-remote="'.$row->id.'" >Delete</a>';
                    return $btn;
                })
               ->addIndexColumn()
               ->make(true);
        }
        return view('pages.index');
    }

    public function create()
    {
        return view('pages.create');
    }

    public function edit(Page $page)
    {
        return view('pages.edit', compact('page'));
    }

    public function deletepage(Page $page){
        $pageId= $_GET['id'];
        $result = Page::where('id', $pageId)->delete();
        if($result){
            return true;
        }else{
            return false;
        }
    }
}
