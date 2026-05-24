<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'staff'])->default('staff')->after('password');
        });

        Schema::create('plots', function (Blueprint $table) {
            $table->id();
            $table->string('plot_number', 50);
            $table->string('section', 50);
            $table->enum('status', ['available', 'reserved', 'occupied'])->default('available');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 150);
            $table->string('contact_number', 50);
            $table->text('address');
            $table->timestamps();
        });
        Schema::create('plot_owner', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plot_id')->constrained('plots')->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('owners')->onDelete('cascade');
        });
        Schema::create('deceased', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 150);
            $table->date('birth_date');
            $table->date('death_date');
            $table->foreignId('plot_id')->unique()->nullable()
                  ->constrained('plots')->nullOnDelete();
            $table->timestamps();
        });
        Schema::create('burials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deceased_id')->constrained('deceased')->onDelete('cascade');
            $table->foreignId('plot_id')->constrained('plots')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('burial_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('owners')->onDelete('cascade');
            $table->foreignId('plot_id')->constrained('plots')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['cash', 'gcash', 'bank_transfer', 'check'])->default('cash');
            $table->date('payment_date');
            $table->enum('status', ['paid', 'pending'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('burials');
        Schema::dropIfExists('deceased');
        Schema::dropIfExists('plot_owner');
        Schema::dropIfExists('owners');
        Schema::dropIfExists('plots');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
