<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store($item){
        $this->validate(request(),[
            'review' => 'required|min:5',
            'stars' => 'required|min:1|max:5'
        ]);

        auth()->user()->review()->create([
            'item_id' => $item,
            'review' => request('review'),
            'stars' => request('stars')
        ]);

        return back()->with('cm','Ulasan berhasil ditambahkan');
    }
}
