<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\News;

class TopController extends Controller
{
    //
    public function top()
    {
        $model = new News();
        $news = $model->getAllNews();

        return view('top', compact('news'));
    }
}
