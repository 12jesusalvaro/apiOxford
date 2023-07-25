<?php

namespace App\Http\Controllers\Api;
use Laravel\Socialite\Facades\Socialite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Models\User;

class LoginsController extends Controller
{

    public function index()
    {
        // https://stackoverflow.com/a/44663563/15694873
        $original_url = url()->previous();
        session(['original_url' => $original_url]);

        return Socialite::driver('google')->redirect();
    }

    public function store()
    {

        $google_user = Socialite::driver('google')->stateless()->user();

        $user_data = $google_user->user;

        $user = User::updateOrCreate([
            'google_id' => $google_user->id,
        ], [
            'first_name' => $user_data["given_name"],
            'family_name' => $user_data["family_name"],
            'picture' => $user_data["picture"],
            'locale' => $user_data["locale"],
            'email' => $user_data["email"]
        ]);

        Auth::login($user);
        // Crear token con Sanctum para el usuario
        $token = $user->createToken('api_token')->plainTextToken;

        $original_url = session('original_url');

        //return redirect()->to($original_url);
        return redirect()->to($original_url)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ]);
    }

    public function logout() {
        auth()->user()->tokens()->delete();

        return redirect()->route("home.index");
        /*return response()->json([
            "status" => 1,
            "msg" => "Cierre de Sesión",
        ]);*/
    }
}
