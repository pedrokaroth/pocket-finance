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
     *
     */
    protected static function boot()
    {
        parent::boot();

        if(auth()->check()) {
            self::creating(function($model) {
                $model->free = !user()->hasWallet();
                $model->user_id = user()->id;
            });
        }
    }

    /**
     * @return bool|null
     */
    public function delete(): ?bool
    {
        if(user()->wallets()->count() == 1 || $this->free) {
            return false;
        }

        if(session()->has('walletfilter') && session()->get('walletfilter') == $this->id) {
            session()->remove('walletfilter');
        }

        return parent::delete();
    }


    /**
     * @return HasMany|Model|object|null
     */
    public static function free(): ?Wallet
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
        return $this->invoices()
            ->where('type', 'income')
            ->where('repeat_when', 'single')
            ->where('status', 'paid')
            ->sum('value');
    }

    /**
     * @return int|mixed
     */
    public function expense()
    {
        return $this->invoices()
            ->where('type', 'expense')
            ->where('repeat_when', 'single')
            ->where('status', 'paid')
            ->sum('value');
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
            $this->invoices()
                ->where('type', 'expense')
                ->where('repeat_when', 'single'),
                $status, $category, $date
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
            $this->invoices()
                ->where('type', 'income')
                ->where('repeat_when', 'single'),
                $status, $category, $date
        )->get();
    }

    public function fixed(): Collection
    {
        return $this->invoices()->where('repeat_when', 'fixed')->get();
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
