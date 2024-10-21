<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->unsignedBigInteger('author_id')->nullable();
            $table->text('publisher')->nullable();
            $table->date('published_date')->nullable();
            $table->year('published_year')->nullable();
            $table->text('description')->nullable();
            $table->integer('page_count')->nullable();
            $table->float('average_rating')->default(0.00);
            $table->integer('ratings_count')->default(0);
            $table->string('language')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->text('cover_image')->default('public/storage/img/books-cover/default_cover.jpg');
            $table->text('cover_image_large')->default('public/storage/img/books-cover/default_cover.jpg');
            $table->string('isbn')->unique()->nullable();
            $table->text('buy_link')->nullable();
            $table->boolean('epub_available')->default(false);
            $table->boolean('pdf_available')->default(false);
            $table->text('acs_token_link')->nullable();
            $table->string('web_reader_link')->nullable();
            $table->string('access_view_status')->nullable();
            $table->text('slug')->nullable();
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('books');
    }
};
