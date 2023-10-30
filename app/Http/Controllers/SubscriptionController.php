<?php

namespace App\Http\Controllers;

use App\Constants\Constants;
use App\DataTables\SubscriptionsDataTable;
use App\Models\Subscription;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Models\Email;
use App\Models\OrganizationLevel;
use App\Models\User;
use App\Services\EmailService;
use App\Traits\ModelAuthorizable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class SubscriptionController extends Controller
{
    use ModelAuthorizable;

    /**
     * Display a listing of the resource.
     */
    public function index(SubscriptionsDataTable $dataTable)
    {
        return $dataTable->render('admin.subscriptions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionRequest $request, EmailService $emailService)
    {
        $email = $request->input('email');
        $levels = $request->input('level');
        $user = User::where('email', $email)->first();

        // Loop through selected levels
        $links = ['<br>'];
        foreach ($levels as $level) {
            // Check if there's an existing subscription with the same email and level
            $existingSubscription = Subscription::where('email', $email)
                ->where('level', $level)
                ->first();
            if ($existingSubscription) {
                // Handle case where user is already subscribed to this level
                $levelN = OrganizationLevel::find($level);
                $levelN = $levelN->name;
                return response()->json(['success' => 0, 'message' => "You are already subscribed to the '$levelN' level."]);
            }
            // Create a new subscription
            $token = Str::uuid(); // Generate a random 60-character token
            $levelN = OrganizationLevel::find($level);
            $levelN = $levelN->name;
            $links[] = $levelN . ' ' . 'Level: <a href=' . Constants::DOMAIN . '/unsubscribe/' . urlencode($token) . '>click here</a>';

            Subscription::create([
                'email' => $email,
                'level' => $level,
                'token' => $token
            ]);
            $response['message'] = 'You have subscribed successfully';
            $response['success'] = 1;
        }

        $messageObj = Email::where('code', 'email:on_subscribe')->first();
        if ($messageObj->status == 1) {
            $body = $messageObj->body;
            $body = str_ireplace("{user}", $user?->first_name, $body);
            $body = str_ireplace("{link}", implode("<br>", $links), $body);
            $message['title'] = $messageObj->subject;
            $message['body'] = $body;

            try {
                // $emailService->sendMail($request->input('email'), null, $message);
                dispatch(new \App\Jobs\SendEmailJob([$request->input('email')], [], $message));
            } catch (\Exception $e) {
                // Handle the exception, log it, or output an error message
            }
        }
        return response()->json($response);
    }



    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubscriptionRequest $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {

        if (!$subscription->exists()) {
            return redirect()->route('admin.subscriptions.index')->with('error', 'Unautorized!');
        }
        $subscription->delete();
        return response()->json(array("success" => true), 200);
    }



    public function confirmUnsubscribe()
    {
        $subscription = Subscription::where('token', urldecode(request('token')))->first();

        if ($subscription) {
            $subscription->delete();
            return back()->with('success', 'You have been successfully unsubscribed.');
        }
        return back()->with('error', 'Subscription not found.');
    }
}
