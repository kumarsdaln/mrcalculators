<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\CalculatorHistory;

class CalculatorController extends Controller
{
    public function monthlySalesGoal(Request $request)
    {
        $request->validate([
            'yearly_sale' => 'required|numeric'
        ]);

        $yearly_sale = $request->input('yearly_sale');
        $monthly_sale = $yearly_sale / 12;
        $monthly_sale_fmt = number_format($monthly_sale, 2, '.', '');

        if (Auth::check()) {
            CalculatorHistory::create([
                'user_id' => Auth::id(),
                'calculator_type' => 'monthly_sales_goal',
                'input_data' => ['yearly_sale' => $yearly_sale],
                'result_data' => ['monthly_sale' => $monthly_sale_fmt]
            ]);
        }

        return response()->json([
            'status' => 'success',
            'monthly_sale' => $monthly_sale_fmt
        ]);
    }

    public function breakEvenPrice(Request $request)
    {
        $request->validate([
            'month' => 'required|array',
            'unit' => 'required|array',
            'tpt' => 'required|numeric'
        ]);

        $months = $request->input('month');
        $units = $request->input('unit');
        
        $n = count($months);
        $sum_x = 0;
        $sum_y = 0;
        $sum_square_x = 0;
        $sum_square_y = 0;
        $sum_xy = 0;

        for ($i = 0; $i < $n; $i++) {
            $x = $i + 1;
            $monthVal = $months[$i];
            $unitVal = $units[$i];

            if ($unitVal == 0) {
                return response()->json(['status' => 'error', 'error' => "Unit can't be zero"]);
            }

            $y = $monthVal / $unitVal;

            $square_x = $x * $x;
            $square_y = $y * $y;
            $xy = $x * $y;

            $sum_x += $x;
            $sum_y += $y;
            $sum_xy += $xy;
            $sum_square_x += $square_x;
            $sum_square_y += $square_y;
        }
        
        $denominator = ($n * $sum_square_x) - ($sum_x * $sum_x);
        if ($denominator == 0) {
            return response()->json(['status' => 'error', 'error' => 'Division by zero in linear regression']);
        }

        $m = (($n * $sum_xy) - ($sum_x * $sum_y)) / $denominator;
        $b = ($sum_y - ($m * $sum_x)) / $n;
        
        $next_x = $n + 1;
        $y_pred = ($m * $next_x) + $b;

        $r_denom = sqrt(($n * $sum_square_x) - ($sum_x * $sum_x)) * sqrt(($n * $sum_square_y) - ($sum_y * $sum_y));
        $r = $r_denom != 0 ? (($n * $sum_xy) - ($sum_x * $sum_y)) / $r_denom : 0;

        $tpt = $request->input('tpt');
        $tpt_mul = $tpt / 100;
        $s = $y_pred * (1 + $tpt_mul);

        $break_even_fmt = number_format($y_pred, 2, '.', '');
        $target_fmt = number_format($s, 2, '.', '');

        if (Auth::check()) {
            CalculatorHistory::create([
                'user_id' => Auth::id(),
                'calculator_type' => 'break_even_price',
                'input_data' => ['month' => $months, 'unit' => $units, 'tpt' => $tpt],
                'result_data' => [
                    'break_even_price' => $break_even_fmt,
                    'monthly_sales_target' => $target_fmt,
                    'correlation_coefficient' => $r
                ]
            ]);
        }

        return response()->json([
            'status' => 'success',
            'break_even_price' => $break_even_fmt,
            'monthly_sales_target' => $target_fmt,
            'correlation_coefficient' => $r
        ]);
    }

    public function futureSalesForecast(Request $request)
    {
        $request->validate([
            'month' => 'required|array'
        ]);

        $months = $request->input('month');
        $n = count($months);
        $sum_x = 0;
        $sum_y = 0;
        $sum_square_x = 0;
        $sum_square_y = 0;
        $sum_xy = 0;

        for ($i = 0; $i < $n; $i++) {
            $x = $i + 1;
            $y = $months[$i];

            $square_x = $x * $x;
            $square_y = $y * $y;
            $xy = $x * $y;

            $sum_x += $x;
            $sum_y += $y;
            $sum_xy += $xy;
            $sum_square_x += $square_x;
            $sum_square_y += $square_y;
        }

        $denominator = ($n * $sum_square_x) - ($sum_x * $sum_x);
        if ($denominator == 0) {
            return response()->json(['status' => 'error', 'error' => 'Division by zero in linear regression']);
        }

        $m = (($n * $sum_xy) - ($sum_x * $sum_y)) / $denominator;
        $b = ($sum_y - ($m * $sum_x)) / $n;

        $next_x = $n + 1;
        $y_pred = ($m * $next_x) + $b;

        $r_denom = sqrt(($n * $sum_square_x) - ($sum_x * $sum_x)) * sqrt(($n * $sum_square_y) - ($sum_y * $sum_y));
        $r = $r_denom != 0 ? (($n * $sum_xy) - ($sum_x * $sum_y)) / $r_denom : 0;

        $forecast_fmt = number_format($y_pred, 2, '.', '');

        if (Auth::check()) {
            CalculatorHistory::create([
                'user_id' => Auth::id(),
                'calculator_type' => 'future_sales_forecast',
                'input_data' => ['month' => $months],
                'result_data' => [
                    'forecast_future_sales' => $forecast_fmt,
                    'correlation_coefficient' => $r
                ]
            ]);
        }

        return response()->json([
            'status' => 'success',
            'forecast_future_sales' => $forecast_fmt,
            'correlation_coefficient' => $r
        ]);
    }

    public function ltvCacRatio(Request $request)
    {
        $request->validate([
            'marketing_spend' => 'required|numeric',
            'new_customers' => 'required|numeric',
            'avg_revenue' => 'required|numeric',
            'customer_lifetime' => 'required|numeric',
        ]);

        $marketing_spend = $request->input('marketing_spend');
        $new_customers = $request->input('new_customers');
        $avg_revenue = $request->input('avg_revenue');
        $customer_lifetime = $request->input('customer_lifetime');

        if ($new_customers == 0) {
            return response()->json(['status' => 'error', 'error' => "New customers acquired cannot be zero"]);
        }

        // Calculate CAC (Customer Acquisition Cost)
        $cac = $marketing_spend / $new_customers;
        
        // Calculate LTV (Customer Lifetime Value)
        $ltv = $avg_revenue * $customer_lifetime;

        // Calculate Ratio
        if ($cac == 0) {
            $ratio = $ltv > 0 ? "Infinity" : 0;
            $ratio_numeric = 999;
        } else {
            $ratio_numeric = $ltv / $cac;
            $ratio = number_format($ratio_numeric, 2, '.', '');
        }

        $cac_fmt = number_format($cac, 2, '.', '');
        $ltv_fmt = number_format($ltv, 2, '.', '');

        if (Auth::check()) {
            CalculatorHistory::create([
                'user_id' => Auth::id(),
                'calculator_type' => 'ltv_cac_ratio',
                'input_data' => [
                    'marketing_spend' => $marketing_spend,
                    'new_customers' => $new_customers,
                    'avg_revenue' => $avg_revenue,
                    'customer_lifetime' => $customer_lifetime
                ],
                'result_data' => [
                    'cac' => $cac_fmt,
                    'ltv' => $ltv_fmt,
                    'ratio' => $ratio
                ]
            ]);
        }

        return response()->json([
            'status' => 'success',
            'cac' => $cac_fmt,
            'ltv' => $ltv_fmt,
            'ratio' => $ratio
        ]);
    }
}
