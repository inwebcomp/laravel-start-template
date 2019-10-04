<?php

use App\Models\Navigation;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Navigation::create([
            'uid'   => 'top',
            'title' => 'Верхнее меню',
        ]);
    }
}
