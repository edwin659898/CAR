<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFSCAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_s_c_audits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('response_id');
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('hod_id')->nullable();
            $table->unsignedBigInteger('followup_id')->nullable();
            $table->unsignedBigInteger('checklist_id')->nullable();
            $table->string('date');
            $table->string('number');
            $table->string('auditor');
            $table->string('auditee');
            $table->string('site');
            $table->string('department');
            $table->string('clause');
            $table->string('name');
            $table->string('checkbox');
            $table->text('report');
            $table->string('status')->default('pending');
            $table->string('response_date')->nullable();
            $table->string('manager_date')->nullable();
            $table->string('followup_date')->nullable();
            $table->string('followup_end_date')->nullable();
            $table->string('hod_date')->nullable();
            $table->string('comment')->nullable();
            $table->text('communication_comment')->nullable();
            $table->text('hr_comment')->nullable();
            $table->text('mt_comment')->nullable();
            $table->text('final_comment')->nullable();
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
        Schema::dropIfExists('f_s_c_audits');
    }
}
