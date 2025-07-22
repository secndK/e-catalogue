<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\SearchHistory;

class CatalogueController extends Controller
{
    /**Cette fonction servira à recupérer l'ensemble des données pour les afficher dans la vue */
    /**
     * Cette fonction servira à récupérer l'ensemble des données pour les afficher dans la vue
     */
    public function getCatalogue()
    {
        $array_catalogue = DB::connection('mysql')->select('SELECT * FROM catalogues LIMIT 12');
        $recentSearches = $this->getRecentSearchesData();

        return view('pages.Home.accueil', [
            'catalogue' => collect($array_catalogue),
            'recent_searches' => $recentSearches,
            'search_query' => '',
            'show_all' => false
        ]);
    }

    /**
     * Cette fonction servira à récupérer TOUTES les applications dans la même vue
     */
    public function getAllCatalogue()
    {
        // Récupérer toutes les applications sans limite
        $all_catalogue = DB::connection('mysql')->select('SELECT * FROM catalogues');
        $recentSearches = $this->getRecentSearchesData();

        return view('pages.Home.accueil', [
            'catalogue' => collect($all_catalogue),
            'recent_searches' => $recentSearches,
            'search_query' => '',
            'show_all' => true,
            'total_apps' => count($all_catalogue)
        ]);
    }
    /**Cette fonction servira à recupérer l'ensemble des données pour les afficher dans la vue
     * après avoir entre le nom au l'ip correspondant de l'application
     */
    public function postCatalogue(Request $request)
    {
        $searchQuery = $request->post('rechercher', '');
        $results = [];

        if (!empty($searchQuery)) {
            $results = DB::connection('mysql')->select(
                'SELECT * FROM catalogues
                WHERE LOWER(app_name) LIKE ?
                OR env_dev = ? OR env_prod = ? OR env_test = ? OR adr_serv LIKE ?',
                ['%' . strtolower($searchQuery) . '%', $searchQuery, $searchQuery, $searchQuery, '%' . $searchQuery . '%']
            );

            if (session()->getId()) {
                SearchHistory::addSearch(
                    $searchQuery,
                    count($results),
                    session()->getId(),
                    $request->ip()
                );
            }
        }

        $recentSearches = $this->getRecentSearchesData();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $results,
                'recent_searches' => $recentSearches,
                'query' => $searchQuery
            ]);
        }

        return view('pages.Home.accueil', [
            'catalogue' => collect($results),
            'search_query' => $searchQuery,
            'recent_searches' => $recentSearches
        ]);
    }

    // Méthodes utilitaires privées
    private function getRecentSearchesData()
    {
        return session()->getId()
            ? SearchHistory::getRecentSearches(session()->getId())
            : [];
    }


    /** Cette fonction servira à ajouter une nouvelle app à la bd */
    public function createCatalogue(Request $request)
    {
        $request->validate([
            'env_dev' => 'required|string',
            'env_prod' => 'required|string',
            'env_test' => 'required|string',
            'adr_serv' => 'required|string',
            'sys_exp' => 'required|string',
            'adr_serv_bd' => 'required|string',
            'sys_exp_bd' => 'required|string',
            'lang_dev' => 'required|string',
            'critical' => 'nullable|string',
            'app_name' => 'required|string'
        ]);

        $data = [
            'env_dev' => $request->env_dev,
            'env_prod' => $request->env_prod,
            'env_test' => $request->env_test,
            'adr_serv' => $request->adr_serv,
            'sys_exp' => $request->sys_exp,
            'adr_serv_bd' => $request->adr_serv_bd,
            'sys_exp_bd' => $request->sys_exp_bd,
            'lang_dev' => $request->lang_dev,
            'critical' => $request->critical,
            'app_name' => $request->app_name
        ];

        try {
            DB::connection('mysql')->table('catalogues')->insert($data);

            // Vérifier si c'est une requête AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Application ajoutée avec succès.'
                ]);
            }

            // Ajout du message flash pour SweetAlert2
            return redirect()->back()->with('success', 'Application ajoutée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur insertion catalogue: ' . $e->getMessage());

            // Vérifier si c'est une requête AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de l\'ajout de l\'application.'
                ], 500);
            }

            // Ajout du message flash pour SweetAlert2
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout de l\'application.');
        }
    }


    /**
     * Récupère les détails d'une application spécifique
     */
    public function getAppDetails($id)
    {
        $app = DB::connection('mysql')->table('catalogues')->find($id);

        if (!$app) {
            return response()->json(['error' => 'Application non trouvée'], 404);
        }

        return response()->json($app);
    }

    /**
     * Met à jour une application existante
     */

    public function editCatalogue($id)
    {
        try {
            $app = DB::connection('mysql')->table('catalogues')->where('id', $id)->first();

            if (!$app) {
                return response()->json([
                    'success' => false,
                    'message' => 'Application non trouvée.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $app
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur récupération application: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération de l\'application.'
            ], 500);
        }
    }



    public function updateCatalogue(Request $request, $id)
    {
        try {
            DB::table('catalogues')->where('id', $id)->update([
                'app_name'     => $request->input('app_name'),
                'adr_serv'     => $request->input('adr_serv'),
                'env_dev'      => $request->input('env_dev'),
                'env_test'     => $request->input('env_test'),
                'env_prod'     => $request->input('env_prod'),
                'sys_exp'      => $request->input('sys_exp'),
                'lang_dev'     => $request->input('lang_dev'),
                'adr_serv_bd'  => $request->input('adr_serv_bd'),
                'sys_exp_bd'   => $request->input('sys_exp_bd'),
                'critical'     => $request->input('critical'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Application mise à jour avec succès.'
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur MAJ application: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour.'
            ], 500);
        }
    }



    public function getRecentSearches(Request $request)
    {
        $recentSearches = [];

        if (session()->getId()) {
            $recentSearches = SearchHistory::where('user_session', session()->getId())
                ->select('search_term', DB::raw('MAX(results_count) as results_count'))
                ->groupBy('search_term')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'recent_searches' => $recentSearches
            ]);
        }

        return $recentSearches;
    }

    /**
     * Cette fonction servira à supprimer une application du catalogue
     */
    public function deleteCatalogue(Request $request, $id)
    {
        try {
            // Vérifier si l'application existe
            $catalogue = DB::table('catalogues')->where('id', $id)->first();

            if (!$catalogue) {
                return response()->json([
                    'success' => false,
                    'message' => 'Application introuvable.'
                ], 404);
            }

            // Suppression
            DB::table('catalogues')->where('id', $id)->delete();

            Log::info("Application supprimée : {$catalogue->app_name} (ID: {$id})");

            return response()->json([
                'success' => true,
                'message' => 'Application supprimée avec succès.'
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur suppression application : " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression.'
            ], 500);
        }
    }




    /**
     * Cette fonction servira à vider complètement l'historique de recherche pour la session courante
     */
    public function clearSearchHistory(Request $request)
    {
        try {
            if (!session()->getId()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Session non trouvée.'
                    ], 400);
                }

                return redirect()->back()->with('error', 'Session non trouvée.');
            }

            // Supprimer tout l'historique pour cette session
            $deleted = SearchHistory::where('user_session', session()->getId())->delete();

            if ($deleted > 0) {
                // Log de l'action de suppression
                Log::info('Historique de recherche vidé pour la session: ' . session()->getId() . ' (' . $deleted . ' entrées supprimées)');

                // Vérifier si c'est une requête AJAX
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Historique de recherche vidé avec succès.',
                        'deleted_count' => $deleted
                    ]);
                }

                // Ajout du message flash pour SweetAlert2
                return redirect()->back()->with('success', 'Historique de recherche vidé avec succès.');
            } else {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'L\'historique était déjà vide.',
                        'deleted_count' => 0
                    ]);
                }

                return redirect()->back()->with('info', 'L\'historique était déjà vide.');
            }
        } catch (\Exception $e) {
            Log::error('Erreur vidage historique de recherche: ' . $e->getMessage());

            // Vérifier si c'est une requête AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors du vidage de l\'historique.'
                ], 500);
            }

            // Ajout du message flash pour SweetAlert2
            return redirect()->back()->with('error', 'Erreur lors du vidage de l\'historique.');
        }
    }
}
