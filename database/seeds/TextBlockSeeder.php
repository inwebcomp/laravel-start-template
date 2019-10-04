<?php

use App\Models\Textblock;
use Illuminate\Database\Seeder;

class TextBlockSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Textblock::create([
            'uid'   => 'copyrights',
            'title' => 'Подпись внизу сайта (Copyrights)',
        ]);
    }
}
