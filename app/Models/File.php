<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'filename',
        'disk',
        'extension',
        'mime',
        'size',
        'path',
        'url',
        'livre_id',
        'auteur_id',
    ];

    public function livre()
    {
        return $this->belongsTo(Livre::class);
    }

    public function auteur()
    {
        return $this->belongsTo(Auteur::class);
    }
    
}