<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // Criar relação de chave extrangeira entre User -> Note
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
