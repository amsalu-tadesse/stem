<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;

use App\Models\Email;
use App\Mail\SendMail;
use App\Models\Profile;
use Illuminate\Support\Str;
use App\Constants\Constants;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Services\EmailService;
use App\DataTables\UsersDataTable;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\OrganizationLevel;
use App\Models\Setting;
use App\Traits\ModelAuthorizable;
use Symfony\Component\Console\Exception\ExceptionInterface;

class ProfileController extends Controller
{
    public function changeProfile(Request $request)
    {
        $current_user_id = auth()->user()->id;
        $users = User::find(auth()->user()->id);

        $this->validate($request, [
            'position' => 'nullable',
            'education' => 'nullable',
            'profession' => 'nullable',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',


        ]);


        if ($users) {
            $users->update([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,

            ]);
        }

        $profile = Profile::where('user_id', $current_user_id)->first();
        // $imagePath = null; // Initialize image path variable


        if ($profile) {
            if ($request->hasFile('profile_image')) {
                $profile_image_path = $request->file('profile_image')->store('profile_images', 'public');
                $profile->update([
                    'position' => $request->position,
                    'education' => $request->education,
                    'profession' => $request->profession,
                    'profile_image' => $profile_image_path,
                ]);
            } else {
                $profile->update([
                    'position' => $request->position,
                    'education' => $request->education,
                    'profession' => $request->profession,
                ]);
            }
        } else {
            if ($request->hasFile('profile_image')) {
                $profile_image_path = $request->file('profile_image')->store('profile_images', 'public');
                $profile = Profile::create([
                    'position' => $request->position,
                    'education' => $request->education,
                    'profession' => $request->profession,
                    'user_id' => $current_user_id,
                    'profile_image' => $profile_image_path,
                ]);
            } else {
                $profile = Profile::create([
                    'position' => $request->position,
                    'education' => $request->education,
                    'profession' => $request->profession,
                    'user_id' => $current_user_id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    public function profile()
    {
        $current_user_id = auth()->user()->id;

        $profile = Profile::where('user_id', $current_user_id)->first();
        return view('admin.accountSetting.accountSetting', compact('profile'));
    }
}
