<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{

    public function index()
    {
        $categories = Category::with(['products' => function($query) {
            $query->where('status', 'approved')
                ->latest()
                ->take(4); // 4 products per category
        }])->get();
    
        return view('home', compact('categories'));
    }
}
