<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('invoice_number')->nullable()->unique();
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->text('notes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropUnique(['invoice_number']);
            $table->dropColumn(['client_id', 'invoice_number', 'total_amount']);
        });
    }
};
