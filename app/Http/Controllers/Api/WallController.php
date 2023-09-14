<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\MediaController;
use App\Models\Walls;
use App\Repositories\Wall\WallRepository;

class WallController extends Controller
{
    protected $wallRepo;

    public function __construct(WallRepository $wallRepo)
    {
        $this->wallRepo = $wallRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = $this->wallRepo->getAllWall();
        return response()->json($results->toArray());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        // $walls = $this->wallRepo->getWall();
        // dd($walls);
        $user = Auth::user();
        $media = MediaController::create($request);
        $title = $request->has('title') ? $request->input('title') : '';
        $content = $request->has('content') ? $request->input('content') : '';
        $color = $request->has('color') ? $request->input('color') : '255,255,255';
        $fileName = $media ? $media['name'] : '';
        $data = [
            'user_id'     => $user->id,
            'title'       => $title,
            'content'     => $content,
            'file_name'   => $fileName,
            'color'       => $color,
        ];
        $results = $this->wallRepo->create($data);
        return response()->json($results->toArray());
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $liked = $request->has('liked') ? $request->get('liked') : false;
        $arr = [
            'liked' => $liked,
            'data_like' => json_encode($request->get('data_like')),
        ];
        $results = $this->wallRepo->update($id, $arr);
        return response()->json($results->toArray()); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
