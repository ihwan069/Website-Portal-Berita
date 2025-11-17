<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $news = News::query()->when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
        })->orderBy('created_at', 'desc')
            ->paginate(8)
            ->withQueryString();

        return view('pages.news.index', compact('news'));
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)->first();
        $newests = News::orderBy('created_at', 'desc')->get()->take(4);

        return view('pages.news.show', compact('news', 'newests'));
    }

    public function category($slug)
    {
        $category = NewsCategory::where('slug', $slug)->first();

        return view('pages.news.category', compact('category'));
    }
}
