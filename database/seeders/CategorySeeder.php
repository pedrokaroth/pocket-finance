<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Incomes
        DB::table('categories')->insert(['name' => 'Salário', 'type' => 'income', 'created_at' => Carbon::now()]);
        DB::table('categories')->insert(['name' => 'Investimentos', 'type' => 'income', 'created_at' => Carbon::now()]);
        DB::table('categories')->insert(['name' => 'Outras Receitas', 'type' => 'income', 'created_at' => Carbon::now()]);

        //Expenses
        DB::table('categories')->insert(['name' => 'Alimentação', 'type' => 'expense', 'spent' => '', 'created_at' => Carbon::now()]);
        DB::table('categories')->insert(['name' => 'Educacação', 'type' => 'expense', 'spent' => '', 'created_at' => Carbon::now()]);
        DB::table('categories')->insert(['name' => 'Entreterimento', 'type' => 'expense', 'spent' => '', 'created_at' => Carbon::now()]);
        DB::table('categories')->insert(['name' => 'Impostos e Taxas', 'type' => 'expense', 'spent' => '', 'created_at' => Carbon::now()]);
        DB::table('categories')->insert(['name' => 'Saúde', 'type' => 'expense', 'spent' => '', 'created_at' => Carbon::now()]);
        DB::table('categories')->insert(['name' => 'Serviços', 'type' => 'expense', 'spent' => '', 'created_at' => Carbon::now()]);
        DB::table('categories')->insert(['name' => 'Viagem', 'type' => 'expense', 'spent' => '', 'created_at' => Carbon::now()]);
        DB::table('categories')->insert(['name' => 'Veículos', 'type' => 'expense', 'spent' => '', 'created_at' => Carbon::now()]);
        DB::table('categories')->insert(['name' => 'Gastos Pessoais', 'type' => 'expense', 'spent' => '', 'created_at' => Carbon::now()]);
        DB::table('categories')->insert(['name' => 'Contas', 'type' => 'expense', 'spent' => '', 'created_at' => Carbon::now()]);
    }
}
