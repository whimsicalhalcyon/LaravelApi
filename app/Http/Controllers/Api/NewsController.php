<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $fillable = [
        'title', 'description', 'image',
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return News::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $news = new News();

        $news->title = $request->title;
        $news->description = $request->description;
        $news->image = $request->image;
        $news->save();
        return $news;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return News::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $news = News::findOrFail($id);
        $news->title = $request->title;
        $news->description = $request->description;
        $news->image = $request->image;
        $news->update();
        return $news;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        News::destroy($id);
        return ['ok'=>true];
    }
}
