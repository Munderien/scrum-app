<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Work to deliver a sprint item. Self-referencing parent_id gives subtasks. See ADR-0006.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('sprint_item_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('parent_id')->nullable()           // subtask -> parent task
                ->constrained('tasks')->cascadeOnDelete();
            $table->foreignUlid('status_id')->nullable()->constrained('statuses')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('estimate_hours', 5, 2)->nullable();
            $table->foreignId('created_by')->nullable()            // reporter
                ->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('sprint_item_id');
            $table->index('parent_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
