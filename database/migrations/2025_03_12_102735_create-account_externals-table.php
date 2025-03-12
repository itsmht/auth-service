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
        Schema::create('account_externals', function (Blueprint $table) {
            $table->bigIncrements('account_external_id');
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('account_id')->on('accounts');
            $table->string('provider_name');
            $table->string('provider_id');
            $table->string('provider_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
