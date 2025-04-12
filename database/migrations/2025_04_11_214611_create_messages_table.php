<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Skip this migration if the messages table already exists
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
            // Check if the columns already exist
            $hasColumns = true;
            $columns = ['sender_id', 'receiver_id', 'message', 'is_read'];
            
            foreach ($columns as $column) {
                if (!Schema::hasColumn('messages', $column)) {
                    $hasColumns = false;
                    break;
                }
            }
            
            // If the columns don't exist, we'll just log a message instead of trying to alter the table
            if (!$hasColumns) {
                DB::statement('ALTER TABLE messages ADD COLUMN IF NOT EXISTS message TEXT');
                DB::statement('ALTER TABLE messages ADD COLUMN IF NOT EXISTS is_read BOOLEAN DEFAULT FALSE');
                
                // Note: We're not adding the foreign key constraints to avoid issues with existing data
                // If you need to add these constraints, you should first ensure all data is valid
                // or truncate the table if it's safe to do so
                
                // Log a message to indicate manual intervention might be needed
                Log::info('The messages table structure needs to be manually reviewed for chat functionality.');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop the table in down method to prevent accidental deletion
        // Schema::dropIfExists('messages');
    }
};
