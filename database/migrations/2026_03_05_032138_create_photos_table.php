<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('check_sheet_id')->constrained()->onDelete('cascade');
            $table->foreignId('check_item_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('label');       // Ban Depan, KM Awal, Foto SIM, dll
            $table->string('file_path');   // path lokal storage HP
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};