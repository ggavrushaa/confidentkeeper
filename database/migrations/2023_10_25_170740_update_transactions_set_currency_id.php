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
        DB::table('transactions')->whereNull('currency_id')->update(['currency_id' => 1001]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
