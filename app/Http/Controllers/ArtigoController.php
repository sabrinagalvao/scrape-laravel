<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artigo;

class ArtigoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){

        $artigos = Artigo::all();
        return view('artigos')->with('artigos', $artigos);
    
    }

    public function destroy($id){
        if(!$artigo = Artigo::find($id)){
            return redirect()->back();
        }

        $artigo->delete();

        return redirect()->route('artigos.index');
    }
}
