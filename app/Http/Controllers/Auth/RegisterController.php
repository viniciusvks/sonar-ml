<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\LegacyUser;
use App\Models\Role;
use App\Models\User;
use DB;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $roles = [
            Role::PRODUCER => "Produtor Rural",
            Role::TECHNICIAN => "Técnico Rural"
        ];
        return view('auth.register', ['roles' => $roles]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in([Role::PRODUCER, Role::TECHNICIAN])]
        ],[
            'required' => 'O campo :attribute é obrigatório',
            'string' => 'O campo :attribute não deve ser um número',
            'email.email' => 'O campo email deve ter um formato válido',
            'max' => 'Tamanho máximo de caracteres excedido',
            'email.unique' => 'Usuário já cadastrado',
            'password.confirmed' => 'Senha não confere',
            'password.min' => 'A senha deve ter pelo menos :min caracteres'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     * @throws \Throwable
     */
    protected function create(array $data)
    {
        $role = Role::ofType($data['role'])->firstOrFail();

        $legacyUser = new LegacyUser();
        $legacyUser->nome = $data['name'];
        $legacyUser->email = $data['email'];

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);

        DB::transaction(function () use ($user, $legacyUser, $role) {

            $legacyUser->save();

            $user->role()->associate($role);
            $user->legacyUser()->associate($legacyUser);

            $user->save();

        });

        return $user;
    }
}
