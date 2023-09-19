<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\MediaController;
use App\Models\Walls;
use App\Models\User;
use App\Repositories\Wall\WallRepository;
use App\Repositories\QuestRepository;

class WallController extends Controller
{
    protected $wallRepo;
    protected $questRepository;

    public function __construct(WallRepository $wallRepo, QuestRepository $questRepository)
    {
        $this->wallRepo = $wallRepo;
        $this->questRepository = $questRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $page = $request->has('page') ? $request->input('page') : 1;
        $results = $this->wallRepo->getAllWall($page);
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
        if ($results) {
            $results->toArray();
            $results['users'] = $user;
            $results['comments'] = [];
            $questType = 8;
            $record = 1;
            $this->questRepository->updateQuest($user, $questType, $record);
            
        }
        return response()->json($results);
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
        if ($request->has('liked')) {
            $liked = $request->has('liked') ? $request->get('liked') : false;
            $arr = [
                'liked' => $liked,
                'data_like' => json_encode($request->get('data_like')),
            ];
        }else{            
            $title = $request->has('title') ? $request->input('title') : '';
            $content = $request->has('content') ? $request->input('content') : '';
            $color = $request->has('color') ? $request->input('color') : '255,255,255';
            $file_name = $request->has('file_name') ? $request->input('file_name') : '';
            $data = [
                'title'       => $title,
                'content'     => $content,
                'color'       => $color,
                'file_name'       => $file_name,
            ];
            if ($request->has('file')) {
                $media = MediaController::create($request);
                $fileName = $media ? $media['name'] : '';
                $data['file_name'] = $fileName;
            }
            
        }
        $results = $this->wallRepo->update($id, $data);
        $results = $this->wallRepo->getWallById($id);
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
