<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Post_Img extends Model
{
    use HasFactory;

    protected $table = "post_imgs";

    protected $fillable = [
        'img_src',
        'post_id'
    ];

    protected $appends = ['img_url'];

    public function getImgUrlAttribute(): string
    {
        return Request::root() . $this->getImgSrc();
    }

    public function getImgSrc(): string
    {
        return Storage::disk("post_img")->url($this->img_src);
    }

    /**
     * The photo is saved on the disk. Return src.
     *
     * @param UploadedFile|string $img
     * @return string
     */
    public static function saveImg(UploadedFile|string $img): string
    {
        return Storage::disk("post_img")->putFile("/", $img);
    }

    public static function getById($id): \Illuminate\Database\Eloquent\Builder|Post_Img
    {
        return static::query()->where('id', $id)->firstOrNew();
    }
}
