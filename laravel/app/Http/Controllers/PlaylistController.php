<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    public function index()
    {
        return response()->json(Playlist::all(), 200);
    }

    public function show($id)
    {
        $playlist = Playlist::find($id);
        if (!$playlist) {
            return response()->json(['message' => 'Плейлист не знайдено'], 404);
        }
        return response()->json($playlist, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $playlist = Playlist::create($request->all());
        return response()->json($playlist, 201);
    }

    public function update(Request $request, $id)
    {
        $playlist = Playlist::find($id);
        if (!$playlist) {
            return response()->json(['message' => 'Плейлист не знайдено'], 404);
        }

        $playlist->update($request->all());
        return response()->json($playlist, 200);
    }

    public function destroy($id)
    {
        $playlist = Playlist::find($id);
        if (!$playlist) {
            return response()->json(['message' => 'Плейлист не знайдено'], 404);
        }

        $playlist->delete();
        return response()->json(['message' => 'Плейлист успішно видалено'], 200);
    }
}