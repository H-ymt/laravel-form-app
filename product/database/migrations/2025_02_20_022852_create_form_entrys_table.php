<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('form_entrys', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('name');
            $table->string('kana_name');
            $table->string('phone_number');
            $table->string("email");
            $table->string("birth_day");
            $table->string("additional_info");
            $table->integer('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('job_number');
            $table->boolean('is_output')->default(false);
            $table->timestamp('applied_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_entrys');
    }
};
