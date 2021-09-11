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
     * @return bool|null
     */
    public function delete(): ?bool
    {
        if(session()->has('walletfilter') && session()->get('walletfilter') == $this->id) {
            session()->remove('walletfilter');
        }

        if(user()->wallets()->count() == 1 || $this->free) {
            return false;
        }

        return parent::delete();
    }


    /**
     * @return HasMany|Model|object|null
     */
    public static function free()
    {
        return user()->wallets()->where('free', 1)->first();
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
     * @param string $wallet
     * @return mixed
     */
    public static function bootstrap(string $wallet)
    {
        return Wallet::create([
            'wallet' => $wallet,
            'user_id' => user()->id,
            'free' => !user()->hasWallet()
        ]);
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
     * @param $status
     * @param $category
     * @param $date
     * @return Collection
     */
    public function expenses($status, $category, $date): Collection
    {
        return $this->applyFilters(
            $this->invoices()->where('type', 'expense'), $status, $category, $date
        )->get();
    }

    /**
     * @param $status
     * @param $category
     * @param $date
     * @return Collection
     */
    public function incomes($status, $category, $date): Collection
    {
        return $this->applyFilters(
            $this->invoices()->where('type', 'income'), $status, $category, $date
        )->get();
    }

    /**
     * @param $invoices
     * @param $status
     * @param $category
     * @param $date
     * @return mixed
     */
    private function applyFilters($invoices, $status, $category, $date) {
        if($status !== 'all' && filterValidate('status', $status)) {
            $invoices->where('status', $status);
        }

        if($category !== 'all' && filterValidate('category', $category)) {
            $invoices->where('category_id', $category);
        }

        if($date !== 'all' && filterValidate('date', $date)) {
            $invoices->whereMonth('due_at', explode('-', $date)[0]);
            $invoices->whereYear('due_at', explode('-', $date)[1]);
        } else {
            $invoices->whereMonth('due_at', date('m'));
            $invoices->whereYear('due_at', date('Y'));
        }

        return $invoices;
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
}
