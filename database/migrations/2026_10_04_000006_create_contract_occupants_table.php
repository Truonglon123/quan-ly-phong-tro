<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_occupants', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('contract_id')->unsigned()->comment('Mã Hợp đồng');
            $table->bigInteger('tenant_id')->unsigned()->comment('Người ở cùng');
            $table->date('start_date')->comment('Ngày bắt đầu ở');
            $table->date('end_date')->nullable()->comment('Ngày kết thúc');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_occupants');
    }
};
