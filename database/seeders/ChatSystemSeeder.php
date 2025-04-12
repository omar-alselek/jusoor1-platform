<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\Friendship;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ChatSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users if they don't exist
        $user1 = User::firstOrCreate(
            ['email' => 'test1@example.com'],
            [
                'name' => 'Test User 1',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $user2 = User::firstOrCreate(
            ['email' => 'test2@example.com'],
            [
                'name' => 'Test User 2',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create friendship between users
        Friendship::firstOrCreate(
            [
                'sender_id' => $user1->id,
                'receiver_id' => $user2->id,
            ],
            [
                'status' => 'accepted',
            ]
        );

        // Create conversations between users
        $conversation1 = Conversation::updateOrCreate(
            [
                'user_id' => $user1->id,
                'other_user_id' => $user2->id,
            ],
            [
                'last_message_at' => now(),
            ]
        );

        $conversation2 = Conversation::updateOrCreate(
            [
                'user_id' => $user2->id,
                'other_user_id' => $user1->id,
            ],
            [
                'last_message_at' => now(),
            ]
        );

        // Create some test messages
        $messages = [
            [
                'sender_id' => $user1->id,
                'receiver_id' => $user2->id,
                'message' => 'Hello! How are you?',
                'is_read' => true,
                'created_at' => Carbon::now()->subHours(2),
            ],
            [
                'sender_id' => $user2->id,
                'receiver_id' => $user1->id,
                'message' => 'I\'m good, thanks! How about you?',
                'is_read' => true,
                'created_at' => Carbon::now()->subHours(1)->subMinutes(45),
            ],
            [
                'sender_id' => $user1->id,
                'receiver_id' => $user2->id,
                'message' => 'Doing well! Just testing this new chat system.',
                'is_read' => true,
                'created_at' => Carbon::now()->subHours(1)->subMinutes(30),
            ],
            [
                'sender_id' => $user2->id,
                'receiver_id' => $user1->id,
                'message' => 'It looks great! Very responsive.',
                'is_read' => true,
                'created_at' => Carbon::now()->subHours(1),
            ],
            [
                'sender_id' => $user1->id,
                'receiver_id' => $user2->id,
                'message' => 'Thanks! I\'ve been working hard on it.',
                'is_read' => true,
                'created_at' => Carbon::now()->subMinutes(45),
            ],
            [
                'sender_id' => $user2->id,
                'receiver_id' => $user1->id,
                'message' => 'It shows! The real-time updates are impressive.',
                'is_read' => false,
                'created_at' => Carbon::now()->subMinutes(30),
            ],
            [
                'sender_id' => $user2->id,
                'receiver_id' => $user1->id,
                'message' => 'This message should appear as unread.',
                'is_read' => false,
                'created_at' => Carbon::now()->subMinutes(15),
            ],
        ];

        // Insert messages
        foreach ($messages as $message) {
            Message::updateOrCreate(
                [
                    'sender_id' => $message['sender_id'],
                    'receiver_id' => $message['receiver_id'],
                    'message' => $message['message'],
                    'created_at' => $message['created_at'],
                ],
                [
                    'is_read' => $message['is_read'],
                ]
            );
        }

        $this->command->info('Chat system test data created successfully!');
    }
}
