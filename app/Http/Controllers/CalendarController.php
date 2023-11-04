<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Session;

class CalendarController extends Controller
{
    public function addToCalendar(Event $event)
    {
        // Initialize Google Client
        $client = new Google_Client();
        $client->setApplicationName('STEM');
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $client->setAuthConfig(storage_path('client_secrets/client_secret.json')); // Path to your client secret JSON file obtained from Google Cloud Console
        $client->setAccessType('offline'); // Allow offline access
        $client->setPrompt('select_account consent');
        $client->setState(['event' => $event->id]);

        // Generate authorization URL
        $authUrl = $client->createAuthUrl();
        // save privious url in session
        Session::put('previous_route', url()->previous());
        // Redirect the user to the authorization URL
        return redirect()->away($authUrl);
    }

    public function calendarCallback()
    {
        $event_id = request()->query('state');
        $event = Event::find($event_id);

        // Create Google Client and authenticate with the authorization code
        $client = new Google_Client();
        $client->setApplicationName('STEM');
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $client->setAuthConfig(storage_path('client_secrets/client_secret.json')); // Path to your client secret JSON file obtained from Google Cloud Console
        $client->setAccessType('offline'); // Allow offline access
        $client->setPrompt('select_account consent');

        // Exchange the authorization code for access and refresh tokens
        $accessToken = $client->fetchAccessTokenWithAuthCode(request('code'));
        $client->setAccessToken($accessToken);

        // Create a new Google Calendar service instance
        $service = new Google_Service_Calendar($client);


        $start_date = Carbon::parse($event->start_date); // Convert the date string to a Carbon instance
        $start_date = $start_date->format('Y-m-d\TH:i:s.v\Z'); // Format the date

        $end_date = Carbon::parse($event->end_date); // Convert the date string to a Carbon instance
        $end_date = $end_date->format('Y-m-d\TH:i:s.v\Z'); // Format the date

        // Retrieve the event details from your database or any other source based on the $eventId
        $event_template = [
            'summary' => $event->topic,
            'location' => $event->address,
            'description' => $event->description . "\n \n \n join us with link: ". $event->link,
            'start' => [
                'dateTime' => $start_date,
                'timeZone' => 'Africa/Addis_Ababa',
            ],
            'end' => [
                'dateTime' => $end_date,
                'timeZone' => 'Africa/Addis_Ababa',
            ],
        ];

        // Create a Google Calendar event
        $calendarEvent = new Google_Service_Calendar_Event($event_template);
        // dd('Event created: %s\n', $calendarEvent);

        try {
            $inserted_event = $service->events->insert('primary', $calendarEvent);
            $event_id = $inserted_event->getId();

            if (!empty($event_id)) {
                // Retrieve the previous route from the session
                $previous_route = Session::get('previous_route');

                // Clear the previous route from the session
                Session::forget('previous_route');

                return redirect($previous_route)->with(['sucess_add_calender' => ucwords($event->topic) . ' event has been successfuly added to your calendar!']);
            } else {
                dd("Failed to add the event.");
            }
        } catch (Exception $e) {
            dd("An error occurred: " . $e->getMessage());
        }
        // Redirect the user to a success page or display a success message
    }
}
