<?php

namespace App\Support;

use App\Models\CalculatorTool;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class CalculatorCatalog
{
    /**
     * Get the catalog of gated product features.
     *
     * @return array<int, array<string, string>>
     */
    public static function all(): array
    {
        $tools = Schema::hasTable('calculator_tools')
            ? CalculatorTool::query()
                ->active()
                ->orderBy('display_order')
                ->orderBy('id')
                ->get()
            : collect();

        if ($tools->isNotEmpty()) {
            return $tools
                ->map(fn (CalculatorTool $tool) => [
                    'slug' => $tool->slug,
                    'name' => $tool->title,
                    'section' => 'calculator',
                    'route' => $tool->route,
                    'description' => $tool->short_description ?: $tool->description,
                ])
                ->push([
                    'slug' => 'audit_history',
                    'name' => 'Audit History',
                    'section' => 'workspace',
                    'route' => 'history',
                    'description' => 'Review and trace previous calculator runs and business assumptions.',
                ])
                ->values()
                ->all();
        }

        return [
            [
                'slug' => 'monthly_sales_goal',
                'name' => 'Monthly Quota Isolator',
                'section' => 'calculator',
                'route' => 'calculator.monthly-sales-goal',
                'description' => 'Break annual revenue goals into monthly execution targets.',
            ],
            [
                'slug' => 'break_even_price',
                'name' => 'Break-Even Matrix',
                'section' => 'calculator',
                'route' => 'calculator.break-even-and-selling-price',
                'description' => 'Find the exact break-even and target selling price for your business.',
            ],
            [
                'slug' => 'future_sales_forecast',
                'name' => 'Predictive Sales Forecaster',
                'section' => 'calculator',
                'route' => 'calculator.future-sales-forecast',
                'description' => 'Project forward sales using historical trends and linear regression.',
            ],
            [
                'slug' => 'what_if_engine',
                'name' => 'What-If Scenario Engine',
                'section' => 'calculator',
                'route' => 'calculator.what-if-engine',
                'description' => 'Model alternative pricing and cost scenarios before committing.',
            ],
            [
                'slug' => 'ltv_cac_ratio',
                'name' => 'LTV:CAC Health Engine',
                'section' => 'calculator',
                'route' => 'calculator.ltv-cac-ratio',
                'description' => 'Measure customer acquisition efficiency against customer value.',
            ],
            [
                'slug' => 'audit_history',
                'name' => 'Audit History',
                'section' => 'workspace',
                'route' => 'history',
                'description' => 'Review and trace previous calculator runs and business assumptions.',
            ],
        ];
    }

    /**
     * Get the feature slugs only.
     *
     * @return array<int, string>
     */
    public static function featureSlugs(): array
    {
        return array_column(static::all(), 'slug');
    }

    /**
     * Get the calculator content catalog for Inertia pages.
     *
     * @return array<string, mixed>
     */
    public static function calculatorContent(): array
    {
        $tools = Schema::hasTable('calculator_tools')
            ? CalculatorTool::query()
                ->active()
                ->orderBy('display_order')
                ->orderBy('id')
                ->get()
                ->map(fn (CalculatorTool $tool) => $tool->toCatalogArray())
                ->values()
                ->all()
            : static::fallbackCalculatorContent();

        return [
            'calculators' => $tools,
        ];
    }

    /**
     * Load the old static catalog only as a bootstrap/fallback path.
     *
     * @return array<int, array<string, mixed>>
     */
    private static function fallbackCalculatorContent(): array
    {
        $catalogPath = resource_path('js/data/calculators.json');

        if (! File::exists($catalogPath)) {
            return [];
        }

        $catalog = json_decode(File::get($catalogPath), true);

        return $catalog['calculators'] ?? [];
    }
}
