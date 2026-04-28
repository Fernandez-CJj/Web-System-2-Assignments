<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trade_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trade_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('body');
            $table->timestamps();
        });

        DB::table('trade_requests')
            ->whereNotNull('message')
            ->where('message', '<>', '')
            ->orderBy('id')
            ->each(function ($trade): void {
                DB::table('trade_messages')->insert([
                    'trade_request_id' => $trade->id,
                    'user_id' => $trade->requester_id,
                    'body' => $trade->message,
                    'created_at' => $trade->created_at,
                    'updated_at' => $trade->updated_at,
                ]);
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('trade_messages');
    }
};
