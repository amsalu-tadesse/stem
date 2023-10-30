<?php

namespace App\Http\Controllers;

use App\Constants\Constants;
use App\Http\Controllers\Utility;
use Illuminate\Http\Request;

use App\Models\User;
use Exception;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\CustomException;
use App\Models\Email;
use App\Models\Organization;
use App\Models\Setting;
use App\Services\EmailService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
// use App\Http\Requests\?

class AuthController extends Controller
{


    /**
     * Login The User
     * @param Request $request
     * @return User
     */

    public function index()
    {
        // $signupAllowed = Setting::find('code'=='allow_user_signup');
        $signupAllowed = Setting::where('code', 'allow_user_signup')->where('value1', 1)->exists();


        // dd($signupAllowed);
        return view('admin.auth.login', (['signupAllowed' => $signupAllowed]));
    }

    public function loginUser(Request $request)
    {
        //  dd("This is Dampping");
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );
            if ($validateUser->fails()) {
                return redirect("/login")->withSuccess('Opps! You do not have access');
            }
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return redirect("/login")->withSuccess('Opps! You do not have access');
            }


            //check if email is verified
            $user = Auth::user();
            $user->email_verified_at = new \DateTime();
            $user->save();

            if ($user->password_changed) {
                return redirect()->route('admin.dashboard');
            } else {

                return redirect()->route('admin.profile');
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function create()
    {

        //check setting..

        $signupAllowed = Setting::where('code', 'allow_user_signup')->where('value1', 1)->exists();
        $terms = Setting::where('code', 'privacy_policy')->first();
        $organizations = Organization::all();

        if ($signupAllowed) {
            return view('admin.auth.register', ([
                'organizations' => $organizations,
                'terms' => $terms,
            ]));
        } else {

            // return view('admin.auth.login');
            return Redirect::to('/login');
        }
    }
    public function signup(StoreUserRequest $request, EmailService $emailService)
    {

        $terms = $request->input('terms');

        if ($terms) {
            $user = User::create($request->validated());
            // $password =  Str::password(10);
            $password = Utility::getRandomStringRandomInt(8);
            $user->password = $password;
            $user->save();

            //Mailing
            $messageObj = Email::where('code', 'email:on_user_signup')->first();
            // dd($messageObj->status);
            if ($messageObj?->status == 1) {
                $body = $messageObj->body;
                $link = Constants::DOMAIN . '/login';
                $body = str_ireplace("{user}", $user?->first_name, $body);
                $body = str_ireplace("{password}", $password, $body);
                $body = str_ireplace("{link}", $link, $body);
                $message['title'] = $messageObj->subject;
                $message['body'] = $body;


                try {

                    // $emailService->sendMail([$request->input('email')], null, $message);
                    dispatch(new \App\Jobs\SendEmailJob([$request->input('email')], [], $message));
                } catch (Exception $ex) {
                    dd($ex);
                    return redirect()->route('login')->with('message', 'Registration was successfull. Now you can login.');
                }
            }
        }

        return redirect()->route('login')->with('message', 'Registration was successfull. We have sent you a default password to access the system.');
    }

    public function changePasswordSave(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            // 'new_password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'new_password' => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $auth = Auth::user();
        if (Hash::check($request->current_password, Auth::user()->password)) {
            $user =  User::find($auth->id);
            $user->password =  Hash::make($request->new_password);
            $user->password_changed = 1;
            $user->save();
            return redirect()->back()->with('success', 'Password changed successfully.');
        } else {
            return redirect()->back()->withErrors(['current_password' => 'Incorrect current password.']);
        }

    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Forget the cached permissions for roles and permissions
        $role = new Role();

        // Create an instance of the Permission model
        $permission = new Permission();

        // Forget the cached permissions for roles and permissions
        $role->forgetCachedPermissions();
        $permission->forgetCachedPermissions();


        return redirect()->route('login');
    }
}
