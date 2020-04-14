<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // Seederを実行するにはDatabaseSeederに記述が必要
        // $this->call(PostsTableSeeder::class);
        // $this->call(TagSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
