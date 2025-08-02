<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{

public function index(Request $request)
{
    $query = Article::query();

    // Fitur Pencarian (Search)
    if ($request->has('search')) {
        $searchTerm = $request->input('search');
        $query->where('title', 'like', '%' . $searchTerm . '%')
              ->orWhere('content', 'like', '%' . $searchTerm . '%');
    }

    // Mengurutkan & Paginasi
    $articles = $query->latest()->paginate(10); // 10 item per halaman

    return response()->json($articles);
}

    /**
     * Store a newly created resource in storage.
     * POST /api/articles
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $article = Article::create($request->all());

        return response()->json($article, 201);
    }

    /**
     * Display the specified resource.
     * GET /api/articles/{id}
     */
    public function show(Article $article)
    {
        return response()->json($article);
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /api/articles/{id}
     */
    public function update(Request $request, Article $article)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'author' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $article->update($request->all());

        return response()->json($article);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/articles/{id}
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(null, 204); // 204 No Content
    }
}