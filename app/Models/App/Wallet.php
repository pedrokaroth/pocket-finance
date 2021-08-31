<?php

namespace App\Models\App;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * @return mixed
     */
    public static function free()
    {
        return Wallet::where('free', 1)->first();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public static function findById(int $id)
    {
        return Wallet::where('id', $id)->first();
    }

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
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * @return int
     */
    public function userWallets(): int
    {
        return Wallet::where('user_id', user()->id)->count();
    }

    /**
     * @return int|mixed
     */
    public function income()
    {
        return $this->invoices()->where('type', 'income')->sum('value');
    }

    /**
     * @return int|mixed
     */
    public function expense()
    {
        return $this->invoices()->where('type', 'expense')->sum('value');
    }

    /**
     * @return Collection
     */
    public function expenses(): Collection
    {
        return $this->invoices()->where('type', 'expense')->get();
    }

    /**
     * @return Collection
     */
    public function incomes(): Collection
    {
        return $this->invoices()->where('type', 'income')->get();
    }

    /**
     * @return int|mixed
     */
    public function balance()
    {
        return $this->income() - $this->expense();
    }

    /**
     * @param $value
     */
    public function setFreeAttribute($value)
    {
        $this->attributes['free'] = ($value === true ? 1 : 0);
    }

    /**
     * @return string
     */
    public function getBalanceAttribute()
    {
        return "14.56";
    }

    /**
     * @return string
     */
    public function getIncomeAttribute()
    {
        return "14.56";
    }

    /**
     * @return string
     */
    public function getExpenseAttribute()
    {
        return "14.56";
    }
}
