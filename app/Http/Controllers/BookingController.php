<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index() {
        return view('dashboard', [
            'bookings' => Booking::with('field')->latest()->get(),
            'fields' => Field::all()
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'customer_name' => 'required|string',
            'start_time' => 'required',
            'duration' => 'required|integer|min:1',
        ]);

        $field = Field::findOrFail($request->field_id);
        $total_price = $field->price_per_hour * $request->duration;

        Booking::create([
            'field_id' => $request->field_id,
            'customer_name' => $request->customer_name,
            'start_time' => $request->start_time,
            'duration' => $request->duration,
            'total_price' => $total_price,
        ]);

        return back()->with('status', 'Booking Berhasil!');
    }

    public function destroy(Booking $booking) {
        $booking->delete();
        return back()->with('status', 'Booking Dihapus!');
    }
}
