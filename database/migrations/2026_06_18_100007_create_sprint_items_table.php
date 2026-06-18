<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Sprint Backlog: pivot committing one PBI into one sprint, with sprint-local fields. See ADR-0005.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sprint_items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('sprint_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('product_backlog_item_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('status_id')->nullable()->constrained('statuses')->nullOnDelete();
            $table->decimal('committed_points', 5, 1)->nullable();
            $table->unsignedInteger('position')->default(0);                  // rank within the sprint
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['sprint_id', 'product_backlog_item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sprint_items');
    }
};
