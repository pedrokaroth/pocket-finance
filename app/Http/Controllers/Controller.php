<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param string $type
     * @param string $message
     * @return Void
     */
    public function message(string $type, string $message): Void
    {
        session()->flash('message', [
            'type' => $type,
            'message' => $message
        ]);
    }

    /**
     * @param string|null $flashMessage
     * @param string|null $flashType
     * @return JsonResponse
     */
    public function jsonReload(string $flashMessage = null, ?string $flashType = 'success'): JsonResponse
    {
        if($flashMessage) {
            $this->message($flashType, $flashMessage);
        }

        return response()
            ->json(['reload' => true]);
    }

    /**
     * @param string|null $message
     * @return JsonResponse
     */
    public function jsonSuccess(string $message = null): JsonResponse
    {
        return response()
            ->json(['success' => $message]);
    }

    /**
     * @param string $message
     * @return JsonResponse|object
     */
    public function jsonError(string $message)
    {
        return response()
            ->json(['errors' => [ 'error' => $message ]])
            ->setStatusCode(412);
    }
}
