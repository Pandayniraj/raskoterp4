<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmsOperationExtensionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pms_operation_extension_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pms_operation_id');
            $table->date('request_date')->nullable();
            $table->date('office_letter_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->text('extension_reason')->nullable();
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
        Schema::dropIfExists('extension_details');
    }
}
