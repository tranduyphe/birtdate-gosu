<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Repositories\Comment\CommentRepository;

class CommentController extends Controller
{
    protected $comment;

    public function __construct(CommentRepository $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $data = [];
        $data['profile_id'] = $user['profile_id'];
        $data['avatar'] = $user['avatar'];
        $data['fullname'] = $user['first_name'].' '.$user['last_name'];
        $data['content'] = $request->input('content');
        $data['target_id'] = $request->input('target_id');
        $results = $this->comment->create($data);
        return response()->json($results->toArray());
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
        $arr = [
            'content' =>  $request->get('content'),
        ];
        $results = $this->comment->update($id, $arr);
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
        $this->comment->delete($id);
    }
}
