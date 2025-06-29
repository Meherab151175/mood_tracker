<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoodController extends Controller
{
    public function index()
    {
        $moods = Auth::user()->moods()->orderBy('date', 'desc')->get();
        return response()->json($moods);
    }

    public function store(Request $request)
    {
        $request->validate([
            'mood_type' => 'required|in:Happy,Sad,Angry,Excited',
            'note' => 'nullable|string|max:1000',
            'date' => 'required|date|unique:moods,date,NULL,id,user_id,' . Auth::id(),
        ]);

        $mood = Auth::user()->moods()->create([
            'mood_type' => $request->mood_type,
            'note' => $request->note,
            'date' => $request->date,
        ]);

        return response()->json($mood, 201);
    }

    public function show(Mood $mood)
    {
        $this->authorize('view', $mood);
        return response()->json($mood);
    }

    public function update(Request $request, Mood $mood)
    {
        $this->authorize('update', $mood);

        $request->validate([
            'mood_type' => 'required|in:Happy,Sad,Angry,Excited',
            'note' => 'nullable|string|max:1000',
        ]);

        $mood->update($request->only(['mood_type', 'note']));

        return response()->json($mood);
    }

    public function destroy(Mood $mood)
    {
        $this->authorize('delete', $mood);
        $mood->delete();
        return response()->json(null, 204);
    }

    public function trashed()
    {
        $trashedMoods = Auth::user()->moods()->onlyTrashed()->get();
        return response()->json($trashedMoods);
    }

    public function restore($id)
    {
        $mood = Mood::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $mood);
        $mood->restore();
        return response()->json($mood);
    }
}
