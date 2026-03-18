<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $query = Content::query();

        if ($request->type) {
            $query->where('type', $request->type);
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function store(Request $request)
    {
        return Content::updateOrCreate(
            ['id' => $request->id],
            [
                'type' => $request->type,
                'title' => $request->title,
                'body' => $request->body,
                'image' => $request->image,
            ]
        );
    }

    public function destroy($id)
    {
        Content::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        return Content::findOrFail($id);
    }
}