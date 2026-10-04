<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->foreign('location_id')->references('id')->on('locations')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::table('contracts', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms')
                ->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('tenant_id')->references('id')->on('tenants')
                ->restrictOnDelete()->cascadeOnUpdate();
        });

        Schema::table('contract_occupants', function (Blueprint $table) {
            $table->foreign('contract_id')->references('id')->on('contracts')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('tenant_id')->references('id')->on('tenants')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::table('meter_readings', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::table('electricity_rates', function (Blueprint $table) {
            $table->foreign('location_id')->references('id')->on('locations')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::table('water_rates', function (Blueprint $table) {
            $table->foreign('location_id')->references('id')->on('locations')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::table('fee_rates', function (Blueprint $table) {
            $table->foreign('fee_type_id')->references('id')->on('fee_types')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('location_id')->references('id')->on('locations')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('contract_id')->references('id')->on('contracts')
                ->restrictOnDelete()->cascadeOnUpdate();
        });

        Schema::table('invoice_items', function (Blueprint $table) {
            $table->foreign('invoice_id')->references('id')->on('invoices')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('meter_reading_id')->references('id')->on('meter_readings')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('fee_rate_id')->references('id')->on('fee_rates')
                ->nullOnDelete()->cascadeOnUpdate();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('invoice_id')->references('id')->on('invoices')
                ->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::table('payments', fn(Blueprint $t) => $t->dropForeign(['invoice_id']));

        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropForeign(['invoice_id']);
            $table->dropForeign(['meter_reading_id']);
            $table->dropForeign(['fee_rate_id']);
        });

        Schema::table('invoices', fn(Blueprint $t) => $t->dropForeign(['contract_id']));

        Schema::table('fee_rates', function (Blueprint $table) {
            $table->dropForeign(['fee_type_id']);
            $table->dropForeign(['location_id']);
        });

        Schema::table('water_rates', fn(Blueprint $t) => $t->dropForeign(['location_id']));
        Schema::table('electricity_rates', fn(Blueprint $t) => $t->dropForeign(['location_id']));
        Schema::table('meter_readings', fn(Blueprint $t) => $t->dropForeign(['room_id']));
        Schema::table('assets', fn(Blueprint $t) => $t->dropForeign(['room_id']));

        Schema::table('contract_occupants', function (Blueprint $table) {
            $table->dropForeign(['contract_id']);
            $table->dropForeign(['tenant_id']);
        });

        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropForeign(['tenant_id']);
        });

        Schema::table('rooms', fn(Blueprint $t) => $t->dropForeign(['location_id']));
        Schema::table('locations', fn(Blueprint $t) => $t->dropForeign(['user_id']));
    }
};
