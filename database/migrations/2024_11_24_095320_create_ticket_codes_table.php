<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketCodesTable extends Migration
{
    public function up()
    {
        Schema::create('ticket_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Relasi dengan tabel orders
            $table->string('code')->unique(); // Kode tiket yang unik
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_codes');
    }
}