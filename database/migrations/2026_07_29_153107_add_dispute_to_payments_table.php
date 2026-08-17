<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments',function(Blueprint $table){
            if(!Schema::hasColumn('payments','buyer_statement')){
                $table->text('buyer_statement')->nullable()->after('dispute_raised_at');
                $table->string('buyer_statement_evidence')->nullable()->after('buyer_statement');
                $table->timestamp('buyer_statement_at')->nullable()->after('buyer_statement_evidence');
            }
            if(!Schema::hasColumn('payments', 'seller_statement')){
                $table->text('seller_statement')->nullable()->after('buyer_statement_at');
                $table->string('seller_statement_evidence')->nullable()->after('seller_statement');
                $table->timestamp('seller_statement_at')->nullable()->after('seller_statement_evidence');
            }
        });
        
        Schema::table('payments',function(Blueprint $table){
            foreach(['dispute_response','dispute_response_evidence','dispute_responded_at'] as $col){
                if(Schema::hasColumn('payments',$col)){
                    $table->dropColumn($col);
                }
            }
        });

        if (Schema::hasColumn('payments','dispute_reason')){
            Schema::table('payments', function (Blueprint $table){
                $table->dropColumn(['dispute_reason', 'dispute_evidence']);
            });
        }
    }

    public function down(): void
    {
        Schema::table('payments', function(Blueprint $table){
            $table->dropColumn([
                'buyer_statement', 'buyer_statement_evidence', 'buyer_statement_at',
                'seller_statement', 'seller_statement_evidence', 'seller_statement_at',
            ]);
        });
    }
};