<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('subject_type'); // textbook, workbook, etc.
            $table->string('book_type'); // english, mathematics, etc.
            $table->string('publisher')->nullable();
            $table->string('isbn')->nullable();
            $table->integer('reorder_level')->default(10);
        });
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'subject_type', 'book_type', 'publisher', 'isbn', 'reorder_level']);
        });
    }
};