<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('ticket_id')->constrained();
            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 8, 2);
            $table->timestamp('order_date')->useCurrent(); // Definisikan kolom dengan default saat ini
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        // Jika Anda ingin mengubah kolom order_date setelah mendefinisikannya
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('order_date')->change(); // Ini akan mengubah kolom yang sudah ada
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['ticket_id']);
        });

        Schema::dropIfExists('orders');
    }
}