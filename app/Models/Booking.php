<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Booking extends Model
{
    protected $fillable = ['user_id', 'room_id', 'check_in', 'check_out', 'total_price', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

     public static function updateRoomAvailability()
    {

        $rooms = Room::with(['bookings' => function ($query) {
            $query->where('status', 'confirmed')
                  ->orderBy('check_out', 'desc')
                  ->first();
        }])->get();

        $today = Carbon::today();

        foreach ($rooms as $room) {
            $latestBooking = $room->bookings->first();

            if ($latestBooking && $today->isSameDay(Carbon::parse($latestBooking->check_out))) {
                $room->update(['is_available' => true]);
            }
        }
    }
}
