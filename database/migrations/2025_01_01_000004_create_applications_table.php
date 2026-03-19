<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mission_id')->constrained('missions')->onDelete('cascade');
            $table->foreignId('freelance_id')->constrained('users')->onDelete('cascade');
            $table->text('cover_letter');
            $table->decimal('proposed_price', 12, 2);
            $table->integer('estimated_days')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();

            $table->unique(['mission_id', 'freelance_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
