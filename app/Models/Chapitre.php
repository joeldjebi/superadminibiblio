<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapitre extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 
        'description', 
        'filename', 
        'url', 
        'disk', 
        'extension', 
        'path', 
        'mime', 
        'size', 
        'auteur_id',
        'livre_id', 
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