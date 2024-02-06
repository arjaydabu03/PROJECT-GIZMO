<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("ap_account", function (Blueprint $table) {
            $table->increments("id");

            $table->unsignedInteger("account_id")->index();
            $table
                ->foreign("account_id")
                ->references("id")
                ->on("users");

            $table->unsignedInteger("ap_id")->index();
            $table
                ->foreign("ap_id")
                ->references("id")
                ->on("ap_tagging");

            $table->string("ap_code");
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
        Schema::dropIfExists("ap_account");
    }
};
