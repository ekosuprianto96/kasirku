<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $role1 = Role::create([
            'name' => 'admin'
        ]);
        $role2 = Role::create([
            'name' => 'kasir'
        ]);

        $user1 = User::create([
            'role_id' => $role1->id,
            'name' => 'Eko Suprianto',
            'email' => 'ekhosaputra23@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        $user2 = User::create([
            'role_id' => $role2->id,
            'name' => 'Eko Saputra',
            'email' => 'ekhosaputra@gmail.com',
            'password' => Hash::make('12345678')
        ]);



        $kategori = Kategori::create([
            'image' => 'image-2.jpg',
            'name' => 'Kesehatan'
        ]);

        Produk::create([
            'kategori_id' => $kategori->id,
            'image' => 'image-1.jpg',
            'name' => 'Sabun Mandi',
            'barcode' => 235355235345424,
            'harga' => 20,
            'satuan' => 'pcs',
            'stok' => 30
        ]);
    }
}
