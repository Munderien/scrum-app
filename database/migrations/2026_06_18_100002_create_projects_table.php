<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Top-level container: owns one product backlog, many sprints, and a team. See glossary + ADR-0010.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('key')->nullable();              // short code, e.g. "SCR"
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()     // users uses BigInt id (ADR-0003)
                ->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
