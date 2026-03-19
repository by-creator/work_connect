<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['client', 'freelance'])->default('client')->after('name');
            $table->string('phone', 20)->nullable()->after('email');
            $table->string('location', 100)->nullable()->after('phone');
            $table->text('bio')->nullable()->after('location');
            $table->json('skills')->nullable()->after('bio');
            $table->string('profile_photo')->nullable()->after('skills');
            $table->boolean('is_verified')->default(false)->after('profile_photo');
            $table->decimal('rating', 3, 2)->default(0)->after('is_verified');
            $table->integer('completed_missions')->default(0)->after('rating');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'location', 'bio', 'skills', 'profile_photo', 'is_verified', 'rating', 'completed_missions']);
        });
    }
};
