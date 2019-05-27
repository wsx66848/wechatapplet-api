<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Collection;
use Response;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->success(Article::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
        return $this->success($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }


    public function addCollection(Request $request, Article $article) {
        $user = $request->user();
        if(!$article->getUserCollection($user)) {
            return Response::apiWithTransaction([], [], function($d) use($user, $article) {
                $collection = Collection::collectionModel($article, $article->title, $user);
                return true;
            });
        }
        return $this->success();

    }

    public function deleteCollection(Request $request, Article $article) {
        $user = $request->user();
        if($collection = $article->getUserCollection($user)) {
            $collection->delete();
        }
        return $this->success();
    }

    public function showCollection(Request $request) {
        $user = $request->user();
        return $this->success($user->collections()->with('collectionable')->where('collectionable_type','article')->get());
    }
}
