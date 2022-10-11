<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    use HasFactory;
    
    protected $fillable = [
        'title',
        'body',
        'category_id',
    ];
    
    // Categoryに対するリレーション
    //「1対多」の関係なので単数系に
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function getByLimit(int $limit_count = 10)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける（Collectionインスタンス）
        return $this->orderBy('updated_at', 'DESC')->limit($limit_count)->get();
    }
    
    public function getPaginateByLimit(int $limit_count = 10)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける（Paginationインスタンス=>Collectionインスタンスを分割したようなもの）
        return $this::with('category')->orderBy('updated_at', 'DESC')->paginate($limit_count);
        // 「$this::with('category')->...」の部分はEagerローディングを行っている(N+1問題の解決)
    }
}
