<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('calculator_tools', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('icon')->default('Calculator');
            $table->string('route')->nullable();
            $table->string('category')->nullable();
            $table->string('tag')->nullable();
            $table->string('badge')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_recommended')->default(false);
            $table->boolean('is_coming_soon')->default(false);
            $table->boolean('requires_subscription')->default(true);
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('show_on_dashboard')->default(true);
            $table->boolean('show_on_homepage')->default(true);
            $table->json('content')->nullable();
            $table->timestamps();
        });

        Schema::create('calculator_tool_plan', function (Blueprint $table) {
            $table->foreignId('calculator_tool_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['calculator_tool_id', 'plan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculator_tool_plan');
        Schema::dropIfExists('calculator_tools');
    }
};
