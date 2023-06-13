<?php

namespace App\Http\Controllers;

use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function categories(Request $request){
        $website_id = $request->input('website_id');
        $categories = new \App\Models\Category();
        $categories = $categories->when($website_id,function ($q) use($website_id){
                $q->whereHas('website',function ($q) use($website_id){
                    return $q->where('websites.id',$website_id);
                });
            })
            ->pluck('title','id');
        return response()
        ->json($categories);
    }
    public function websites(Request $request){
        $category_id = $request->input('category_id');
        $website = new \App\Models\Website();
        $website = $website->when($category_id,function ($q) use($category_id){
                $q->whereHas('categories',function ($q) use($category_id){
                    return $q->where('categories.id',$category_id);
                });
            })
            ->pluck('domain','id');
        return response()
        ->json($website);
    }
}
