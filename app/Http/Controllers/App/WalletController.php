<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet as WalletRequest;
use App\Models\App\Wallet;
use Illuminate\Http\JsonResponse;

/**
 * Class WalletController
 * @package App\Http\Controllers\App
 */
class WalletController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param WalletRequest $request
     * @return JsonResponse
     */
    public function store(WalletRequest $request): JsonResponse
    {
        Wallet::create([
            'wallet' => $request->get('wallet'),
            'user_id' => user()->id,
            'free' => !user()->hasWallet()
        ]);

        $this->flashMessage('success', 'Carteira criada com sucesso');

        return response()->json(['reload' => true]);
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

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Wallet $wallet
     * @return JsonResponse
     */
    public function destroy(Wallet $wallet): JsonResponse
    {
        if($wallet->userWallets() == 1) {
            return \response()
                ->json(['errors' => ['wallet' => ['Não é possível remover sua única carteira']]])
                ->setStatusCode(412);
        }

        $wallet->delete();

        session()->flash('message', [
            'type' => 'success',
            'message' => 'Carteira removida com sucesso'
        ]);

        return response()->json(['reload' => true]);
    }
}
