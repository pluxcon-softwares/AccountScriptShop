<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        Schema::disableForeignKeyConstraints();
        $this->call(TablesDataSeeder::class);
        Schema::enableForeignKeyConstraints();
    }
}
