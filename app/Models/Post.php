<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date'
    ];

    protected $appends = ['imgs', "change_photo_url"];

    public function getImgsAttribute(): string
    {
        return $this->imgs();
    }

    public function getChangePhotoUrlAttribute(): string
    {
        return route('admin.blog-images', ['post' => $this->id]);
    }

    public function imgs(): Collection
    {
        return $this->hasMany(Post_Img::class)->getResults();
    }

    public static function getById($id): \Illuminate\Database\Eloquent\Builder|Post
    {
        return static::query()->where('id', $id)->firstOrNew();
    }
}
