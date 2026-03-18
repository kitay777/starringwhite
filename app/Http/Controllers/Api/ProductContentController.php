<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductContent;
use Illuminate\Http\Request;

class ProductContentController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductContent::query();

        if ($request->keyword) {
            $query->where('base_item_id', 'like', '%' . $request->keyword . '%');
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function show($id)
    {
        $data = ProductContent::where('base_item_id', $id)->first();

        if (!$data) {
            return response()->json(['exists' => false]);
        }

        return response()->json([
            'exists' => true,
            'description' => $data->description,
            'size' => $data->size,
        ]);
    }

    public function store(Request $request)
    {
        $data = ProductContent::updateOrCreate(
            ['base_item_id' => $request->base_item_id],
            [
                'description' => $request->description,
                'size' => $request->size,
            ]
        );

        return response()->json($data);
    }
    public function destroy($id)
    {
        ProductContent::findOrFail($id)->delete();

        return response()->json([
            'success' => true
        ]);
    }
}