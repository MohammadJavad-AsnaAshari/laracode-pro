<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::query();

        if ($keyword = request("search")) {
            $comments->where(function ($query) use ($keyword) {
                $query->where("comment", "like", "%{$keyword}%")
                    ->orWhereHas("user", function ($subQuery) use ($keyword) {
                        $subQuery->where("name", "like", "%{$keyword}%");
                    });
            });
        }

        $comments = $comments->whereApproved(1)->latest()->paginate(10);
        return view("admin.comments.all", compact("comments"));
    }

    public function unapproved()
    {
        $comments = Comment::query();

//        if ($keyword = \request("search")) {
//            $comments->where(function ($query) use ($keyword) {
//                $query->where("comment", "like", "%{$keyword}%")
//                    ->orWhereHas("user", function ($subQuery) use ($keyword) {
//                        $subQuery->where("name", "like", "%{$keyword}%");
//                    });
//            });
//        }
        if($keyword = request('search')) {
            $comments->where('comment' , 'LIKE' , "%{$keyword}%")->orWhereHas('user' , function($query) use ($keyword) {
                $query->where('name' , 'LIKE' , "%{$keyword}%");
            });
        }

        $comments = $comments->whereApproved(0)->latest()->paginate(10);
        return view("admin.comments.unapproved", compact("comments"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->update(
            ["approved" => 1]
        );

        Alert::success('Comment Successfully Approved :)', 'Success Message');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        Alert::success('Comment Successfully Delete !', 'Success Message');
        return back();
    }


}
