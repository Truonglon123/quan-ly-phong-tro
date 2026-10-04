<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number', 50)->unique()->comment('Số hợp đồng');
            $table->date('start_date')->comment('Ngày bắt đầu');
            $table->date('end_date')->comment('Ngày kết thúc');
            $table->decimal('agreed_rent', 15, 2)->comment('Giá thuê thực tế');
            $table->decimal('deposit_amount', 15, 2)->comment('Tiền cọc');
            $table->integer('max_occupants')->comment('Số người tối đa');
            $table->enum('water_billing_method', ['METER', 'PER_PERSON'])->comment('Cách tính nước');
            $table->enum('status', ['DRAFT', 'ACTIVE', 'EXPIRED', 'TERMINATED'])->comment('Trạng thái hợp đồng');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('room_id')->index();
            $table->unsignedBigInteger('tenant_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
