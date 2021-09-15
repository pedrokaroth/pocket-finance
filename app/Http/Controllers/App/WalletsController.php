<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet as WalletRequest;
use App\Models\App\Wallet;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use MongoDB\Driver\Session;

/**
 * Class WalletController
 * @package App\Http\Controllers\App
 */
class WalletsController extends Controller
{

    /**
     *  Show the application wallets.
     *
     * @return View
     */
    public function index(): View
    {
        return view('app.wallets', [
            'wallets' => user()->wallets()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WalletRequest $request
     * @return JsonResponse
     */
    public function store(WalletRequest $request): JsonResponse
    {
        Wallet::create($request->validated());

        return $this->jsonReload('Carteira criada com sucesso');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param WalletRequest $request
     * @param Wallet $wallet
     * @return JsonResponse
     */
    public function update(WalletRequest $request, Wallet $wallet): JsonResponse
    {
        $wallet->update([
            'wallet' => $request->get('wallet')
        ]);

        return $this->jsonSuccess('Cateira renomeada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Wallet $wallet
     * @return JsonResponse
     */
    public function destroy(Wallet $wallet): JsonResponse
    {
        if(!$wallet->delete()) {
            $this->jsonError('Não foi possível remover a carteira');
        }

        return $this->jsonReload('Carteira removida com sucesso');
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function walletFilter(int $id): JsonResponse
    {
        session()->put('walletfilter', $id);

        return $this->jsonReload();
    }
}
