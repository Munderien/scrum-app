<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Product Backlog Items live at the project level. Estimation: ADR-0009. Ordering: ADR-0011.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_backlog_items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('project_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('status_id')->nullable()->constrained('statuses')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['story', 'bug', 'epic', 'spike'])->default('story');
            $table->decimal('story_points', 5, 1)->nullable();
            $table->unsignedInteger('position')->default(0);                    // manual rank
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['project_id', 'position']);
            $table->index(['project_id', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_backlog_items');
    }
};
