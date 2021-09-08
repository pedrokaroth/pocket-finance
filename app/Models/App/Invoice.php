<?php

namespace App\Models\App;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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
                (DB::raw("(SELECT SUM(value) FROM invoices WHERE status = 'paid' AND user_id = " . Auth::id() . " AND wallet_id = " . walletactive()->id ." AND  type = 'expense' AND YEAR(due_at) = due_year AND MONTH(due_at) = due_month) AS expense")),
                (DB::raw("(SELECT SUM(value) FROM invoices WHERE status = 'paid' AND user_id = " . Auth::id() . " AND wallet_id = " . walletactive()->id ." AND  type = 'income' AND YEAR(due_at) = due_year AND MONTH(due_at) = due_month) AS income"))
            )
            ->where('user_id', Auth::id())
            ->groupByRaw('YEAR(due_at) ASC, MONTH(due_at) ASC')
            ->get();

        if($invoices) {
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
     * @return HigherOrderCollectionProxy|mixed
     */
    public function getCategoryAttribute()
    {
        return $this->category()->first()->name;
    }
}
