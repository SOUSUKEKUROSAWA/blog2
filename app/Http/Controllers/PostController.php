<?php

namespace App\Http\Controllers; // ファイルがある場所のパスを示す(これがあることによって全ての場所でパスを記述する必要がなくなる)

//-- use宣言は外部にあるクラスをPostController内にインポートできる。
use Illuminate\Http\Request; // vendor\laravel\framework\src\Illuminate~

use App\Models\Post; // App\Models内のPostクラスをインポート
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    /**
     * Post一覧を表示する
     * 
     * @param Post Postモデル
     * @return array Postモデルリスト
     */
    // publicはfunctionのスコープを定めている(publicはクラス外からのアクセスを許可する)
    public function index(Post $post) // インポートしたPostをインスタンス化して$postとして使用。
    {
        return view('posts/index')->with(['posts' => $post->getPaginateByLimit()]); // blade内で使う変数'posts'を設定
        // return view('posts/index')->with(['posts' => $post->getByLimit()]); // blade内で使う変数'posts'を設定
    }
    
    /**
     * 特定IDのpostを表示する
     *
     * @params Object Post // 引数の$postはid=1のPostインスタンス
     * @return Reposnse post view
     */
    public function show(Post $post)
    {
        return view('posts/show')->with(['post' => $post]); // 'post'はbladeファイルで使う変数。中身は$postはid=1のPostインスタンス。
    }
    
    public function create()
    {
        return view('posts/create');
    }
    
    public function store(PostRequest $request, Post $post)
    {
        $input = $request['post'];
        $post->fill($input)->save(); // fillでpostインスタンスを上書き，saveでINSERT文を実行

        return redirect('/posts/' . $post->id);
    }
    
    public function edit(Post $post)
    {
        return view('posts/edit')->with(['post' => $post]);
    }
    
    public function update(PostRequest $request, Post $post)
    {
        $input_post = $request['post'];
        $post->fill($input_post)->save();
        // updateではなくfill+saveを使うことで，差分がある場合のみDBを更新する
        // (差分がないのにupdated_Atが更新されてしまうことなどを防ぐ)
    
        return redirect('/posts/' . $post->id);
    }
    
    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/');
    }
}
