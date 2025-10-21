<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with('user')->get();
        return response()->json($campaigns);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'in:draft,active,closed',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $campaign = Campaign::create($validated);
        return response()->json($campaign, 201);
    }

    public function show($id)
    {
        $campaign = Campaign::with('user')->findOrFail($id);
        return response()->json($campaign);
    }

    public function update(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'status' => 'in:draft,active,closed',
        ]);

        $campaign->update($validated);
        return response()->json($campaign);
    }

    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();

        return response()->json(['message' => 'Campaign deleted successfully']);
    }
    public function frontIndex()
    {
    $campaigns = \App\Models\Campaign::where('status', 'active')->get();
    return view('front.campaign.campaigns', compact('campaigns'));
    }   

<<<<<<< HEAD
    // ✅ Toggle participation (join/quit)
public function toggleParticipation($id)
{
    $user = auth()->user();
    $campaign = Campaign::findOrFail($id);

    if ($campaign->participants()->where('user_id', $user->id)->exists()) {
        $campaign->participants()->detach($user->id);
        $campaign->decrement('participants_count');
        return response()->json(['joined' => false, 'participants' => $campaign->participants_count]);
    } else {
        $campaign->participants()->attach($user->id);
        $campaign->increment('participants_count');
        return response()->json(['joined' => true, 'participants' => $campaign->participants_count]);
    }
}

// ✅ Check participation status
public function checkParticipation($id)
{
    $user = auth()->user();
    $campaign = Campaign::findOrFail($id);
    $joined = $campaign->participants()->where('user_id', $user->id)->exists();
    return response()->json(['joined' => $joined]);
}


=======
>>>>>>> 36e93289263cd535f1fe8f26034c38bed54fcd40
}
