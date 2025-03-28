<?php

namespace App\Http\Controllers\Dashboard\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Requests\Dashboard\ArticleRequest;

class ArticleControlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Article::with(
            'user:id,name'
        )->select(['slug', 'title', 'photo', 'headline', 'views', 'status']);

        $articles = $query->paginate(10);

        $statistics = (object) [
            'count_articles' => $articles->count(),
            'views_articles' => $articles->sum('views'),
            'likes_articles' => $articles->sum('likes'),
            'count_comments' => '',
            'count_removed_articles' => $articles->where('status', false)->count()
        ];

        return view('pages.dashboard.blog.index', compact(
            'statistics',
            'articles'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.blog.operations');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        return dd($request->validated());
        $article = Article::create($request->validated());
        return redirect()->route('articles.show', ['article' => $article->slug])->with('notification', [
            'type' => 'success',
            'message' => 'Your Article as been Published Successfully..'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
