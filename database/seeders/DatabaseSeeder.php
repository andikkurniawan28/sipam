<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Gateway;
use App\Models\Resident;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => "Ketua"],
            ['name' => "Sekretaris"],
            ['name' => "Bendahara"],
            ['name' => "IT"],
        ]);

        User::insert([
            ['name' => "Umam", 'username' => 'umam', 'password' => bcrypt('umam_gkm3'), 'role_id' => 1],
            ['name' => "Firli", 'username' => 'firli', 'password' => bcrypt('firli_gkm3'), 'role_id' => 2],
            ['name' => "Raka", 'username' => 'raka', 'password' => bcrypt('raka_gkm3'), 'role_id' => 2],
            ['name' => "Firdaus", 'username' => 'firdaus', 'password' => bcrypt('firdaus_gkm3'), 'role_id' => 3],
            ['name' => "Andik Kurniawan", 'username' => 'andik', 'password' => bcrypt('andik_gkm3'), 'role_id' => 4],
        ]);

        Setting::insert([
            ['fee' => 50000],
        ]);

        Gateway::insert([
            ['name' => "Kas", 'description' => null],
        ]);

        $faker = Faker::create('id_ID');
        $data = [];
        foreach (range('A', 'F') as $letter) {
            foreach (range(1, 11) as $number) {
                $data[] = [
                    'name' => $faker->unique()->name,
                    'address' => $letter . $number,
                    'whatsapp' => $faker->phoneNumber,
                ];
            }
        }
        Resident::insert($data);

        // Resident::insert([
        //     ['name' => "Andik Kurniawan", 'address' => "E9", 'whatsapp' => "085733465399"],
        // ]);
    }
}
