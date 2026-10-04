<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 15, 2)->comment('Số tiền thanh toán');
            $table->enum('payment_method', ['CASH', 'BANK_TRANSFER'])->comment('Phương thức');
            $table->date('paid_at')->comment('Thời điểm thanh toán');
            $table->string('reference', 255)->nullable()->comment('Mã giao dịch');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('invoice_id')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
