<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nama_event', 'tanggal', 'deskripsi', 'kategori', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}