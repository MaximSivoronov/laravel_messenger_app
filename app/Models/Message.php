<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $table = 'messages';

    /**
     * Returns the user that send this message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fromContact()
    {
        return $this->hasOne(User::class, 'id', 'from');
    }
}
