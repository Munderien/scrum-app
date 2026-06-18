<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Unified, project-scoped workflow states for tasks/PBIs/sprints. See ADR-0008.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->enum('category', ['task', 'pbi', 'sprint']);
            $table->string('name');
            $table->string('color')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->foreignUlid('project_id')->nullable()     // null = global default status
                ->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->index(['category', 'project_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
