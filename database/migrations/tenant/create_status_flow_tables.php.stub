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
        Schema::create('status_flows', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->string('model');
            $table->boolean('active');
            $table->string('color')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_editable')->default(false);
            $table->boolean('is_notifiable')->default(false);
            $table->boolean('is_finalized')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['name', 'model']);
        });

        Schema::create('status_flow_dependecies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_flow_id')->constrained();
            $table->foreignId('status_flow_dependecy_id')->references('id')->on('status_flows');
            $table->timestamps();

            $table->unique(['status_flow_id', 'status_flow_dependecy_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_flow_dependecies');
        Schema::dropIfExists('status_flows');
    }
};
