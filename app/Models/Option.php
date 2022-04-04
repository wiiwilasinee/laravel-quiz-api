<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'is_correct', 'question_id'];
    protected $hidden = ['is_correct'];
    protected $casts = ['is_correct' => 'boolean'];

    public function scopeCorrect($query)
    {
        return $query->where('is_correct', true);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
