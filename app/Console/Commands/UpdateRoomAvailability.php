<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;

class UpdateRoomAvailability extends Command
{
    protected $signature = 'rooms:update-availability';
    protected $description = 'Update room availability based on latest booking checkout dates';

    public function handle()
    {
        Booking::updateRoomAvailability();
        $this->info('Room availability updated successfully.');
    }
}
