<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('auto_bids', function (Blueprint $table) {
         $table->id();
            $table->foreignId('auction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bidder_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('max_amount');
            $table->timestamps();

            // One active limit per user per auction
            $table->unique(['auction_id', 'bidder_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auto_bids');
    }
};
