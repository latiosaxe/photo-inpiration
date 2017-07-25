<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search( Request $request)
    {
        $q = $request->input('q');
        $data = [
            'keyword' => $q,
        ];
        return view('site.sections.search')->with( $data );
    }

}
