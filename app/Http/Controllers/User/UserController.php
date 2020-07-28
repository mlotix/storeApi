<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\User;
use App\Mail\UserCreated;
use App\Mail\UserEmailUpdated;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

class UserController extends ApiController
{
  public function __construct()
  {
    $this->middleware('auth:api')->only(['update', 'destroy', 'resend_update', 'logout', 'single', 'show']);
    $this->middleware('scope:manage-account')->only(['resend_update', 'update', 'destroy']);
    $this->middleware('can:view,user')->only('show');
    $this->middleware('can:update,user')->only('update');
    $this->middleware('can:delete,user')->only('destroy');
    $this->middleware('can:resend,user')->only('resend_update');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //admin only
    {
      Gate::authorize('make-admin-action');
        $users = User::all();
        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
          'name' => 'required',
          'email' => 'required|email|unique:users',
          'password' => 'required|min:6|max:32|confirmed',
        ];
        $data = $request->validate($rules);
        $data['password'] = Hash::make($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationToken();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);

        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
      //$this->authorize('view', $user);
        return $this->showOne($user);
    }

    public function single(Request $request)
    {
      return $this->showOne($request->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
          'email' => 'email|unique:users,email,' . $user->id, //appending to the string id of user
          'password' => 'min:6|max:32|confirmed',
          'admin' => 'in:' . User::REGULAR_USER . ',' . User::ADMIN_USER,
        ];

        $request->validate($rules);

        if($request->filled('name')) {
          $user->name = $request->name;
        }
        if($request->filled('email')) {
          $user->verified = User::UNVERIFIED_USER;
          $user->verification_token = User::generateVerificationToken();
          $user->email = $request->email;
          $user->$user_email_verified_at = null;
        }
        if($request->filled('password')) {
          $user->password = Hash::make($request->password);
        }
        if($user->isClean()) {
          return $this->errorResponse('Nothing has changed', 422);
        }

        $user->save();
        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $this->showOne($user);
    }

    /**
     * Verify the user.
     *
     * @param  string token
     * @return \Illuminate\Http\Response
     */
     public function verify($token) {
       $user = User::where('verification_token', '=', $token)->firstOrFail();

       $user->verified = User::VERIFIED_USER;
       $user->verification_token = null;
       $user_email_verified_at = now();

       $user->save();
       return $this->showMsg('User has been verified');
     }

     public function resend_verify($email) {
       $user = User::where('email', '=', $email)->firstOrFail();

       if($user->verified = User::VERIFIED_USER) {
         return $this->errorResponse('This user is already verified', 409);
       }

       retry(4, function() use ($user) {
         Mail::to($user)->send(new UserCreated($user));
       }, 250);

       return $this->showMsg('The email has been resend. Check your inbox');
     }

     public function resend_update($email) {
       $user = User::where('email', '=', $email)->firstOrFail();

       if($user->verified = User::VERIFIED_USER) {
         return $this->errorResponse('This user is already verified', 409);
       }

       retry(4, function() use ($user) {
         Mail::to($user)->send(new UserEmailUpdated($user));
       }, 250);

       return $this->showMsg('The email has been resend. Check your inbox');
     }

     public function login(Request $request)
     {

       try {
         $response = Http::asForm()->post('http://storeapi.test/oauth/token/', [
           'username' => $request->username,
           'password' => $request->password,
           'grant_type' => 'password',
           'client_id' => '2',
           'client_secret' => 'ii7iAuj3qb5lBtfKSmYqfHImvaPMXASpmXwGKkAr',
           'scope' => 'manage-account read-stats purchase-product manage-products',
         ]);

         if($response->ok()) {
           return $response->json();
         }
         if($response->status() == 400) {
           return $this->errorResponse('Invalid credentials', 422);
         }
       } catch (\Exception $e) {
         return $this->errorResponse('Internal server error', 500);
       }
     }

     public function refresh(Request $request)
     {
       try {
         $response = Http::asForm()->post('http://storeapi.test/oauth/token/', [
           'refresh_token' => $request->refresh_token,
           'grant_type' => 'refresh_token',
           'client_id' => '2',
           'client_secret' => 'ii7iAuj3qb5lBtfKSmYqfHImvaPMXASpmXwGKkAr',
           'scope' => 'manage-account read-stats purchase-product manage-products',
         ]);

         if($response->ok()) {
           return $response->json();
         }
         if($response->status() == 400) {
           return $this->errorResponse('Invalid credentials', 422);
         }
         if($response->status() == 401 || $response->status() == 403) {
           return $this->errorResponse('unauthenticated', 401);
         }
       } catch (\Exception $e) {
         return $this->errorResponse('Internal server error', 500);
       }
     }

     public function logout()
     {
       if(Auth::User()->token()) {
         Auth::User()->token()->revoke();
       }
       return $this->successResponse(['data' => 'User has been logged out', 'code' => 200], 200);
     }
}
