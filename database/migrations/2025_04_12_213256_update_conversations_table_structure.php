<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('conversations')) {
            Schema::table('conversations', function (Blueprint $table) {
                // Add columns if they don't exist
                if (!Schema::hasColumn('conversations', 'user_id')) {
                    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                }
                
                if (!Schema::hasColumn('conversations', 'other_user_id')) {
                    $table->foreignId('other_user_id')->constrained('users')->onDelete('cascade');
                }
                
                if (!Schema::hasColumn('conversations', 'last_message_at')) {
                    $table->timestamp('last_message_at')->nullable();
                }
                
                // Add unique constraint if it doesn't exist
                try {
                    $sm = Schema::getConnection()->getDoctrineSchemaManager();
                    $indexesFound = $sm->listTableIndexes('conversations');
                    
                    if (!array_key_exists('conversations_user_id_other_user_id_unique', $indexesFound)) {
                        $table->unique(['user_id', 'other_user_id'], 'conversations_user_id_other_user_id_unique');
                    }
                } catch (\Exception $e) {
                    // Log the error but continue
                    Log::error('Could not add unique constraint to conversations table: ' . $e->getMessage());
                }
            });
        } else {
            Schema::create('conversations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('other_user_id')->constrained('users')->onDelete('cascade');
                $table->timestamp('last_message_at')->nullable();
                $table->timestamps();
                
                // Add unique constraint to prevent duplicate conversations
                $table->unique(['user_id', 'other_user_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop the table in down method to prevent accidental deletion
    }
};
