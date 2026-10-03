<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->string('booking_type');
            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();
            $table->unsignedInteger('adults')->default(1);
            $table->unsignedInteger('children')->default(0);
            $table->unsignedInteger('rooms')->default(1);
            $table->string('event_type')->nullable();
            $table->unsignedInteger('guest_count')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('new');
            $table->text('admin_notes')->nullable();
            $table->string('source')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('status');
            $table->index('check_in');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
