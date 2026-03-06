<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class AdminTagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();

        return view('admin.tags', compact('tags'));
    }
}
