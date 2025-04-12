<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, check if the messages table exists
        if (Schema::hasTable('messages')) {
            // Get the current columns in the messages table
            $columns = Schema::getColumnListing('messages');
            
            // Check if we need to add the sender_id column
            if (!in_array('sender_id', $columns)) {
                Schema::table('messages', function (Blueprint $table) {
                    $table->unsignedBigInteger('sender_id')->after('id');
                });
            }
            
            // Check if we need to add the receiver_id column
            if (!in_array('receiver_id', $columns)) {
                Schema::table('messages', function (Blueprint $table) {
                    $table->unsignedBigInteger('receiver_id')->after('sender_id');
                });
            }
            
            // Check if we need to add the message column
            if (!in_array('message', $columns)) {
                Schema::table('messages', function (Blueprint $table) {
                    $table->text('message')->after('receiver_id')->nullable();
                });
            }
            
            // Check if we need to add the is_read column
            if (!in_array('is_read', $columns)) {
                Schema::table('messages', function (Blueprint $table) {
                    $table->boolean('is_read')->default(false)->after('message');
                });
            }
            
            // Add foreign key constraints if they don't exist
            // We'll do this in a separate try-catch block to handle potential errors
            try {
                // Check if the foreign keys already exist
                $foreignKeys = DB::select("
                    SELECT CONSTRAINT_NAME
                    FROM information_schema.TABLE_CONSTRAINTS
                    WHERE TABLE_NAME = 'messages'
                    AND CONSTRAINT_TYPE = 'FOREIGN KEY'
                ");
                
                $foreignKeyNames = array_map(function($key) {
                    return $key->CONSTRAINT_NAME;
                }, $foreignKeys);
                
                // Add sender_id foreign key if it doesn't exist
                if (!in_array('messages_sender_id_foreign', $foreignKeyNames)) {
                    Schema::table('messages', function (Blueprint $table) {
                        $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
                    });
                }
                
                // Add receiver_id foreign key if it doesn't exist
                if (!in_array('messages_receiver_id_foreign', $foreignKeyNames)) {
                    Schema::table('messages', function (Blueprint $table) {
                        $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
                    });
                }
            } catch (\Exception $e) {
                // Log the error but continue with the migration
                \Illuminate\Support\Facades\Log::error('Error adding foreign keys to messages table: ' . $e->getMessage());
            }
        } else {
            // If the messages table doesn't exist, create it
            Schema::create('messages', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('sender_id');
                $table->unsignedBigInteger('receiver_id');
                $table->text('message')->nullable();
                $table->boolean('is_read')->default(false);
                $table->timestamps();
                
                $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't want to reverse these changes as they're critical for the chat system
    }
};
