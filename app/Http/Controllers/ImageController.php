<?php

namespace App\Http\Controllers;

//http
use Illuminate\Http\Request;
use Illuminate\Http\Response;

//auth
use Illuminate\Support\Facades\Auth;

//per paginació
use Illuminate\Support\Facades\DB;

//per fitxers
use Illuminate\Support\Facades\Storage;

//time
use Carbon\Carbon;

//models
use App\Models\User;
use App\Models\Image;

class ImageController extends Controller
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

    public function getAll() 
    {
        //
        //obtenir totes les imatges, ordenades per data, amb paginació 3 imatges
        //$imatges = Image::all()->sortByDesc('created_at');
        $imatges = Image::orderBy('created_at','desc')->paginate(3);
        //dd($imatges);

        /*
        return view('image.list', [
            'imatges' => DB::table('images')->paginate(3)
        ]);
        */

        return view('image.list',['imatges' => $imatges]);

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
    public function selectImage()
    {
        return view('image.upload');
    }

    //rebem dades form POST, agafem de request
    public function uploadImage(Request $req)
    {   
        // Retrieve the currently authenticated user...
        //$user = Auth::user();
        
        // Retrieve the currently authenticated user's ID...
        $id = Auth::id();
        //$user = User::find($id);
        $imatge = new Image;

        //validació request
        $req->validate([
            'imatge' => ['required','image','mimes:jpeg,png,jpg,gif,svg'],
            'descripcio' => ['required', 'string'], //only allow this type extension file
        ]);

        //fitxer imatge
        $fitxer = $req->file('imatge');
        //dd($fitxer);
 
        if ($fitxer) {

            //nom
            //$nom = $fitxer->hashName(); // Generate a unique, random name...
            $ext = $fitxer->extension(); // Determine the file's extension based on the file's MIME type...
            $nom = $fitxer->getClientOriginalName(); //agafa nom però té ext
            $nom = pathinfo($nom,PATHINFO_FILENAME); //filtre nom
            $nou = $nom .'_'. Carbon::now()->format('YmdHis').'.'.$ext; //afegim datahora amb carbon
            echo("nom: $nom / ext: $ext / nou: $nou");
            //die();

            //pujar amb nou nom
            $path = Storage::putFileAs('imatges', $fitxer, $nou);

            //model, assignar nom imatge
            $imatge->image_path = $nou;            
        }       

        //agafar dades request
        $des = $req->input('descripcio');

        //assignar dades a obj imatge
        $imatge->user_id = $id; //id usuari auth
        $imatge->description = $des;

        //bbdd
        $imatge->save();

        //amb redirect() cal fer servir session(variable) al blade
        return redirect()->back()->with(['ok' => 'New Image Upload OK ;)'] );
    }

    //retorna imatge usuari
    public function getImatge($filename)
    {
        $file = Storage::disk('imatges')->get($filename);
        return new Response($file,200);
    }
}
