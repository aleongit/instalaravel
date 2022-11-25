<?php

namespace App\Http\Controllers;

//http
use Illuminate\Http\Request;
use Illuminate\Http\Response;

//auth
use Illuminate\Support\Facades\Auth;

//models
use App\Models\Comment;
use App\Models\User;
use App\Models\Image;
use App\Models\Like;

class LikeController extends Controller
{   

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); //controlador només per autoritzats
                                   //->es pot usar except mètodes
    }

    public function edit()
    {
        //
    }

    //rebem dades form POST, agafem de request
    public function update(Request $req)
    {   
        //
    }

    public function toggleLike($id_img) {
        //dd($id_com);
         $imatge = Image::find($id_img);
         if ($imatge) {

            $like = Like::where('image_id', $id_img)
                        ->where('user_id', Auth::id())
                        ->get();
            //dd($like[0]->id);

            //si existeix id en 1r registre de l'array resultats 
            // només hi pot haver 0 o 1 items.

            if ( isset($like[0]->id) ) {
                echo('si like');
                //fes dislike
                $borra = Like::find($like[0]->id);
                $borra->delete();

            } else {
                echo('no like');
                //fes like
                $nou = new Like;

                //assignar dades a obj imatge
                $nou->user_id = Auth::id(); //id usuari auth
                $nou->image_id = $id_img; // id imatge per paràmetre url

                //bbdd
                $nou->save();
            }
         }
            
        return redirect()->back();
    }

    //mètode static de crida al blade, envia id, retorna boleana
    public static function userLike($id_img) {
        //dd($id_com);
         $imatge = Image::find($id_img);
         if ($imatge) {

            $like = Like::where('image_id', $id_img)
                        ->where('user_id', Auth::id())
                        ->get();
            //dd($like[0]->id);
            isset($like[0]->id) ? $user_like = True: $user_like = False;

            }    
        return $user_like;
    }

}
