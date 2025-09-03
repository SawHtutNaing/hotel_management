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
    $today = Carbon::today();
    Room::whereHas('bookings', function ($query) use ($today) {
        $query->where('status', 'confirmed')
              ->whereDate('check_out', '<=', $today);
    })->update(['is_available' => true]);
}


}
