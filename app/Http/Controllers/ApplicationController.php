<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    /**
     * Affiche la liste des applications
     */
    public function index()
    {
        $applications = DB::table('applications')
            ->orderBy('nom')
            ->paginate(10);

        return view('pages.Applications.index', compact('applications'));
    }

    /**
     * Crée une nouvelle application
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255|unique:applications'
        ], [
            'nom.required' => 'Le nom de l\'application est obligatoire',
            'nom.unique' => 'Cette application existe déjà'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            $id = DB::table('applications')->insertGetId([
                'nom' => $request->nom,

            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Application créée avec succès',
                'data' => ['id' => $id]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Met à jour une application existante
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255|unique:applications,nom,' . $id
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            $affected = DB::table('applications')
                ->where('id', $id)
                ->update([
                    'nom' => $request->nom,

                ]);

            if ($affected === 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Application non trouvée'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Application mise à jour avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprime une application
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Vérifier si l'application est utilisée dans des environnements
            $usedInEnvironnements = DB::table('environnements')
                ->where('application_id', $id)
                ->exists();

            if ($usedInEnvironnements) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Impossible de supprimer - l\'application est utilisée dans des environnements'
                ], 400);
            }

            $deleted = DB::table('applications')->where('id', $id)->delete();

            if ($deleted === 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Application non trouvée'
                ], 404);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Application supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }
}
