<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($quiz) {
            $quiz->slug = $quiz->getSlug();
        });
    }


    protected function getSlug()
    {
        $slug = str($this->name)->slug();

        if (env('DB_CONNECTION') !== 'sqlite') {
            $numSlugsFound = self::where('slug', 'regexp', "^" . $slug . "(-[0-9])?")->count();
            if($numSlugsFound > 0) {
                return $slug . "-" . $numSlugsFound + 1;
            }
        }

        return $slug;
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

}
