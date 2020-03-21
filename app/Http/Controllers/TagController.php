<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Http\Resources\TagResource;

class TagController extends Controller
{
    /**
     * 記事一覧
     */
    public function index(Request $request)
    {
        return TagResource::collection(Tag::all());
    }
}
