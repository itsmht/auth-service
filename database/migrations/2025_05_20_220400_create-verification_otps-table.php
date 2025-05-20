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
        Schema::create('verification_otps', function (Blueprint $table) {
            $table->bigIncrements('verification_otp_id');
            $table->string('otp');
            $table->string('email');
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
