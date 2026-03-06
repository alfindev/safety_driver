<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('check_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->date('check_date');
            $table->time('departure_time')->nullable();
            $table->time('estimated_arrival')->nullable();
            $table->string('route')->nullable();
            $table->integer('km_start')->nullable();
            $table->integer('km_end')->nullable();
            $table->enum('driver_fitness', ['fit', 'caution', 'unfit'])->default('fit');
            $table->enum('overall_status', ['ok', 'nok', 'draft'])->default('draft');
            $table->text('notes')->nullable();
            $table->string('signature_path')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('email_sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('check_sheets');
    }
};