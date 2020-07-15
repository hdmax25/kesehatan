<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblAttendanceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblattendancelog', function (Blueprint $table) {
            $table->string('EmpCode', 16);
            $table->string('Dt', 8);
            $table->string('Tm', 6);
            $table->string('Machine', 400)->nullable();
            $table->string('PIN', 16)->nullable();
            $table->string('IPAddress',15)->nullable();
            $table->string('Latitude', 100)->nullable();
            $table->string('Longitude',100)->nullable();
            $table->string('City', 250)->nullable();
            $table->string('Remark', 400)->nullable();
            $table->string('ProcessInd', 1)->default('N');
            $table->string('CreateBy', 16);
            $table->string('CreateDt', 12);
            $table->string('LastUpBy', 16)->nullable();
            $table->string('LastUpDt', 12)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblattendancelog');
    }
}
