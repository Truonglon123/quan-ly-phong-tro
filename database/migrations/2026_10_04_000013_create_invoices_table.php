<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 50)->unique()->comment('Số hóa đơn');
            $table->date('billing_period')->comment('Kỳ hóa đơn');
            $table->date('issued_at')->comment('Ngày lập');
            $table->date('due_date')->nullable()->comment('Hạn thanh toán');
            $table->decimal('subtotal', 15, 2)->comment('Tổng trước điều chỉnh');
            $table->decimal('discount', 15, 2)->comment('Giảm giá');
            $table->decimal('total_amount', 15, 2)->comment('Tổng phải trả');
            $table->enum('status', ['DRAFT', 'ISSUED', 'PARTIAL', 'PAID', 'OVERDUE', 'CANCELLED'])->comment('Trạng thái');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('contract_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
