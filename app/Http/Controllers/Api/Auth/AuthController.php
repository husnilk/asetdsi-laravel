<?php 
namespace App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Student;
 
class AuthController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'nim' => 'required|unique:mahasiswa',
            'name' => 'required',
            'email' => 'required|unique:mahasiswa',
            'username' => 'required|unique:mahasiswa',
            'password' => 'required|min:5'
        ]);
        $nim = $request->input('nim');
        $name = $request->input('name');
        $email = $request->input('email');
        $username = $request->input('username');
        $password = Hash::make($request->input('password'));

        $user = Mahasiswa::create([
            'nim' => $nim,
            'name' => $name,
            'email' => $email,
            'username' => $username,
            'password' => $password
            
        ]);

        return response()->json(['message' => 'Pendaftaran pengguna berhasil dilaksanakan',
        'data' => $user]);
    }


    public function login(Request $request){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ],[
            'required'  => 'Harap bagian :attribute di isi.'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $user = Mahasiswa::where('username', $username)->first();
        if (!$user) {
            return response()->json(['message' => 'Login failed'], 401);
        }

        $isValidPassword = Hash::check($password, $user->password);
        if (!$isValidPassword) {
            return response()->json(['message' => 'Login failed'], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        $mahasiswa = Mahasiswa::where('id',$user->id)->first();

        return response()->json([
            'message' => 'success',
            'data' => [
                'nim' => $mahasiswa->nim,
                'name' => $mahasiswa->name,
                'email' => $mahasiswa->email,
                'username' => $mahasiswa->username,
                'token' => $token
            ],
            'token_type' => 'bearer',
        
        ],200);
    }

    public function logout(Request $request)
    {
        $user =auth('sanctum')->user();
       
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'Tokens Delete'
        ];
    }
    
}