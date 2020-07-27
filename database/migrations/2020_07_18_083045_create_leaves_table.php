<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_department');
            $table->integer('type');
            $table->string('date');
            $table->string('start')->default(0);
            $table->string('end')->default(0);
            $table->string('destination');
            $table->string('detail');
            $table->integer('approve');
            $table->integer('approvedBy')->default(0);
            $table->timestamps();
            $table->integer('delete')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaves');
    }
}
