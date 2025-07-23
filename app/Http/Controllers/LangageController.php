<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LangageController extends Controller
{
    public function getLangage()
    {
        $langages = DB::table('langages_developpement')
            ->leftJoin('environnements', 'langages_developpement.environnement_id', '=', 'environnements.id')
            ->select(
                'langages_developpement.*',
                'environnements.nom_env',
                'environnements.adr_serv_app'
            )
            ->paginate(10);
        $environnements = DB::table('environnements')->get();
        return view('pages.Langage.index', compact('langages', 'environnements'));
    }

    public function createLangage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'langage' => 'required|string|max:255|unique:langages_developpement,langage,except,id',
            'environnement_id' => 'nullable|integer|exists:environnements,id',
        ], [
            'langage.required' => 'Le nom du langage est obligatoire',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $id = DB::table('langages_developpement')->insertGetId([
                'langage' => $request->langage,
                'environnement_id' => $request->environnement_id ?? null,

            ]);

            return response()->json([
                'code' => 200,
                'message' => 'Langage créé avec succès',
                'data' => [
                    'id' => $id,
                    'langage' => $request->langage
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ]);
        }
    }

    public function updateLangage(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'langage' => 'required|string|max:255|unique:langages_developpement,langage,except,id',
            'environnement_id' => 'nullable|integer|exists:environnements,id',
        ], [
            'langage.required' => 'Le nom du langage est obligatoire',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $affected = DB::table('langages_developpement')
                ->where('id', $id)
                ->update([
                    'langage' => $request->langage,
                    'environnement_id' => $request->environnement_id ?? null,

                ]);

            if ($affected === 0) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Langage non trouvé'
                ]);
            }

            return response()->json([
                'code' => 200,
                'message' => 'Langage mis à jour avec succès',
                'data' => [
                    'id' => $id,
                    'langage' => $request->langage
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteLangage($id)
    {
        try {
            $deleted = DB::table('langages_developpement')
                ->where('id', $id)
                ->delete();

            if ($deleted === 0) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Langage non trouvé'
                ]);
            }

            return response()->json([
                'code' => 200,
                'message' => 'Langage supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ]);
        }
    }
}
