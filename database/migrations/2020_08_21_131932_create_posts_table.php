<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('Title', 250);
            $table->string('Alias');
            $table->text('Short_Description');
            $table->longtext('Content');
            $table->string('Image', 150);
            $table->foreignId('cate_id')->constrained('category')->onDelete('cascade');
            $table->foreignId('blogger_id')->constrained('blogger')->onDelete('cascade');
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
        Schema::dropIfExists('posts');
    }
}
