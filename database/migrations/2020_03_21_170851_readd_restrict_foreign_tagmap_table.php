<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReaddRestrictForeignTagmapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tagmaps', function (Blueprint $table) {
            $table->foreign('post_id')->references('id')->on('posts')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tagmaps', function (Blueprint $table) {
            $table->dropForeign('tagmaps_post_id_foreign');
            $table->dropForeign('tagmaps_tag_id_foreign');
        });
    }
}
