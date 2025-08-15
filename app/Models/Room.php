<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['room_type_id', 'room_number', 'is_available', 'price' , 'image', 'floor_type_id'];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function floorType()
    {
        return $this->belongsTo(FloorType::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
