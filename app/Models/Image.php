<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    //indiquem taula bd
    protected $table = 'images';

    //relació one to many
    //mètode que retorna array amb els comentaris de l'imatge
    public function comments() {
        //return $this->hasMany($this->comment)->orderBy('id','desc');
        return $this->hasMany(Comment::class)->orderBy('id','asc');
    }

    //relació one to many
    //mètode que retorna array amb els comentaris de l'imatge
    public function likes() {
        //return $this->hasMany($this->like);
        return $this->hasMany(Like::class);
    }

    //relació many to one (belongs to)
    //per treure l'objecte user que ha creat la imatge
    //busca a la taula user, donat paràmetre 'user_id'
    public function user() {
        //return $this->belongsTo('App\Models\User', 'user_id');
        return $this->belongsTo(User::class, 'user_id');
    }
}
