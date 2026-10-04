<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meter_readings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('room_id')->unsigned()->comment('Mã phòng');
            $table->enum('meter_type', ['ELECTRICITY', 'WATER'])->comment('Chỉ số đồng hồ điện hay nước');
            $table->date('reading_date')->comment('Ngày ghi');
            $table->decimal('previous_reading', 15, 3)->comment('Chỉ số cũ');
            $table->decimal('current_reading', 15, 3)->comment('Chỉ số mới');
            $table->decimal('consumption', 15, 3)->comment('Mức tiêu thụ');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meter_readings');
    }
};
