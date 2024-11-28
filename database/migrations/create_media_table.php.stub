<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(app(config('media-picker.model'))->getTable(), function (Blueprint $table) {
            $table->ulid('ulid')->primary();
            $table->ulidMorphs('model');
            $table->string('disk')->index();
            $table->unsignedBigInteger('uploaded_by')->nullable()->index();
            $table->string('filename');
            $table->string('extension');
            $table->string('mime_type');
            $table->unsignedBigInteger('size');
            $table->unsignedBigInteger('width');
            $table->unsignedBigInteger('height');
            $table->string('checksum', 32);
            $table->boolean('public')->default(true);
            $table->unsignedBigInteger('position');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('uploaded_by')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(app(config('media-picker.model'))->getTable());
    }
};
