<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 255);
            $table->string('phone', 10);
            $table->string('email', 255)->nullable();
            $table->string('identity_number', 30)->unique()->comment('CCCD/CMND');
            $table->date('date_of_birth')->comment('Ngày sinh');
            $table->string('address', 255);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
