<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmsOperationPlanPhotoFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pms_operation_plan_photo_file', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pms_operation_id');
            $table->string('photo_or_file');
            $table->string('photo_file_details');
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
        Schema::dropIfExists('pms_operation_plan_photo_file');
    }
}
