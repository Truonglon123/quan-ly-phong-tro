<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->decimal('default_rent', 15, 2)->comment('Giá thuê mặc định');
            $table->integer('max_occupants')->comment('Số người tối đa');
            $table->enum('status', ['AVAILABLE', 'RESERVED', 'OCCUPIED', 'MAINTENANCE', 'INACTIVE'])
                ->default('AVAILABLE')
                ->comment('Trạng thái phòng');
            $table->text('description')->nullable();
            $table->bigInteger('location_id')->unsigned();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
