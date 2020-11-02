<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string( 'full_name', 256 )->unique();
            $table->string( 'email' );
            $table->integer( 'id_position' );
            $table->integer( 'id_head' )->nullable();
            $table->date( 'date_of_employment' );
            $table->string( 'phone_number', 15 );
            $table->double( 'salary', 10, 4 );
            $table->string( 'photo' )->default('no-avatar.png');
            $table->integer( 'admin_created_id' );
            $table->integer( 'admin_updated_id' );
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
        Schema::dropIfExists('employees');
    }
}
