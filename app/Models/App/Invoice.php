<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HigherOrderCollectionProxy;
use stdClass;

/**
 * Class Invoice
 * @package App\Models\App
 */
class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'value', 'due_at', 'wallet_id', 'category', 'comments', 'user_id', 'category_id', 'comments',
        'repeat_when', 'status', 'type', 'repeat_type', 'invoice_of', 'cloned'
    ];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        if(auth()->check()) {
            self::creating(function($model) {
                $model->user_id = user()->id;
            });
        }
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @param int $id
     * @param array $fields
     * @return mixed
     */
    public static function findById(int $id, array $fields = ['*'])
    {
        return Invoice::where('id', $id)->first($fields);
    }

    /**
     * @return stdClass
     */
    public function dashboardChartData(): stdClass
    {
        $invoices = DB::table('invoices')
            ->select(
                (DB::raw('YEAR(due_at) AS due_year')),
                (DB::raw('MONTH(due_at) AS due_month')),
                (DB::raw("(SELECT SUM(value) FROM invoices WHERE repeat_when = 'single' AND status = 'paid' AND user_id = " . Auth::id() . " AND wallet_id = " . walletactive()->id ." AND  type = 'expense' AND YEAR(due_at) = due_year AND MONTH(due_at) = due_month AND deleted_at IS NULL) AS expense")),
                (DB::raw("(SELECT SUM(value) FROM invoices WHERE repeat_when = 'single' AND status = 'paid' AND user_id = " . Auth::id() . " AND wallet_id = " . walletactive()->id ." AND  type = 'income' AND YEAR(due_at) = due_year AND MONTH(due_at) = due_month AND deleted_at IS NULL) AS income"))
            )
            ->where('user_id', Auth::id())
            ->whereRaw('MONTH(due_at) <= MONTH(NOW())')
            ->whereRaw('YEAR(due_at) <= YEAR(NOW())')
            ->groupByRaw('YEAR(due_at) ASC, MONTH(due_at) ASC')
            ->get();

        if($invoices->count()) {
            foreach ($invoices as $invoice) {
                $chartCategories[] = $invoice->due_month . '/' . $invoice->due_year;
                $chartExpense[] = $invoice->expense ?? 0;
                $chartIncome[] = $invoice->income ?? 0;
            }
        } else {
            for ($month = -4; $month <= 0; $month++) {
                $chartDate[] = date("m/Y", strtotime("{$month}month"));
            }
        }


        $chartData = new \stdClass();
        $chartData->categories = $chartCategories ?? $chartDate;
        $chartData->expense = $chartExpense ?? [0,0,0,0,0];
        $chartData->income = $chartIncome ?? [0,0,0,0,0];

        return $chartData;
    }

    /**
     * Define the invoice was cloned
     */
    public function setAsCloned()
    {
        $this->update(['cloned' => true]);
    }

    /**
     * @return HigherOrderCollectionProxy|mixed
     */
    public function getCategoryAttribute()
    {
        return $this->category()->first()->name;
    }

    /**
     * @return string
     */
    public function getRepeatDateAttribute()
    {
        switch ($this->repeat_type) {
            case 'weekly':
                return 'Toda ' . __('messages.' . date('D', strtotime($this->due_at)));

            case 'monthly':
                return 'Todo dia ' . date('d', strtotime($this->due_at)) ;

            case 'annually':
                return 'Todo ano em ' . date('d/m', strtotime($this->due_at));

            default:
                return '';
        }
    }

    /**
     * @param $value
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = (float)str_replace(['.', ','],['', '.'] ,$value);
    }
}
