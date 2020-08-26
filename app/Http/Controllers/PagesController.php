<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function index(){
        $title= "Welcome to my first project in Laravel.";
        // return view('pages.index',compact('title'));
        return view('pages.index')->with('title',$title);
    }

    public function about(){
        $title="This is my about page.";
        return view('pages.about')->with('title',$title);
    }

    public function services(){
        $data=array(
            'title' => 'services',
            'services'=> ['Web design','Programming','SEO']
        );
        return view('pages.services')->with($data);
    }
}
