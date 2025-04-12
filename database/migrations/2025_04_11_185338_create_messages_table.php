<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('messages')) {
            Schema::create('messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
                $table->text('message');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        } else {
            // Add columns if they don't exist
            Schema::table('messages', function (Blueprint $table) {
                if (!Schema::hasColumn('messages', 'sender_id')) {
                    $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
                }
                
                if (!Schema::hasColumn('messages', 'receiver_id')) {
                    $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
                }
                
                if (!Schema::hasColumn('messages', 'message')) {
                    $table->text('message');
                }
                
                if (!Schema::hasColumn('messages', 'is_read')) {
                    $table->boolean('is_read')->default(false);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
