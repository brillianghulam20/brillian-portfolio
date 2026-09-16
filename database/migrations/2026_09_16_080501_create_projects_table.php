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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_category_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('eyebrow')->nullable();
            $table->text('short_description');
            $table->text('problem');
            $table->text('objective')->nullable();
            $table->text('solution');
            $table->text('role')->nullable();
            $table->text('business_process')->nullable();
            $table->text('architecture')->nullable();
            $table->text('challenges')->nullable();
            $table->text('result')->nullable();
            $table->text('lessons_learned')->nullable();
            $table->json('features')->nullable();
            $table->json('technologies')->nullable();
            $table->json('gallery')->nullable();
            $table->string('project_status')->default('Concept');
            $table->string('platform')->nullable();
            $table->string('database')->nullable();
            $table->unsignedSmallInteger('project_year')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->string('architecture_path')->nullable();
            $table->string('publishing_status')->default('draft')->index();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('seo_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
