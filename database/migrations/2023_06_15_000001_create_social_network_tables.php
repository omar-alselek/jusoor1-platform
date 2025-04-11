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
        // Create a simple post table for social features without project_id foreign key
        Schema::create('social_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->json('images')->nullable();
            $table->string('privacy')->default('public'); // public, friends
            $table->timestamps();
        });
        
        // Comments table
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->references('id')->on('social_posts')->onDelete('cascade');
            $table->text('content');
            $table->timestamps();
        });
        
        // Likes table
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->references('id')->on('social_posts')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['user_id', 'post_id']);
        });
        
        // Friendships table
        Schema::create('friendships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('pending'); // pending, accepted, rejected
            $table->timestamps();
            
            $table->unique(['sender_id', 'receiver_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friendships');
        Schema::dropIfExists('likes');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('social_posts');
    }
}; 