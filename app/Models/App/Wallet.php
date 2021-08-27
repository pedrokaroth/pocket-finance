<?php

namespace App\Models\App;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * Class Wallet
 * @package App\Models\App
 */
class Wallet extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wallet',
        'user_id',
        'free'
    ];

    /**
     * Get the user associated with the wallet.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $value
     */
    public function setFreeAttribute($value)
    {
        $this->attributes['free'] = ($value === true ? 1 : 0);
    }

    public function getBalanceAttribute()
    {
        return "14.56";
    }

    public function getIncomeAttribute()
    {
        return "14.56";
    }

    public function getExpenseAttribute()
    {
        return "14.56";
    }
}
