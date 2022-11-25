<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//controllers
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

//models
//use App\Models\Image;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*test*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/

/*
Route::get('/', function () {
    
    //obtenir totes les imatges
    $imatges = Image::all();
    //dd($imatges);
    
    foreach ($imatges as $img) {
        echo $img->image_path . "<br>";
        echo $img->description . "<br>";
        echo $img->user->name. ' ' . $img->user->surname . "<br>";
        //echo $img->comments;
        
        if ( $img->comments ) {
            foreach($img->comments as $com) {
                //dd($com->user->name);   
                echo $com->user->name. ' ' .$com->user->surname. ': ';
                echo $com->content. '<br>'; 
            }
        }
        echo '<hr>';
    }
    die();
    return view('welcome');
});
*/


Route::get('/', function () {
    return redirect('home');
});

/*home*/
Route::get('/home', [ImageController::class, 'getAll'])
->name('home');;

//autentificació laravel ui (login + register)
Auth::routes();

/*
Route::get('/home', [HomeController::class, 'index'])
->name('home');
*/

//canviar dades usuari
//Route::resource('profile', ProfileController::class)->only('edit','update');
Route::get('/user/edit', [UserController::class, 'edit'])
->name('user.edit');

Route::post('/user/update', [UserController::class, 'update'])
->name('user.update');

//canviar pass v8
//Route::get('/changePassword', [UserController::class, 'showChangePasswordGet'])->name('changePasswordGet');
//Route::post('/changePassword', [UserController::class, 'changePasswordPost'])->name('changePasswordPost');

//canviar pass v9
Route::get('/change-password', [UserController::class, 'changePassword'])
->name('change-password');
Route::post('/change-password', [UserController::class, 'updatePassword'])
->name('update-password');

//per obtenir imatge avatar, per utilitzar en blade (img src)
Route::get('avatar/{filename}', [UserController::class, 'getAvatar'])
->name('get-avatar');

//upload imatge
Route::get('/upload-image', [ImageController::class, 'selectImage'])
->name('select-image');
Route::post('/upload-image', [ImageController::class, 'uploadImage'])
->name('upload-image');

//per obtenir imatges que han pujat usuaris
Route::get('imatge/{filename}', [ImageController::class, 'getImatge'])
->name('get-imatge');

//add comment
Route::get('/imatge/comments/{img}', [CommentController::class, 'newComment'])
->name('new-comment')
->where('img', '[0-9]+');

Route::post('/imatge/comments/{img}', [CommentController::class, 'addComment'])
->name('add-comment')
->where('img', '[0-9]+');

//del comment
Route::get('/imatge/comments/del/{comment}',[CommentController::class, 'delComment'])
->name('del-comment')
->where('img', '[0-9]+');

//like
Route::get('/imatge/like/{img}', [LikeController::class, 'toggleLike'])
->name('like-image')
->where('img', '[0-9]+');