<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Manga;

class MangaController extends Controller
{
    const MAX_COUNT_PER_REQUEST = 30;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $offset = $request->query('offset', 0);
        $limit = min($request->query('limit', static::MAX_COUNT_PER_REQUEST), static::MAX_COUNT_PER_REQUEST);

        $mangas = Manga::select(Manga::$briefAttrToSelect)
            ->skip($offset)
            ->take($limit)
            ->get();

        return response()->json($mangas->map(function($manga){
            return $manga->toArray(Manga::$briefAttrToOutput);
        }));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $manga = Manga::find($id, Manga::$detailAttrToSelect);
        return response()->json($manga->toArray(Manga::$detailAttrToOutput));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
