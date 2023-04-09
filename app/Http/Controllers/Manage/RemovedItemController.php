<?php

namespace App\Http\Controllers\Manage;

use Exception;
use Carbon\Factory;
use App\Models\BasketItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Console\Application;
use App\Http\Controllers\BaseController;
use Yajra\DataTables\Facades\DataTables;

class RemovedItemController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View|Factory|JsonResponse|Application
    {
        if ($request->ajax()) {
            $removedItems = BasketItem::where('removed', true)
            ->with('product:id,name,price,image')
            ->groupBy('product_id')
            ->selectRaw('product_id, SUM(basket_items.quantity) as quantity, MAX(basket_items.price) as price, COUNT(*) as total_removed');

            return DataTables::of($removedItems)->make(true);
        }
        return view('manage.pages.removedItems.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $product_id
     * @return JsonResponse
     */
    public function destroy($product_id)
    {
        try {

            BasketItem::where([
                ['product_id', $product_id],
                ['removed', true],
            ])->delete();

            return $this->returnJsonResponse(true, __('Record Removed Successfully'));
        }
        catch (Exception $e) {
            return $this->returnJsonResponse(false, __('An error has occured, please try again later'), $e->getMessage());
        }
    }
}
