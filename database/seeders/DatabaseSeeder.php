<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Gateway;
use App\Models\Resident;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => "Ketua Paguyuban"],
            ['name' => "Sekretaris Paguyuban"],
            ['name' => "Bendahara Paguyuban"],
            ['name' => "PJ Air & Sampah"],
            ['name' => "Admin Air & Sampah"],
            ['name' => "IT"],
        ]);

        User::insert([
            ['name' => "Yahya", 'username' => 'yahya', 'password' => bcrypt('yahya_gkm3'), 'role_id' => 1],
            ['name' => "Raka", 'username' => 'raka', 'password' => bcrypt('raka_gkm3'), 'role_id' => 2],
            ['name' => "Madhe", 'username' => 'madhe', 'password' => bcrypt('madhe_gkm3'), 'role_id' => 3],
            ['name' => "Umam", 'username' => 'umam', 'password' => bcrypt('umam_gkm3'), 'role_id' => 4],
            ['name' => "Firdaus", 'username' => 'firdaus', 'password' => bcrypt('firdaus_gkm3'), 'role_id' => 5],
            ['name' => "Andik Kurniawan", 'username' => 'andik', 'password' => bcrypt('andik_gkm3'), 'role_id' => 6],
        ]);

        Setting::insert([
            ['fee' => 50000],
        ]);

        Gateway::insert([
            ['name' => "Kas", 'description' => null],
        ]);

        Resident::insert([
            ['name' => "Andik Kurniawan", 'address' => "E9", 'whatsapp' => "085733465399"],
        ]);
    }
}
