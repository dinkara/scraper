<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'url',
        'content',
        'date',
        'channel_id',
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
