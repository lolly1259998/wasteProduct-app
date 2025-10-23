<?php
namespace App\Http\Controllers\Participants;

use App\Http\Controllers\Controller;
use App\Models\Participation;
use App\Models\Campaign;
use Illuminate\Http\Request;

class ParticipationController extends Controller
{
   
public function index($campaignId)
{
    $campaign = \App\Models\Campaign::findOrFail($campaignId);
    return view('back.participants.participate', compact('campaign'));
}


    // 📋 Liste des participants d'une campagne
    public function list($campaignId)
    {
        $campaign = Campaign::with(['participations.user'])->findOrFail($campaignId);
        $participants = $campaign->participations->map(function ($p) {
            return [
                'id' => $p->id,
                'user_name' => $p->user->name ?? 'N/A',
                'user_email' => $p->user->email ?? '—',
                'status' => $p->status,
                'joined_at' => $p->created_at->format('Y-m-d H:i'),
            ];
        });

        return response()->json($participants);
    }

    // ✅ Approuver un participant
    public function approve($id)
    {
        $participant = Participation::findOrFail($id);
        $participant->update(['status' => 'approved']);
        return response()->json(['message' => 'Participant approved successfully.']);
    }

    // ❌ Supprimer une participation
    public function destroy($id)
    {
        $participant = Participation::findOrFail($id);
        $participant->delete();
        return response()->json(['message' => 'Participant removed.']);
    }

    public function listAll()
{
    $participations = \App\Models\Participation::with(['user', 'campaign'])->get();
    return response()->json($participations);
}
}
