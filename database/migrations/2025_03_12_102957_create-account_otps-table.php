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
        Schema::create('account_otps', function (Blueprint $table) {
            $table->bigIncrements('account_otp_id');
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('account_id')->on('accounts');
            $table->string('otp');
            $table->string('status')->default('N')->comment('N=New, V=Verified, E=Expired, U=Used');
            $table->string('purpose')->comment('V=Verification, R=Register, L=Login, P=Password Reset, T=Transaction', 'O=Others');
            $table->string('channel')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('expired_at')->nullable();
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
