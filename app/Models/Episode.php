<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    // Indique les colonnes que vous souhaitez mass-assignable
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

    // Définition de la relation avec le modèle Livre
    public function livre()
    {
        return $this->belongsTo(Livre::class);
    }

    // Définition de la relation avec le modèle Auteur
    public function auteur()
    {
        return $this->belongsTo(Auteur::class);
    }
}