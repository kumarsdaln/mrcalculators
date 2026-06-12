<?php

namespace Database\Seeders;

use App\Models\CalculatorTool;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CalculatorToolSeeder extends Seeder
{
    /**
     * Seed calculator tools from the existing content snapshot.
     */
    public function run(): void
    {
        $catalogPath = resource_path('js/data/calculators.json');

        if (! File::exists($catalogPath)) {
            return;
        }

        $catalog = json_decode(File::get($catalogPath), true);

        foreach ($catalog['calculators'] ?? [] as $index => $tool) {
            $content = $tool;

            foreach ([
                'id',
                'slug',
                'title',
                'subtitle',
                'description',
                'short_description',
                'icon',
                'route',
                'category',
                'tag',
                'badge',
                'featured',
                'recommended',
                'coming_soon',
                'access',
                'display',
            ] as $key) {
                unset($content[$key]);
            }

            CalculatorTool::query()->updateOrCreate(
                ['slug' => $tool['slug']],
                [
                    'title' => $tool['title'],
                    'subtitle' => $tool['subtitle'] ?? null,
                    'description' => $tool['description'] ?? null,
                    'short_description' => $tool['short_description'] ?? null,
                    'icon' => $tool['icon'] ?? 'Calculator',
                    'route' => $tool['route'] ?? null,
                    'category' => $tool['category'] ?? null,
                    'tag' => $tool['tag'] ?? null,
                    'badge' => $tool['badge'] ?? null,
                    'is_active' => true,
                    'is_featured' => (bool) ($tool['featured'] ?? false),
                    'is_recommended' => (bool) ($tool['recommended'] ?? false),
                    'is_coming_soon' => (bool) ($tool['coming_soon'] ?? false),
                    'requires_subscription' => (bool) ($tool['access']['plan_required'] ?? true),
                    'display_order' => (int) ($tool['display']['order'] ?? $index + 1),
                    'show_on_dashboard' => (bool) ($tool['display']['show_on_dashboard'] ?? true),
                    'show_on_homepage' => (bool) ($tool['display']['show_on_homepage'] ?? true),
                    'content' => $content,
                ],
            );
        }
    }
}
