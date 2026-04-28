<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable()->unique()->after('id');
            }
            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('player')->after('password');
            }
            if (! Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active')->after('role');
            }
            if (! Schema::hasColumn('users', 'preferred_games')) {
                $table->string('preferred_games')->nullable()->after('status');
            }
            if (! Schema::hasColumn('users', 'trading_preferences')) {
                $table->text('trading_preferences')->nullable()->after('preferred_games');
            }
            if (! Schema::hasColumn('users', 'suspended_until')) {
                $table->timestamp('suspended_until')->nullable()->after('trading_preferences');
            }
        });

        Schema::create('trade_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('type');
            $table->string('game_category');
            $table->string('rarity')->default('common');
            $table->string('availability_status')->default('available');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('trade_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('trade_items')->cascadeOnDelete();
            $table->foreignId('requester_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->string('status')->default('pending');
            $table->boolean('requester_confirmed')->default(false);
            $table->boolean('owner_confirmed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });

        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trade_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rater_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('rated_user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('score');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->unique(['trade_request_id', 'rater_id']);
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reported_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('trade_item_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reason');
            $table->text('details')->nullable();
            $table->string('status')->default('open');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('app_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('body');
            $table->string('link')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_notifications');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('trade_requests');
        Schema::dropIfExists('trade_items');
    }
};
