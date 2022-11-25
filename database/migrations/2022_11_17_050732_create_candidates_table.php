<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_opening_id')
                ->constrained('job_openings')->onDelete('CASCADE');
            $table->foreignId('user_id')
                ->constrained('users')->onDelete('CASCADE');
            $table->foreignId('stage_id')->nullable()
                ->constrained('stages')->onDelete('SET NULL');
            $table->unique(['job_opening_id','user_id']);
            $table->string('status')->default('Pending review');
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
        Schema::dropIfExists('candidates');
    }
}
