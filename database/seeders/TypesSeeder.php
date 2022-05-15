<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dt = Carbon::now()->toDateTimeString();

        DB::table('types')->insert([
            ['id' => 1, 'type' => 'Verbe', 'abbrev' => 'vb', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 2, 'type' => 'Nom', 'abbrev' => 'nm', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 3, 'type' => 'Subjonctif', 'abbrev' => 'subj', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 4, 'type' => 'Adjectif', 'abbrev' => 'adj', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 5, 'type' => 'Pronom', 'abbrev' => 'pron', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 6, 'type' => 'Particule', 'abbrev' => 'part', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 7, 'type' => 'Pluriel', 'abbrev' => 'plur', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 8, 'type' => 'Verbe Actif', 'abbrev' => 'v. act', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 9, 'type' => 'Verbe Passif', 'abbrev' => 'v. pass', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 10, 'type' => 'Verbe Irrégulier', 'abbrev' => 'v. irr', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 11, 'type' => 'Singulier', 'abbrev' => 'sing', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 12, 'type' => 'Invariable', 'abbrev' => 'inv', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 13, 'type' => 'Verbe Réciproque', 'abbrev' => 'v. réc', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 14, 'type' => 'Verbe Neutre', 'abbrev' => 'v. n', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 15, 'type' => 'Verbe Applicatif', 'abbrev' => 'v. a', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 16, 'type' => 'Verbe Causatif', 'abbrev' => 'v. caus', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 17, 'type' => 'Verbe Intensif', 'abbrev' => 'v. int', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 18, 'type' => 'Interjection', 'abbrev' => 'int', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 19, 'type' => 'Proverbe', 'abbrev' => 'prov', 'created_at' => $dt, 'updated_at' => $dt],
            ['id' => 20, 'type' => 'Adverbe', 'abbrev' => 'adv', 'created_at' => $dt, 'updated_at' => $dt],

        ]);

    }
}
