<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Invoice
 * @package App\Models\App
 */
class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'value', 'due_at', 'wallet_id', 'category', 'comments', 'user_id', 'category_id', 'comments',
        'repeat_when', 'status', 'type'
    ];

    /**
     * @param $value
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = (float)str_replace(['.', ','],['', '.'] ,$value);
    }
}
