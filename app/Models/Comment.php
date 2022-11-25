<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function user() {
    //l'usuari del comentari
    return $this->belongsTo(User::class, 'user_id');
    }

    public function image() {
    //la imatge del comentari
    return $this->belongsTo(Image::class, 'image_id');
    }

}
