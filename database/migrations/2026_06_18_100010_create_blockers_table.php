<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Impediments: polymorphic over Task / PBI / Sprint, with a raised->resolved lifecycle. See ADR-0007.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blockers', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulidMorphs('blockable');                       // blockable_id (CHAR 26) + blockable_type
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('raised_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('resolved_at')->nullable();          // null = still open
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blockers');
    }
};
