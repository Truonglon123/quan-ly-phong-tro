<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('water_rates', function (Blueprint $table) {
            $table->id();
            $table->enum('billing_method', ['METER', 'PER_PERSON'])->comment('Tính theo đầu người hay theo khối');
            $table->decimal('price_per_unit', 15, 2)->comment('Đơn giá');
            $table->date('effective_from')->comment('Ngày bắt đầu');
            $table->date('effective_to')->nullable()->comment('Ngày kết thúc');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('location_id')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('water_rates');
    }
};
