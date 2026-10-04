<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_rates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fee_type_id')->unsigned();
            $table->decimal('price', 15, 2)->comment('Đơn giá');
            $table->date('effective_from')->comment('Ngày bắt đầu');
            $table->date('effective_to')->nullable()->comment('Ngày kết thúc');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('location_id')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_rates');
    }
};
