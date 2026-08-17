<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('auction_id')->constrained('auctions')->cascadeOnDelete();
            $table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();

            $table->decimal('amount', 12, 2);
            $table->decimal('platform_fee', 12, 2)->default(0);
            $table->decimal('seller_amount', 12, 2)->default(0);

            // Payment proof
            $table->enum('payment_method',['jazzcash','easypaisa'])->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('proof_image')->nullable();

            $table->enum('status',[
                'pending', 'submitted', 'held', 'shipped', 'received', 'released',
                'refunded', 'disputed'])->default('pending');

            // Shipping info
            $table->string('courier_name')->nullable();
            $table->string('tracking_number')->nullable();

            // Notes
            $table->text('buyer_note')->nullable();
            $table->text('seller_note')->nullable();
            $table->text('admin_note')->nullable();

            // Timestamps for each stage
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('released_at')->nullable();
            $table->timestamp('refunded_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};