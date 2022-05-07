<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('collaborators_id')
                ->constrained('collaborators')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->tinyInteger('no_quincena');
            $table->string('ruta_pdf', 255);
            $table->string('ruta_xml', 255);
            $table->text('comentarios')->nullable();

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
        Schema::dropIfExists('user_invoices');
    }
};
