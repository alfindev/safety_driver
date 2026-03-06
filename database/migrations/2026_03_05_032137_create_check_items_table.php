<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Master item checklist (40 item)
        Schema::create('check_items', function (Blueprint $table) {
            $table->id();
            $table->string('category');        // MAN, Machine, Material, dll
            $table->integer('item_number');    // nomor urut 1-40
            $table->string('item_name');       // Seragam, Lampu Utama, dst
            $table->string('standard');        // keterangan standar
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Hasil checklist per sesi pengecekan
        Schema::create('check_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('check_sheet_id')->constrained()->onDelete('cascade');
            $table->foreignId('check_item_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['ok', 'nok', 'na'])->default('na');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('check_results');
        Schema::dropIfExists('check_items');
    }
};