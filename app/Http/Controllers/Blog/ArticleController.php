<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles  = Article::paginate(10);
        return view('pages.blog.search', compact('articles'));
    }

    public function show(Article $article)
    {
        return view('pages.blog.show', compact('article'));
    }
}
