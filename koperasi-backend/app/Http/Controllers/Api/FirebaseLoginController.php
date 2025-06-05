<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Auth as FirebaseAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;

class FirebaseLoginController extends Controller
{
    protected $auth;

    public function __construct(FirebaseAuth $auth)
    {
        $this->auth = $auth;
    }

    public function verify(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'token' => 'required|string',
                'role' => 'required|in:user,admin'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $idToken = $request->input('token');
            $role = $request->input('role');

            $verifiedIdToken = $this->auth->verifyIdToken($idToken);
            $firebaseUid = $verifiedIdToken->claims()->get('sub');

            $firebaseUser = $this->auth->getUser($firebaseUid);
            $email = $firebaseUser->email;

            // Cek apakah user sudah ada di database
            $user = User::where('email', $email)->first();

            if (!$user) {
                // Buat user baru jika belum ada
                $user = User::create([
                    'name' => $firebaseUser->displayName ?? 'Pengguna Baru',
                    'email' => $email,
                    'firebase_uid' => $firebaseUid,
                    'role' => $role,
                    'nim' => $firebaseUser->customClaims['nim'] ?? null,
                    'phone' => $firebaseUser->phoneNumber ?? null,
                    'password' => Hash::make(uniqid()), // Password dummy
                    'status' => 'active'
                ]);
            }

            // Login user
            Auth::login($user);

            // Buat token Sanctum
            $token = $user->createToken('firebase_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ]);

        } catch (FailedToVerifyToken $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Firebase token',
                'error' => $e->getMessage()
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'token' => 'required|string',
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'nim' => 'required|string|unique:users',
                'phone' => 'required|string|max:15',
                'role' => 'required|in:user,admin'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $idToken = $request->input('token');
            $verifiedIdToken = $this->auth->verifyIdToken($idToken);
            $firebaseUid = $verifiedIdToken->claims()->get('sub');

            // Cek apakah user sudah ada
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User already exists'
                ], 422);
            }

            // Buat user baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'firebase_uid' => $firebaseUid,
                'role' => $request->role,
                'nim' => $request->nim,
                'phone' => $request->phone,
                'password' => Hash::make(uniqid()),
                'status' => 'active'
            ]);

            // Login user
            Auth::login($user);

            // Buat token Sanctum
            $token = $user->createToken('firebase_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Registration successful',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ], 201);

        } catch (FailedToVerifyToken $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Firebase token',
                'error' => $e->getMessage()
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 