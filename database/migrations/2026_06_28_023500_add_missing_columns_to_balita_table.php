<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('balita', function (Blueprint $table) {
            $table->decimal('berat_lahir', 5, 2)->nullable()->after('jenis_kelamin');
            $table->decimal('panjang_lahir', 5, 2)->nullable()->after('berat_lahir');
            $table->integer('anak_ke')->nullable()->after('panjang_lahir');
            $table->text('keterangan')->nullable()->after('anak_ke');
        });
    }

    public function down()
    {
        Schema::table('balita', function (Blueprint $table) {
            $table->dropColumn(['berat_lahir', 'panjang_lahir', 'anak_ke', 'keterangan']);
        });
    }
};
