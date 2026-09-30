<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table){
            if(!Schema::hasColumn('users', 'payout_method')){
                $table->enum('payout_method',['jazzcash', 'easypaisa'])->nullable();
                $table->string('payout_account_number')->nullable();
                $table->string('payout_account_name')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users',function(Blueprint $table){
            $table->dropColumn(['payout_method', 'payout_account_number', 'payout_account_name']);
        });
    }
};