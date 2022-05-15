<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationsTable extends Migration {
 /**
  * Run the migrations.
  *
  * @return void
  */
 public function up() {
  Schema::create('translations', function (Blueprint $table) {
   $table->increments('id');
   $table->integer('word_id');
   $table->integer('type_id');
   $table->text('translation');
   $table->text('example')->nullable();
   $table->text('example_translation')->nullable();
      $table->integer('user_id');
      $table->integer('updater_id');
   $table->timestamps();
  });
 }

 /**
  * Reverse the migrations.
  *
  * @return void
  */
 public function down() {
  Schema::dropIfExists('translations');
 }
}
