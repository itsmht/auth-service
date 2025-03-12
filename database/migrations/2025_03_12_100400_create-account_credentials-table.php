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
        Schema::create('account_credentials', function (Blueprint $table) {
            $table->bigIncrements('account_credential_id');
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('account_id')->on('accounts');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('previous_password')->nullable();
            $table->integer('wrong_password_attempts')->default(0);
            $table->timestamp('last_password_reset')->nullable();
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
