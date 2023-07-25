<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $original_url = url()->previous();
        session(['original_url' => $original_url]);

        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        $google_user = Socialite::driver('google')->stateless()->user();

        $user = User::where('google_id', $google_user->getId())->first();

        if (!$user) {
            $user = User::create([
                'google_id' => $google_user->getId(),
                'name' => $google_user->getName(),
                'email' => $google_user->getEmail(),
                // Otras propiedades del usuario que desees guardar
            ]);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        $original_url = session('original_url');
        return redirect()->to($original_url)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ]);
    }

    public function getOrders(Request $request)
    {
        $user = Auth::user();
        $orders = $user->orders; // Asumiendo que tienes una relación en el modelo User para obtener las órdenes

        return response()->json(['orders' => $orders]);
    }
}
