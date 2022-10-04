<!DOCTYPE html> <!-- htmlのタイプを宣言(HTML5以降は宣言の必要はなくなったものの，ブラウザを動作させるスイッチの役割として必要) -->
<!-- 二重波括弧により、囲まれた部分はphpを記述できる領域を展開 -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> <!-- app()->getLocale()はconfig/app.phpのlocaleに指定されている言語を参照 -->
    <head>
        <meta charset="utf-8"> <!-- 一般的な文字のエンコーディング方式 -->
        <title>Blog</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>Blog Name</h1>
        <a href='/posts/create'>create</a>
        <div class='posts'>
            @foreach ($posts as $post)
            <div class='post'>
                <h2 class='title'>
                    <a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                </h2>
                <p class='body'>{{ $post->body }}</p>
                <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="deletePost({{ $post->id }})">delete</button> 
                </form>
            </div>
            @endforeach
        </div>
        <div class='paginate'>
            {{ $posts->links() }} <!-- links: 結果セットの残りのページへのリンクをレンダリング -->
        </div>
        
        <script>
            function deletePost(id) {
                'use strict'
        
                if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                    document.getElementById(`form_${id}`).submit();
                }
            }
        </script>
    </body>
</html>