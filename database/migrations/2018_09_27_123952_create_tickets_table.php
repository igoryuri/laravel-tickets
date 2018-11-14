<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->enum('type', array_keys(\App\Models\Ticket::TYPE_TICKET));
            $table->enum('urgency', array_keys(\App\Models\Ticket::URGENCY_TICKET));
            $table->enum('impact', array_keys(\App\Models\Ticket::IMPACT_TICKET));
            $table->string('image')->nullable();
            $table->enum('status', array_keys(\App\Models\Ticket::STATUS_TICKET));
            $table->char('change', 3)->nullable();
            $table->timestamps();
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
