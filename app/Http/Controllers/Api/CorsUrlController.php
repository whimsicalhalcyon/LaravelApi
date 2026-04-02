<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CorsUrl;
use Illuminate\Http\Request;

class CorsUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urls = CorsUrl::all();
        return response()->json($urls);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $url = new CorsUrl();
        $url->url=$request->url;
        $url->save();
        return response()->json($url);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return CorsUrl::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $newUrl = CorsUrl::findOrFail(intval($id));
        $newUrl->url=$request->url;
        $newUrl->update();
        return response()->json($newUrl);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CorsUrl::destroy($id);
        return ['ok' => true];
    }
}
