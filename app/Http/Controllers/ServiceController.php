<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{

    public function getService()
    {
        $services = DB::table('services_monitoring')
            ->select('services_monitoring.*', 'environnements.nom_env', 'environnements.adr_serv_app')
            ->leftJoin('environnements', 'services_monitoring.environnement_id', '=', 'environnements.id')
            ->paginate(10);
        $environnements = DB::table('environnements')->get();
        return view('pages.Services.index', compact('services', 'environnements'));
    }

    public function createService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_service' => 'required|string|max:255|unique:services_monitoring,nom_service,except,id',
            'environnement_id' => 'nullable|integer|exists:environnements,id',
        ], [
            'nom_service.required' => 'Le nom est obligatoire',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => $validator->errors()->first()
            ]);
        }
        try {
            $id = DB::table('services_monitoring')->insertGetId([
                'nom_service' => $request->nom_service,
                'environnement_id' => $request->environnement_id ?? null,
            ]);

            return response()->json([
                'code' => 200,
                'message' => 'Services créée avec succès',
                'data' => [
                    'id' => $id,
                    'nom_service' => $request->nom_service
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ]);
        }
    }


    public function updateService(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nom_service' => 'required|string|max:255|unique:services_monitoring,nom_service,except,id',
            'environnement_id' => 'nullable|integer|exists:environnements,id',
        ], [
            'nom_service.required' => 'Le nom est obligatoire',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $affected = DB::table('services_monitoring')
                ->where('id', $id)
                ->update([
                    'nom_service' => $request->nom_service,
                    'environnement_id' => $request->environnement_id ?? null,

                ]);

            if ($affected === 0) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Service non trouvé'
                ]);
            }

            return response()->json([
                'code' => 200,
                'message' => 'Service mis à jour avec succès',
                'data' => [
                    'id' => $id,
                    'nom_service' => $request->nom_service
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ]);
        }
    }


    public function deleteService($id)
    {
        try {
            $deleted = DB::table('services_monitoring')
                ->where('id', $id)
                ->delete();

            if ($deleted === 0) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Service non trouvé'
                ]);
            }

            return response()->json([
                'code' => 200,
                'message' => 'Service supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ]);
        }
    }
}
