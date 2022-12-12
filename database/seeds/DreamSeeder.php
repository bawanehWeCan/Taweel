<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Dream;

class DreamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0 ; $i <20; $i++){
            $d = new Dream();
            $d->name = ' عنون الحلم ';
            $d->content = 'هذا النص يمكن أن يتم تركيبه على أي تصميم دون مشكلة فلن يبدو وكأنه نص منسوخ، غير منظم، غير منسق، أو حتى غير مفهوم. لأنه مازال نصاً بديلاً ومؤقتاً.';
            $d->name = Str::random(10);
            $d->category = 'تجريبي';
            $d->status = 1;
            $d->save();
        }
    }
}
