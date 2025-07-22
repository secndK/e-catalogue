<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'search_term',
        'user_ip',
        'user_session',
        'results_count',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Récupérer les dernières recherches pour une session
     */
    public static function getRecentSearches($sessionId, $limit = 5)
    {
        return self::where('user_session', $sessionId)
            ->where('search_term', '!=', '')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->distinct('search_term')
            ->get();
    }

    /**
     * Ajouter une nouvelle recherche
     */
    public static function addSearch($searchTerm, $resultsCount, $sessionId, $userIp)
    {
        // Éviter les doublons récents (moins de 5 minutes)
        $existingRecent = self::where('user_session', $sessionId)
            ->where('search_term', $searchTerm)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->first();

        if (!$existingRecent) {
            return self::create([
                'search_term' => $searchTerm,
                'user_ip' => $userIp,
                'user_session' => $sessionId,
                'results_count' => $resultsCount,
            ]);
        }

        return $existingRecent;
    }
}
