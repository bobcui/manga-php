<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Manga;
use App\Chapter;
use App\MangaCategory;


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
        $search = $request->input('search');
        $categories = $request->input('categories');
        $status = $request->input('status');
        
        $sort = $request->input('sort');
        if (!in_array($sort, ['nme', 'rnk', 'rnk_wek', 'dte_upd'])) {
            $sort = 'rnk';
        }

        $order = $request->input('order');
        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'asc';
        }

        $offset = $request->input('offset', 0);
        $limit = min($request->input('limit', static::MAX_COUNT_PER_REQUEST), static::MAX_COUNT_PER_REQUEST);

        $mangaIds = [];
        if (!is_null($categories)) {
            if (!is_array($categories)) {
                $categories = [$categories];
            }

            $results = MangaCategory::select('mng_id')
                ->whereIn('cat_id', $categories)
                ->distinct()
                ->get();

            foreach ($results as $result) {
                $mangaIds[] = $result->mng_id;
            }
        }

        $query = $this->makeMangaIndexQuery($mangaIds, $status, $search);
        $mangaTotalCount = $query->count();

        $mangas = $this->makeMangaIndexQuery($mangaIds, $status, $search)
            ->select(Manga::$briefAttrToSelect)
            ->orderBy($sort, $order)
            ->skip($offset)
            ->take($limit)
            ->get();

        return response()->json($mangas->map(function($manga){
            return $manga->toArray(Manga::$briefAttrToOutput);
        }))->header('X-Total-Count', $mangaTotalCount);
    }

    private function makeMangaIndexQuery($mangaIds, $status, $search)
    {
        $query = Manga::query();
        if (!empty($mangaIds)) {
            $query = $query->whereIn('id', $mangaIds);
        }
        if (!is_null($status)) {
            $query = $query->where('sts', '=', $status);
        }
        if (!is_null($search)) {
            $query = $query->where('nme', 'like', "%${search}%");
        }
        return $query;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $manga = Manga::with(['chapters' => function($query){
            $query->select(Chapter::$attrToSelect);
        }])->find($id, Manga::$detailAttrToSelect);

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
