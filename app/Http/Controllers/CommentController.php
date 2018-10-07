<?php

namespace Corp\Http\Controllers;

use Corp\Comment;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // saving
        $data = $request->except('_token', 'comment_post_ID', 'comment_parent');
        $data['article_id'] = $request->input('comment_post_ID');
        $data['parent_id'] = $request->input('comment_parent');

        $validator = Validator::make($data, [
            'article_id' => 'integer|required',
            'text' => 'required'
        ])->setAttributeNames([
            'email' => '"E-mail"',
            'text' => '"Ваш комментарий"'
        ]);
        $validator->sometimes('name', 'required|max:255', function ($input) {
            return !Auth::check();
        });
        $validator->sometimes('email', 'required|email|max:255', function ($input) {
            return !Auth::check();
        });
        if ($validator->fails()) {
            return Response::json(['error' => $validator->errors()->all()]);
        }

        $user = Auth::user();
        $comment = new Comment($data);
        if ($user) {
            $comment->user_id = $user->id;
        }

        $comment->save();

        // preparing a response
        $comment->load('user');
        $data['id'] = $comment->id;
        $data['name'] = (!empty($data['name'])) ? $data['name'] : $comment->user->name;
        $data['email'] = (!empty($data['email'])) ? $data['email'] : $comment->user->email;
        $data['site'] = (!empty($data['site'])) ? $data['site'] : (($comment->user) ? $comment->user->site : '');
        $data['hash'] = md5($data['email']);
        $data['date'] = $comment->formatCreatedAtDate('%B %d, %Y') . ' в ' .
            $comment->formatCreatedAtDate('%R');

        $comment_new_view = view(config('settings.theme') . '.comment_new')
            ->with('data', $data)
            ->render();

        return Response::json(['success' => true, 'comment' => $comment_new_view, 'data' => $data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
