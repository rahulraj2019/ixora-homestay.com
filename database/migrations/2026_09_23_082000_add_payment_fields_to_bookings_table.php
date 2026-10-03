<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (! Schema::hasColumn('bookings', 'payment_status')) {
                $table->string('payment_status')->default('unpaid')->after('status');
            }
            if (! Schema::hasColumn('bookings', 'amount_total')) {
                $table->decimal('amount_total', 10, 2)->nullable()->after('payment_status');
            }
            if (! Schema::hasColumn('bookings', 'amount_paid')) {
                $table->decimal('amount_paid', 10, 2)->nullable()->after('amount_total');
            }
            if (! Schema::hasColumn('bookings', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('amount_paid');
            }
            if (! Schema::hasColumn('bookings', 'payment_notes')) {
                $table->text('payment_notes')->nullable()->after('payment_method');
            }
            if (! Schema::hasColumn('bookings', 'confirmed_at')) {
                $table->timestamp('confirmed_at')->nullable()->after('payment_notes');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $cols = ['payment_status', 'amount_total', 'amount_paid', 'payment_method', 'payment_notes', 'confirmed_at'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('bookings', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
