<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_id')->unsigned()->comment('Hóa đơn');
            $table->string('description', 255);
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2)->comment('Đơn giá');
            $table->decimal('amount', 15, 2)->comment('Thành tiền');
            $table->enum('item_type', ['RENT', 'ELECTRICITY', 'WATER', 'INTERNET', 'TRASH', 'PARKING', 'OTHER'])->comment('Loại khoản');
            $table->unsignedBigInteger('meter_reading_id')->nullable()->index();
            $table->unsignedBigInteger('fee_rate_id')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
