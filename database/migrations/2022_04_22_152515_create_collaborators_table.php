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
        Schema::create('collaborators', function (Blueprint $table) {
            $table->id();
            $table->text('no_colaborador');

            $table->foreignId('assigned_offices_id')
                ->constrained('assigned_offices')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('nombre_1', 50);
            $table->string('nombre_2', 50)->nullable();
            $table->string('ap_paterno', 50);
            $table->string('ap_materno', 50)->nullable();
            $table->date('fecha_nacimiento');

            $table->foreignId('genders_id')
                ->constrained('genders')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('marital_statuses_id')
                ->constrained('marital_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('curp', 18)->nullable();
            $table->string('rfc', 15);

            $table->foreignId('life_insurance_types_id')
                ->constrained('life_insurance_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('no_seguro_social', 15)->nullable();
            $table->string('no_pasaporte', 10)->nullable();
            $table->string('no_visa_americana', 8)->nullable();
            $table->string('domicilio', 128);
            $table->string('colonia', 100);
            $table->string('municipio', 45);
            $table->string('estado', 45);

            $table->foreignId('nationalities_id')
                ->constrained('nationalities')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('codigo_postal', 8);
            $table->boolean('paternidad');

            $table->foreignId('job_titles_id')
                ->constrained('job_titles')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('work_areas_id')
                ->constrained('work_areas')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('correo', 255)->nullable();

            $table->foreignId('employment_contract_types_id')
                ->constrained('employment_contract_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->date('fecha_ingreso');
            $table->boolean('estado_colaborador');
            $table->string('foto', 255);

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
        Schema::dropIfExists('collaborators');
    }
};
