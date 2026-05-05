<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();

            // Ownership
            $table->foreignId('seller_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Winner: set when auction end
            $table->foreignId('winner_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Basic Info
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();

            $table->enum('category',[
                'art','watches','vehicles',
                'jewelry','collectibles','electronics','other']);

            $table->enum('condition',[
                'new','like_new','excellent','good','fair']);

            $table->decimal('starting_bid', 12, 2);
            $table->decimal('current_bid',  12, 2)->nullable()->default(null);
 
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();

            $table->unsignedTinyInteger('snipe_extension_count')->default(0);

            $table->enum('status', ['draft','active','closed','cancelled'])->default('draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
