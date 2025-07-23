<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnvironnementController extends Controller
{

    public function getEnvironnement()
    {
        // Main query with corrected column names and disambiguated 'id'
        $results = DB::table('environnements as e')
            ->select(
                'e.id', // Specify the table for 'id'
                'e.nom_env',
                'e.adr_serv_app',
                'e.adr_serv_bd',
                'e.sys_exp_bd',

            )

            ->paginate(5);

        // Retrieve all records from langages_developpement
        $langages = DB::table('langages_developpement')
            ->select('langages_developpement.*')
            ->get();

        // Retrieve all records from services_monitoring
        $services = DB::table('services_monitoring')
            ->select('services_monitoring.*')
            ->get();

        // Retrieve all records from os_serveur_applicatif
        $os = DB::table('os_serveur_applicatif')
            ->select('os_serveur_applicatif.*')
            ->get();

        // Return the view with the data
        return view('pages.Environnements.index', compact(
            'results',
            'langages',
            'services',
            'os'
        ));
    }




    public function createEnvironnement(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'nom_env' => 'required|string|max:255',
            'adr_serv_app' => 'required|string|max:255',
            'adr_serv_bd' => 'required|string|max:255',
            'sys_exp_bd' => 'required|string|max:255',
            'langages_developpement_id' => 'required|exists:langages_developpement,id',
            'os_serveur_applicatif_id' => 'required|exists:os_serveur_applicatif,id',
            'services_monitoring_id' => 'required|exists:services_monitoring,id',
        ]);

        // dd($validatedData);

        try {
            // Commencer une transaction
            DB::beginTransaction();

            // 1. Insertion de l'environnement
            $environnementId = DB::table('environnements')->insertGetId([
                'nom_env' => $validatedData['nom_env'],
                'adr_serv_app' => $validatedData['adr_serv_app'],
                'adr_serv_bd' => $validatedData['adr_serv_bd'],
                'sys_exp_bd' => $validatedData['sys_exp_bd'],
            ]);

            // 2. Mise à jour des tables liées avec l'environnement_id
            DB::table('langages_developpement')
                ->where('id', $validatedData['langages_developpement_id'])
                ->update(['environnement_id' => $environnementId]);

            DB::table('os_serveur_applicatif')
                ->where('id', $validatedData['os_serveur_applicatif_id'])
                ->update(['environnement_id' => $environnementId]);

            DB::table('services_monitoring')
                ->where('id', $validatedData['services_monitoring_id'])
                ->update(['environnement_id' => $environnementId]);

            // Valider la transaction
            DB::commit();

            return redirect()->route('environnements.get')->with('success', 'Environnement créé avec succès!');
        } catch (\Exception $e) {
            // Annuler la transaction en cas d'erreur
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création: ' . $e->getMessage());
        }
    }
}
