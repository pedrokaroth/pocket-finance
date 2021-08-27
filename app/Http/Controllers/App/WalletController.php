<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet as WalletRequest;
use App\Models\App\Wallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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

        return response()
            ->json([
                'reload' => true
            ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Wallet $wallet
     * @return JsonResponse
     */
    public function destroy(Wallet $wallet)
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

        return \response()
            ->json([
                'reload' => true
            ]);
    }
}
