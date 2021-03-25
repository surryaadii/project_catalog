<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends BaseModel
{
    public $timestamps = false;
    
    public function url($size='') {
        list($date, $time) = explode(' ', $this->created_at);
        list($year, $month, $day) = explode('-', $date);
        $name = ($size) ? $size . '-' . $this->name : $this->name;
        return asset( sprintf('storage/uploads/%04d/%02d/%02d/%02d/%s', $year, $month, $day, $this->id, $name) );
    }

    // public function user() {
    //     return $this->hasOne(User::class);
    // }

    public function path() {
        $timestamp = $this->timestamp();
        return storage_path( sprintf("app/public/uploads/%s", $timestamp) );
    }

    public function generate($size, $width, $height) {
        $size = ( $size ) ? $size . "-" : $size;
        $path = $this->path();
        $src = sprintf("%s/%s", $path, $this->name);
        $dst = sprintf("%s/%s%s", $path, $size, $this->name);
        $im = Image::make($src);

        list ($w, $h) = getimagesize($src);
        
        if ($im->width() < $width) {
            $im->widen($width);
        }

        if ($im->height() < $height) {
            $im->heighten($height);
        }

        $im->fit($width, $height);
        $im->save($dst);
    }

    public function generates() {
        if (strpos($this->mime_type, 'image') > -1) {
            $sizes = Config::get('image.sizes');
            foreach ($sizes as $size=>$value) {
                list($width, $height) = $value;
                $this->generate($size, $width, $height);
            }
        }
    }

    public function timestamp() {
        list($date, $time) = explode(' ', $this->created_at);
        list($year, $month, $day) = explode('-', $date);
        return sprintf("%04d/%02d/%02d/%02d", $year, $month, $day, $this->id);
    }
}
