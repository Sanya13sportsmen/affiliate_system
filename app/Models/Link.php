<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'name', 'url', 'code'
    ];

    protected $with = [
        'visitors', 'clicks'
    ];

    public function setCodeAttribute()
    {
        $this->attributes['code'] = substr(sha1(microtime()), 0, 12);
    }

    public function visitors() {
        return $this->hasMany(Visitor::class);
    }

    public function clicks() {
        return $this->hasMany(Click::class);
    }
}
