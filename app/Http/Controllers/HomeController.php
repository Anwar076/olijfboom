<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
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

        // Alleen dua-verzoeken die de admin handmatig op de nieuwsticker heeft gezet.
        // Indien er een aparte ticker-tekst is ingevuld, krijgt die voorrang op het oorspronkelijke verzoek.
        $duaTickerItems = DB::table('donations')
            ->where('status', 'paid')
            ->where('dua_request_enabled', true)
            ->whereNotNull('dua_request_text')
            ->where('dua_show_on_ticker', true)
            ->orderByDesc('paid_at')
            ->limit(10)
            ->get(['dua_request_text', 'dua_ticker_text', 'dua_request_anonymous'])
            ->map(function ($row) {
                $text = trim((string) ($row->dua_ticker_text ?? ''));
                if ($text === '') {
                    $text = trim((string) ($row->dua_request_text ?? ''));
                }
                if ($text === '') {
                    return null;
                }

                return [
                    'text' => $text,
                    'anonymous' => !empty($row->dua_request_anonymous),
                ];
            })
            ->filter()
            ->values()
            ->all();
        $homeShowcaseMedia = $this->normalizeShowcaseMedia(
            SiteSetting::getValue('dashboard_showcase_media') ?? SiteSetting::getValue('dashboard_showcase_images'),
            $defaultShowcaseMedia
        );

        $totalRaised = (float) (DB::table('donations')->where('status', 'paid')->sum('amount') ?? 0);
        $lightsActivated = min((int) floor($totalRaised / 10000), 100);
        $totalLights = 100;
        $progressPercentage = $totalLights > 0 ? ($lightsActivated / $totalLights) * 100 : 0;

        $teams = Team::query()
            ->leftJoin('donations', function ($join) {
                $join->on('teams.id', '=', 'donations.team_id')
                    ->where('donations.status', '=', 'paid');
            })
            ->select(
                'teams.id',
                'teams.name',
                'teams.description',
                'teams.target_label',
                'teams.target_amount',
                'teams.created_by_user_id',
                'teams.created_at',
                'teams.updated_at',
                DB::raw('COALESCE(SUM(donations.amount), 0) as team_total')
            )
            ->groupBy(
                'teams.id',
                'teams.name',
                'teams.description',
                'teams.target_label',
                'teams.target_amount',
                'teams.created_by_user_id',
                'teams.created_at',
                'teams.updated_at'
            )
            ->orderByDesc('team_total')
            ->get()
            ->map(function ($team) {
                $teamTotal = (float) $team->team_total;
                $targetAmount = (float) $team->target_amount;
                $lampStatus = $targetAmount > 0 && $teamTotal >= $targetAmount;
                $progressRatio = $targetAmount > 0 ? min(($teamTotal / $targetAmount) * 100, 100) : 0;

                return [
                    'id' => $team->id,
                    'name' => $team->name,
                    'targetLabel' => $team->target_label,
                    'targetAmount' => $targetAmount,
                    'teamTotal' => $teamTotal,
                    'lampStatus' => $lampStatus,
                    'progressRatio' => $progressRatio,
                ];
            });

        return view('pages.home', [
            'homeNewsTickerText' => $homeNewsTickerText,
            'duaTickerItems' => $duaTickerItems,
            'homeShowcaseMedia' => $homeShowcaseMedia,
            'totalRaised' => $totalRaised,
            'lightsActivated' => $lightsActivated,
            'totalLights' => $totalLights,
            'progressPercentage' => $progressPercentage,
            'teams' => $teams,
        ]);
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
}
