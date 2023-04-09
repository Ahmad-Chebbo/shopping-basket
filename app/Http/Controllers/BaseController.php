<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{
     /**
     * @var Request
     */
    protected Request $request;

    /**
     * ApiBaseController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param bool $success
     * @param string $message
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    protected function returnJsonResponse(bool $success = true, string $message = '', mixed $data = null, int $status = 200): JsonResponse
    {
        return response()->json([
            'success'   => $success,
            'message'   => $message,
            'data'      => $data,
            'status' => $status,
        ], $status);
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    protected function responseJsonError(string $message = '', mixed $data = null, int $status = 500): JsonResponse
    {
        return $this->returnJsonResponse(false, $message, $data, $status);
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    protected function responseJsonSuccess(string $message = '', mixed $data = null, int $status = 200): JsonResponse
    {
        return $this->returnJsonResponse(true, $message, $data, $status);
    }

    /**
     * @param array $message
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    protected function responseJsonErrorValidation(array $message = [], mixed $data = null, int $status = 422): JsonResponse
    {
        return response()->json([
            'success'   => false,
            'message'   => $message,
            'data'      => $data,
            'status' => $status,
        ], $status);
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    protected function responseJsonErrorNotFound(string $message = '', array $data = [], int $status = 404): JsonResponse
    {
        return $this->returnJsonResponse(false, $message, $data, $status);
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    protected function responseJsonSuccessNotFound(string $message = '', array $data = [], int $status = 200): JsonResponse
    {
        return $this->returnJsonResponse(true, $message, $data, $status);
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    protected function responseJsonErrorInternalServerError(string $message = '', array $data = [], int $status = 500): JsonResponse
    {
        return $this->returnJsonResponse(false, $message, $data, $status);
    }

    /**
     * Return redirect back with notification
     * @param $message
     * @param string $type
     * @return RedirectResponse
     */
    public function returnRedirectBack($message, string $type): RedirectResponse
    {
        // toastr()->$type($message);
        return redirect()->back();
    }

    /**
     * Return redirect with notification
     * @param $message
     * @param string $type
     * @param $route
     * @return RedirectResponse
     */
    public function returnRedirect($route, $message, string $type = 'success'): RedirectResponse
    {
        // toastr()->$type($message);
        return redirect()->route($route);
    }

}
