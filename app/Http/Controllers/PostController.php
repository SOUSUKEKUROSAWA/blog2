<?php

namespace App\Http\Controllers; // ファイルがある場所のパスを示す(これがあることによって全ての場所でパスを記述する必要がなくなる)

//-- use宣言は外部にあるクラスをPostController内にインポートできる。
use Illuminate\Http\Request; // vendor\laravel\framework\src\Illuminate~
use App\Models\Post; // App\Models内のPostクラスをインポート

class PostController extends Controller
{
    // publicはfunctionのスコープを定めている(publicはクラス外からのアクセスを許可する)
    public function index(Post $post) // インポートしたPostをインスタンス化して$postとして使用。
    {
        return $post->get(); // $postの中身を戻り値にする。
    }
}
