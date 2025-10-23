<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Participation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // ✅ ajoute ceci


class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with('user')->withCount('participations')->get();
        return response()->json($campaigns);
    }

  public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'status' => 'in:draft,active,closed',
        'city' => 'nullable|string',
        'region' => 'nullable|string',
        'deadline_registration' => 'nullable|date',
    ]);

    // Upload image si elle existe
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('campaigns', 'public');
        $validated['image'] = $path;
    }

    $validated['user_id'] = auth()->id();
    $validated['participants_count'] = 0;

    $campaign = Campaign::create($validated);

    return response()->json($campaign, 201);
}

    public function show($id)
    {
        $campaign = Campaign::with('user')->withCount('participations')->findOrFail($id);
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
            'type' => 'nullable|string',
            'city' => 'nullable|string',
            'region' => 'nullable|string',
            'deadline_registration' => 'nullable|date',
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
        $campaigns = Campaign::where('status', 'active')->withCount('participations')->get();
        return view('front.campaign.campaigns', compact('campaigns'));
    }

    public function check($id)
    {
        $user = Auth::user();
        $campaign = Campaign::findOrFail($id);
        $joined = $user ? Participation::where('user_id', $user->id)
            ->where('campaign_id', $id)
            ->exists() : false;

        return response()->json([
            'joined' => $joined,
            'participants' => $campaign->participations_count,
        ]);
    }

    public function toggle(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $campaign = Campaign::findOrFail($id);
        $participation = Participation::where('user_id', $user->id)
            ->where('campaign_id', $id)
            ->first();

        if ($participation) {
            $participation->delete();
            $joined = false;
        } else {
            if ($campaign->status === 'active') {
                Participation::create([
                    'user_id' => $user->id,
                    'campaign_id' => $id,
                    'status' => 'joined',
                ]);
                $joined = true;
            } else {
                return response()->json(['error' => 'Cannot join a non-active campaign'], 403);
            }
        }

        $participants = $campaign->participations()->count();

        return response()->json([
            'joined' => $joined,
            'participants' => $participants,
        ]);
    }


public function recommendAI()
{
    $user = auth()->user();

    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    try {
        $campaigns = \App\Models\Campaign::select
        ('id', 'title', 'description', 'city', 'region', 'status', 'end_date','image'
)
            ->where('status', 'active')
            ->get();

        $response = Http::post('http://127.0.0.1:5000/api/ai/recommendations', [
            'city' => $user->city,
            'history' => 'a participé à des actions environnementales à ' . ($user->city ?? 'Tunisie'),
            'campaigns' => $campaigns->toArray() 
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'AI service unreachable'], 500);
        }

        return $response->json();

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
