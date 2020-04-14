<?php

use Illuminate\Database\Seeder;
use App\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //モデルのPostクラスに対して100回のデータを生成
        factory(Post::class,100)->create();
    }
}
