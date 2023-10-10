<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Comment;
use App\Models\Admin\Post;
use App\Models\User;
use App\Repository\Admin\Category\CategoryRepository;

class DashboardController extends Controller
{
    protected $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }


    public function index()
    {
        $categories = $this->categoryRepository->getAll();
        $users = User::all();
        $userAdmin = User::where('permission', 'admin')->get();
        $NormalUser = User::where('permission', 'user')->get();
        $posts = Post::all();
        $views = Post::sum('view');
        $comment = Comment::all();
        $unseen = Comment::where('status', 'unseen')->get();
        $seen = Comment::where('status', 'seen')->get();
        $popularPosts = Post::orderBy('view', 'desc')->take(5)->get();
        $mostCommentedPosts = Post::withCount('comments')->orderBy('comments_count', 'desc')->get();
        $comments = Comment::all();

        return view('admin.dashboard.index', compact('mostCommentedPosts', 'categories', 'users', 'userAdmin', 'NormalUser', 'posts', 'views', 'comment', 'unseen', 'seen', 'popularPosts', 'comments'));
    }
}
