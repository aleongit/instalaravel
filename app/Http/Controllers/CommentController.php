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

class CommentController extends Controller
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

    //per retornar form editar dades profile
    public function newComment($id)
    {   
        //id de la imatge
        //dd($id);

        //$flight = Flight::find(1);
        $imatge = Image::find($id);
               
        //aborta si no existeix
        abort_if(!isset($imatge), 404);

        //buscar si user like
        $like = Like::where('image_id', $id)
                        ->where('user_id', Auth::id())
                        ->get();
        isset($like[0]->id) ? $user_like = True: $user_like = False;

        return view('comment.add',['imatge' => $imatge,
                                    'user_like' => $user_like]);
    }

    //rebem dades form POST, agafem de request + id imatge per paràmetre url
    public function addComment(Request $req, $id_img)
    {   
       //dd($req->input('comentari'));
       //dd($id_img);
        
        // Retrieve the currently authenticated user's ID...
        $id = Auth::id();
        //$user = User::find($id);
        $comentari = new Comment;

        //validació request
        $req->validate([
            'comentari' => ['required','string'],
            ],
            //missatges
            ['comentari.required' => 'No has escrit el comentari!',]
            );

        //agafar dades request
        $nou = $req->input('comentari');

        //assignar dades a obj imatge
        $comentari->user_id = $id; //id usuari auth
        $comentari->image_id = $id_img; // id imatge per paràmetre url
        $comentari->content = $nou;

        //bbdd
        $comentari->save();

        //amb redirect() cal fer servir session(variable) al blade
        return redirect()->back()->with(['ok' => 'New Comment Add OK ;)'] );
    }

    public function delComment($id_com) {
        //dd($id_com);
        $comentari = Comment::find($id_com);
        if ($comentari) {
            $imatge = Image::find($comentari->image_id);
          if ($imatge) {
            $comentari->delete();
            return redirect()->back();
          }
        }        
        return redirect('home');
    }

}
