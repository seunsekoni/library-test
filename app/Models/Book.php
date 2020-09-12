<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function setAuthorIdAttribute($author)
    {
        $this->attributes['author_id'] = Author::firstOrCreate([
            'name' => $author,
            ])->id;
            // dd($this->attributes);
    }

    public function checkout($user)
    {
        $this->reservations()->create([
            'user_id' => $user->id,
            'checked_out_at' => now(),
        ]);
    }

    public function checkin($user)
    {
        try {
        } catch (\Throwable $th) {
            throw $th;
        }
        $reservation = $this->reservations()->where('user_id', $user->id)
            ->whereNotNull('checked_out_at')
            ->whereNull('checked_in_at')
            ->first();

        if(is_null($reservation)) {
            throw new \Exception;
        }

        $reservation->update([
            'checked_in_at' => now() 
        ]);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
