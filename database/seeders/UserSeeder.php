<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'mat_ag' => 'ADM001',
                'nom_ag' => 'ADMIN',
                'pren_ag' => 'Super',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'), // à changer en prod
                'dir_ag' => 'DIRECTION GENERALE',
                'loc_ag' => 'ABIDJAN',
                'sta_ag' => 'ACTIF',
                'role' => 'admin',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'mat_ag' => 'GST001',
                'nom_ag' => 'INVITE',
                'pren_ag' => 'Utilisateur',
                'email' => 'guest@example.com',
                'password' => Hash::make('password'), // à changer aussi
                'dir_ag' => 'ACCUEIL',
                'loc_ag' => 'ABIDJAN',
                'sta_ag' => 'TEMPORAIRE',
                'role' => 'guest',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'mat_ag' => 'USR001',
                'nom_ag' => 'KOUAME',
                'pren_ag' => 'Jean',
                'email' => 'jean.kouame@example.com',
                'password' => Hash::make('password'),
                'dir_ag' => 'DIRECTION TECHNIQUE',
                'loc_ag' => 'ABIDJAN',
                'sta_ag' => 'ACTIF',
                'role' => 'admin',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'mat_ag' => 'USR002',
                'nom_ag' => 'TRAORE',
                'pren_ag' => 'Fatou',
                'email' => 'fatou.traore@example.com',
                'password' => Hash::make('password'),
                'dir_ag' => 'DIRECTION COMMERCIALE',
                'loc_ag' => 'BOUAKE',
                'sta_ag' => 'ACTIF',
                'role' => 'user',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'mat_ag' => 'USR003',
                'nom_ag' => 'YAO',
                'pren_ag' => 'Marie',
                'email' => 'marie.yao@example.com',
                'password' => Hash::make('password'),
                'dir_ag' => 'DIRECTION FINANCIERE',
                'loc_ag' => 'YAMOUSSOUKRO',
                'sta_ag' => 'ACTIF',
                'role' => 'manager',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'mat_ag' => 'USR004',
                'nom_ag' => 'BAMBA',
                'pren_ag' => 'Ibrahim',
                'email' => 'ibrahim.bamba@example.com',
                'password' => Hash::make('password'),
                'dir_ag' => 'DIRECTION RESSOURCES HUMAINES',
                'loc_ag' => 'SAN PEDRO',
                'sta_ag' => 'INACTIF',
                'role' => 'user',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
