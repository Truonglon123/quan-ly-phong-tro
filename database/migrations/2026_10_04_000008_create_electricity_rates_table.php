<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('electricity_rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('price_per_unit', 15, 2)->comment('Giá/kWh');
            $table->date('effective_from')->comment('Ngày bắt đầu áp dụng');
            $table->date('effective_to')->nullable()->comment('Ngày kết thúc');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('location_id')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('electricity_rates');
    }
};
