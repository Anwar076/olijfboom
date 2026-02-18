<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use App\Models\SiteSetting;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $defaultShowcaseMedia = [
            ['type' => 'image', 'url' => 'https://picsum.photos/seed/icb-1/560/320'],
            ['type' => 'image', 'url' => 'https://picsum.photos/seed/icb-2/560/320'],
            ['type' => 'image', 'url' => 'https://picsum.photos/seed/icb-3/560/320'],
            ['type' => 'image', 'url' => 'https://picsum.photos/seed/icb-4/560/320'],
            ['type' => 'image', 'url' => 'https://picsum.photos/seed/icb-5/560/320'],
        ];
        $homeNewsTickerText = SiteSetting::getValue(
            'home_news_ticker',
            'Dit is dummy nieuwscontent: sponsorloop start om 10:00 uur, inschrijvingen zijn nog open en deel deze actie met je netwerk.'
        );
        $dashboardShowcaseMedia = $this->normalizeShowcaseMedia(
            SiteSetting::getValue('dashboard_showcase_media') ?? SiteSetting::getValue('dashboard_showcase_images'),
            $defaultShowcaseMedia
        );
        $targetOptions = config('teams.targets', []);
        $user = $request->user();

        $membership = TeamMember::where('user_id', $user->id)->first();
        $pendingDuaRequests = DB::table('donations')
            ->join('teams', 'donations.team_id', '=', 'teams.id')
            ->where('donations.status', 'paid')
            ->where('donations.dua_request_enabled', true)
            ->whereNotNull('donations.dua_request_text')
            ->whereNull('donations.dua_fulfilled_at')
            ->orderByDesc('donations.paid_at')
            ->select([
                'donations.id',
                'donations.amount',
                'donations.dua_request_text',
                'teams.name as team_name',
            ])
            ->limit(25)
            ->get();

        if (!$membership) {
            return view('pages.dashboard', [
                'team' => null,
                'members' => [],
                'teamTotal' => 0,
                'lampStatus' => false,
                'progressRatio' => 0,
                'inviteUrl' => session('invite_url'),
                'targetOptions' => $targetOptions,
                'homeNewsTickerText' => $homeNewsTickerText,
                'dashboardShowcaseMedia' => $dashboardShowcaseMedia,
                'pendingDuaRequests' => $pendingDuaRequests,
            ]);
        }

        $team = Team::findOrFail($membership->team_id);

        $members = DB::table('team_members')
            ->join('users', 'team_members.user_id', '=', 'users.id')
            ->where('team_members.team_id', $team->id)
            ->orderBy('team_members.created_at')
            ->select('team_members.id', 'users.id as user_id', 'users.name', 'users.email', 'users.role')
            ->get();

        $teamTotal = (float) (DB::table('donations')
            ->where('team_id', $team->id)
            ->where('status', 'paid')
            ->sum('amount') ?? 0);
        $targetAmount = (float) $team->target_amount;
        $lampStatus = $targetAmount > 0 && $teamTotal >= $targetAmount;
        $progressRatio = $targetAmount > 0 ? min(($teamTotal / $targetAmount) * 100, 100) : 0;

        return view('pages.dashboard', [
            'team' => $team,
            'members' => $members,
            'teamTotal' => $teamTotal,
            'lampStatus' => $lampStatus,
            'progressRatio' => $progressRatio,
            'inviteUrl' => session('invite_url'),
            'targetOptions' => $targetOptions,
            'homeNewsTickerText' => $homeNewsTickerText,
            'dashboardShowcaseMedia' => $dashboardShowcaseMedia,
            'pendingDuaRequests' => $pendingDuaRequests,
        ]);
    }

    public function updateHomeNewsTicker(Request $request)
    {
        if (! $request->user()?->isSiteManager()) {
            abort(403);
        }

        $data = $request->validate([
            'news_ticker_text' => ['required', 'string', 'max:2000'],
        ]);

        SiteSetting::setValue('home_news_ticker', trim($data['news_ticker_text']));

        return redirect()
            ->route('dashboard')
            ->with('status', 'Nieuwsticker bijgewerkt.');
    }

    public function updateDashboardShowcaseMedia(Request $request)
    {
        if (! $request->user()?->isSiteManager()) {
            abort(403);
        }

        $data = $request->validate([
            'media_urls' => ['nullable', 'array', 'max:12'],
            'media_urls.*' => ['nullable', 'url', 'max:2048'],
            'media_files' => ['nullable', 'array', 'max:12'],
            'media_files.*' => ['file', 'mimetypes:image/jpeg,image/png,image/webp,image/gif,video/mp4,video/x-mp4,video/webm,video/quicktime', 'max:51200'],
        ]);

        $media = collect($data['media_urls'] ?? [])
            ->map(fn ($url) => trim((string) $url))
            ->filter()
            ->map(function (string $url): array {
                return [
                    'type' => $this->detectMediaTypeFromUrl($url),
                    'url' => $url,
                ];
            });

        foreach ($request->file('media_files', []) as $file) {
            if (!$file) {
                continue;
            }

            $path = $file->store('showcase-media', 'public');
            $media->push([
                'type' => str_starts_with((string) $file->getMimeType(), 'video/') ? 'video' : 'image',
                'url' => Storage::disk('public')->url($path),
            ]);
        }

        $media = $media->take(12)->values()->all();

        if (count($media) === 0) {
            return redirect()
                ->route('dashboard')
                ->withErrors(['media_urls' => 'Vul minimaal 1 geldige media-URL in of upload een bestand.']);
        }

        SiteSetting::setValue(
            'dashboard_showcase_media',
            json_encode($media, JSON_UNESCAPED_SLASHES)
        );

        return redirect()
            ->route('dashboard')
            ->with('status', 'Media bijgewerkt.');
    }

    public function fulfillDua(Request $request, int $donationId)
    {
        if (! $request->user()?->isSiteManager()) {
            abort(403);
        }

        DB::table('donations')
            ->where('id', $donationId)
            ->update([
                'dua_fulfilled_at' => now(),
            ]);

        return redirect()
            ->route('dashboard')
            ->with('status', 'Dua-verzoek gemarkeerd als gedaan.');
    }

    private function normalizeShowcaseMedia(?string $raw, array $fallback): array
    {
        if (!$raw) {
            return $fallback;
        }

        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) {
            return $fallback;
        }

        $media = collect($decoded)
            ->map(function ($item): ?array {
                if (is_string($item) && $item !== '') {
                    return [
                        'type' => $this->detectMediaTypeFromUrl($item),
                        'url' => $item,
                    ];
                }

                if (!is_array($item) || !isset($item['url'])) {
                    return null;
                }

                $url = trim((string) $item['url']);
                if ($url === '') {
                    return null;
                }

                $type = isset($item['type']) && $item['type'] === 'video'
                    ? 'video'
                    : $this->detectMediaTypeFromUrl($url);

                return [
                    'type' => $type,
                    'url' => $url,
                ];
            })
            ->filter()
            ->values()
            ->take(12)
            ->all();

        return count($media) > 0 ? $media : $fallback;
    }

    private function detectMediaTypeFromUrl(string $url): string
    {
        $cleanPath = strtolower((string) parse_url($url, PHP_URL_PATH));

        if (preg_match('/\.(mp4|webm|mov)$/', $cleanPath) === 1) {
            return 'video';
        }

        return 'image';
    }

    public function createInvite(Request $request)
    {
        $user = $request->user();
        $teamId = TeamMember::where('user_id', $user->id)->value('team_id');

        if (!$teamId) {
            return redirect()->route('dashboard')->withErrors(['team' => 'Team niet gevonden.']);
        }

        $team = Team::findOrFail($teamId);

        if ($team->created_by_user_id !== $user->id) {
            abort(403, 'Not authorized for this team.');
        }

        $token = Str::random(64);

        Invite::create([
            'team_id' => $team->id,
            'token' => $token,
            'created_by_user_id' => $user->id,
            'expires_at' => now()->addDays(30),
        ]);

        $inviteUrl = route('invite.show', ['token' => $token]);

        return redirect()->route('dashboard')->with('invite_url', $inviteUrl);
    }

    public function addMember(Request $request)
    {
        $user = $request->user();
        $teamId = TeamMember::where('user_id', $user->id)->value('team_id');

        if (!$teamId) {
            return redirect()->route('dashboard')->withErrors(['team' => 'Team niet gevonden.']);
        }

        $team = Team::findOrFail($teamId);
        if ($team->created_by_user_id !== $user->id) {
            abort(403, 'Not authorized for this team.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $member = User::where('email', $data['email'])->first();

        if (!$member) {
            $member = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make(Str::random(32)),
                'role' => User::ROLE_USER,
            ]);
        } else {
            $member->update(['name' => $data['name']]);
        }

        $exists = TeamMember::where('team_id', $team->id)
            ->where('user_id', $member->id)
            ->exists();

        if (!$exists) {
            TeamMember::create([
                'team_id' => $team->id,
                'user_id' => $member->id,
            ]);
        }

        return redirect()->route('dashboard');
    }

    public function removeMember(Request $request, TeamMember $member)
    {
        $user = $request->user();
        $teamId = TeamMember::where('user_id', $user->id)->value('team_id');

        if (!$teamId) {
            return redirect()->route('dashboard')->withErrors(['team' => 'Team niet gevonden.']);
        }

        $team = Team::findOrFail($teamId);
        if ($team->created_by_user_id !== $user->id) {
            abort(403, 'Not authorized for this team.');
        }

        if ($member->team_id !== $team->id) {
            abort(403, 'Not authorized for this team.');
        }

        if ($member->user_id === $user->id) {
            return redirect()->route('dashboard')->withErrors(['member' => 'Je kunt jezelf niet verwijderen.']);
        }

        $member->delete();

        return redirect()->route('dashboard');
    }

    public function updateGoal(Request $request)
    {
        $user = $request->user();
        $teamId = TeamMember::where('user_id', $user->id)->value('team_id');

        if (!$teamId) {
            return redirect()->route('dashboard')->withErrors(['team' => 'Team niet gevonden.']);
        }

        $team = Team::findOrFail($teamId);
        if ($team->created_by_user_id !== $user->id) {
            abort(403, 'Not authorized for this team.');
        }

        $teamTotal = (float) (DB::table('donations')
            ->where('team_id', $team->id)
            ->where('status', 'paid')
            ->sum('amount') ?? 0);
        $targetAmount = (float) $team->target_amount;
        $goalReached = $targetAmount > 0 && $teamTotal >= $targetAmount;

        if (!$goalReached) {
            return redirect()->route('dashboard')->withErrors([
                'goal' => 'Je kunt pas een nieuw teamdoel kiezen zodra het huidige doel is bereikt.',
            ]);
        }

        if (!$request->filled('target_label') && $request->filled('target_option')) {
            $parts = explode('::', (string) $request->input('target_option'));
            if (count($parts) === 2) {
                $request->merge([
                    'target_label' => $parts[0],
                    'target_amount' => $parts[1],
                ]);
            }
        }

        $targetOptions = config('teams.targets', []);
        $validTargetOptions = collect($targetOptions)
            ->map(fn (array $option) => $option['label'] . '::' . $option['amount'])
            ->values()
            ->all();

        $data = $request->validate([
            'target_option' => ['required', 'string', Rule::in($validTargetOptions)],
            'target_label' => ['required', 'string', 'max:100'],
            'target_amount' => ['required', 'numeric', 'min:1'],
        ]);

        $team->update([
            'target_label' => $data['target_label'],
            'target_amount' => $data['target_amount'],
        ]);

        return redirect()->route('dashboard');
    }
}
