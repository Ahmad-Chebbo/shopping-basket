<?php

namespace App\Http\Controllers\Manage;

use App\Charts\RemovedItemsChart;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\BasketItem;
use ConsoleTVs\Charts\Commands\ChartsCommand;

class ManageController extends BaseController
{
    public function dashboard()
    {
        // Get the top 10 removed items by total
        $removedItems = BasketItem::where('removed', true)
        ->with('product:id,name,price,image')
        ->groupBy('product_id')
        ->selectRaw('product_id, SUM(basket_items.quantity) as quantity, MAX(basket_items.price) as price, COUNT(*) as total_removed')
        ->orderByDesc('total_removed')
        ->take(10)
        ->get();

        // Prepare the data for the pie chart
        $labels = $removedItems->pluck('product.name');
        $data = $removedItems->pluck('total_removed');

        // Create the chart data
        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                        '#00FF99',
                        '#FF99FF',
                        '#CCFF33',
                        '#6699FF',
                    ],
                    'hoverBackgroundColor' => [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                        '#00FF99',
                        '#FF99FF',
                        '#CCFF33',
                        '#6699FF',
                    ],
                ],
            ],
        ];
        // Create the chart options
        $chartOptions = [
            'responsive' => true,
            'plugins' => [
                'display' => true,
                'title' => 'Top 10 Removed Items'
            ]
        ];

        return view('manage.pages.dashboard', compact('chartData', 'chartOptions'));
    }
}
