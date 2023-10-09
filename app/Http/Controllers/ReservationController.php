<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReservationController extends Controller
{
    public function all()
    {
        $reservations = Reservation::all() // Get all the existing studio reservations & transform them to the object-format that our calendar understands
            ->map(function (Reservation $reservation): array {
                $start = "$reservation->day $reservation->start";
                $end = "$reservation->day $reservation->end";
                return [
                    "id" => $reservation->id,
                    "title" => $reservation->title,
                    "color" => 'Tomato',
                    "start" => $start,
                    "end" => $end,
                    "borderColor" => 'Red',
                ];
            });

        return response()->json([
            // Return our object as a JSON response
            "reservations" => $reservations,
        ]);
    }

    public function one(Reservation $reservation) {
        return view('reservation', compact('reservation'));
    }
    public function store(Request $request)
    {

        $reservations = Reservation::all();

        $request_start = Carbon::parse($request->start)->format('H:i:s');
        $request_end = Carbon::parse($request->end)->format('H:i:s');

        $currentDateTime = Carbon::now();
        $requestDateTime = Carbon::parse("$request->day $request->start");

        if($requestDateTime->lessThan($currentDateTime)) {
            return back()->with('error', "You can't create a reservation in the past shit-face");
        };



        if ($request->start >= $request->end) { // Check if reservation's start is after reservation's end. Example: starts at 10, ends at 9. And if It starts and ends at the same time
            return back()->with('error', "You can't end a reservation before/when it starts lol");
        } 

        foreach ($reservations as $reservation) {
            if ($request->day == $reservation->day) { // Check if the reservation day match with any other reservation, if so proceed to the next validations 

                $condition1 = ($reservation->start <= $request_start) && ($request_start < $reservation->end); // Check if the New reservation start_hour is between the Old reservatinon start and end hours
                $condition2 = ($reservation->start < $request_end) && ($request_end <= $reservation->end); // Check if the New reservation end_hour is between the Old reservatinon start and end hours
                $condition3 = ($request_start <= $reservation->start) && ($reservation->start < $request_end); // Check if the Old reservation start_hour is between the New reservatinon start and end hours
                $condition4 = ($request_start < $reservation->end) && ($reservation->end <= $request_end); // Check if the Old reservation end_hour is between the New reservatinon start and end hours
                
                if ($condition1 or $condition2 or $condition3 or $condition4) { // If one of the conditions is met, don't create a reservation
                    return back()->with('error', "There's already a reservation slotted for this time stamp!!");
                }
            }
        }

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'day' => $request->day,
            'start' => $request_start,
            'end' => $request_end,
        ];

        Reservation::create($data);

        return back()->with('success', "Reservation Added Successfuly");

    }
}