<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternsRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interns__registers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->date('dateofbirth');
            $table->string('email');
            $table->string('phone');
            $table->string('studentid');
            $table->string('position');
            $table->string('school');
            $table->string('faculty');
            $table->integer('year');
            $table->string('avatar');
            $table->string('cv');
            $table->string('lecturername');
            $table->string('lectureremail');
            $table->string('lecturerphone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interns__registers');
    }
}
