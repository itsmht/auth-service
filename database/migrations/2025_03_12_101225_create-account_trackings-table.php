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
        Schema::create('account_trackings', function (Blueprint $table) {
            $table->bigIncrements('account_tracking_id');
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('account_id')->on('accounts');
            $table->string('ip_address');
            $table->string('deviceID');
            $table->string('device_name')->nullable();
            $table->string('status')->default('A')->comment('A=Active, B=Blocked, D=Deleted');
            $table->timestamp('last_login')->nullable();
            $table->timestamp('last_logout')->nullable();
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
