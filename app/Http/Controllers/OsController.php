<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OsController extends Controller
{
    public function getOs()
    {
        $osList = DB::table('os_serveur_applicatif')
            ->select('os_serveur_applicatif.*', 'environnements.nom_env', 'environnements.adr_serv_app')
            ->leftJoin('environnements', 'os_serveur_applicatif.environnement_id', '=', 'environnements.id')
            ->paginate(10);
        $environnements = DB::table('environnements')->get();

        return view('pages.Os.index', compact('osList', 'environnements'));
    }

    public function createOs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_os' => 'required|string|max:255|unique:os_serveur_applicatif,nom_os,except,id',
            'environnement_id' => 'nullable|integer|exists:environnements,id',
        ], [
            'nom_os.required' => 'Le nom du système d\'exploitation est obligatoire',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $id = DB::table('os_serveur_applicatif')->insertGetId([
                'nom_os' => $request->nom_os,
                'environnement_id' => $request->environnement_id ?? null,

            ]);

            return response()->json([
                'code' => 200,
                'message' => 'Système d\'exploitation créé avec succès',
                'data' => [
                    'id' => $id,
                    'nom_os' => $request->nom_os
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ]);
        }
    }

    public function updateOs(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nom_os' => 'required|string|max:255|unique:os_serveur_applicatif,nom_os,except,id',
            'environnement_id' => 'nullable|integer|exists:environnements,id',
        ], [
            'nom_os.required' => 'Le nom du système d\'exploitation est obligatoire',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $affected = DB::table('os_serveur_applicatif')
                ->where('id', $id)
                ->update([
                    'nom_os' => $request->nom_os,
                    'environnement_id' => $request->environnement_id ?? null,

                ]);

            if ($affected === 0) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Système d\'exploitation non trouvé'
                ]);
            }

            return response()->json([
                'code' => 200,
                'message' => 'Système d\'exploitation mis à jour avec succès',
                'data' => [
                    'id' => $id,
                    'nom_os' => $request->nom_os
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteOs($id)
    {
        try {
            $deleted = DB::table('os_serveur_applicatif')
                ->where('id', $id)
                ->delete();

            if ($deleted === 0) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Système d\'exploitation non trouvé'
                ]);
            }

            return response()->json([
                'code' => 200,
                'message' => 'Système d\'exploitation supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ]);
        }
    }
}
