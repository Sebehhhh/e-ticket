<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOrderDateTypeInOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('order_date')->change(); // Mengubah kolom order_date menjadi timestamp
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_date')->change(); // Mengembalikan kolom order_date menjadi string jika migrasi dibatalkan
        });
    }
}