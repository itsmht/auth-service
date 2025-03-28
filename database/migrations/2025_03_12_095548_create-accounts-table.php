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
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('account_id');
            $table->string('name');
            $table->string('oneID')->unique();
            $table->string('role');
            $table->string('gender')->nullable();
            $table->string('media')->nullable();
            $table->string('image_path')->nullable();
            $table->string('home_ip')->nullable();
            $table->string('home_deviceID')->nullable();
            $table->string('home_device_name')->nullable();
            $table->string('status')->comment('A=Active, B=Banned, L=Locked, I=Inactive, D=Deleted');
            $table->timestamp('dob')->nullable();
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
