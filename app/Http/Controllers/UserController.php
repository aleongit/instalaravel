<?php

namespace App\Http\Controllers;

//http
use Illuminate\Http\Request;
use Illuminate\Http\Response;

//utilitats auth, rule, hash
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

//per fitxers
use Illuminate\Support\Facades\Storage;

//time
use Carbon\Carbon;

//models
use App\Models\User;

class UserController extends Controller
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

    //per retornar form editar dades profile
    public function edit()
    {
        return view('user.edit');
    }

    //rebem dades form POST, agafem de request
    public function update(Request $req)
    {   
        // Retrieve the currently authenticated user...
        //$user = Auth::user();
        
        // Retrieve the currently authenticated user's ID...
        $id = Auth::id();
        $user = User::find($id);

        //validació request
        $req->validate([
            'name' => ['required', 'string', 'regex:/^[a-zA-z]+$/u', 'max:100'],
            'surname' => ['required', 'string', 'max:200'],
            'nick' => ['required', 'string', 'max:100', Rule::unique('users')->ignore($id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'avatar' => ['image','mimes:jpeg,png,jpg,gif,svg','max:2048'] //only allow this type extension file
        ]);

        //fitxer imatge
        $fitxer = $req->file('avatar');
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
            //$path = $request->file('avatar')->storeAs('avatars', $request->user()->id);
            $path = Storage::putFileAs('avatars', $req->file('avatar'), $nou);

            //model
            $user->image = $nou;            
        }       

        //agafar dades request
        $name = $req->input('name');
        $surname = $req->input('surname');
        $nick = $req->input('nick');
        $email = $req->input('email');

        //assignar dades a usuari
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        //bbdd
        $user->update();
        //$user->save();

        //amb redirect() cal fer servir session(variable) al blade
        return redirect()->route('user.edit')
                        ->with(['ok' => 'User Profile Update OK ;)'] );
    }

    /*canviar pass opció versió 8

    public function showChangePasswordGet() {
        return view('user.change-pass');
    }

    public function changePasswordPost(Request $request) {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            // Current password and new password same
            return redirect()->back()->with("error","New Password cannot be same as your current password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        //Change Password

        $id = Auth::id();
        $user = User::find($id);
   
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","Password successfully changed!");
    }
    */

    /*canviar pass versió 9 */
    /*la confirmació email ho fa sol*/

    public function changePassword()
    {
        return view('user.change-pass');
    }

    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);


        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->with("error", "* FATAL ERROR* Password vell incorrecte");
        }

        #Match Old i New
        if( $request->old_password == $request->new_password ) {
            return back()->with("error", "* FATAL ERROR * El nou pass ha de ser diferent que el vell");
        }

        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password canviat OK ;)");
    }

    //retorna avatar
    public function getAvatar($filename)
        {
            $file = Storage::disk('avatars')->get($filename);
            return new Response($file,200);
        }

}
