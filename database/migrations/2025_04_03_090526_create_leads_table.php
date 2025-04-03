<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     /*
    Created By Kumar Asapu (03-Apr-2025)
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('customer_name');
            $table->string('customer_company')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->decimal('value', 10, 2);
            $table->string('currency', 3);
            $table->string('phone');
            $table->enum('phone_type', ['work', 'home']);
            $table->unsignedBigInteger('lead_source_id');
            $table->unsignedBigInteger('lead_status_id');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->string('priority')->default('cold');
            $table->text('tags')->nullable();
            $table->integer('rated')->nullable();
            $table->text('description');
            $table->enum('visibility', ['public', 'private'])->default('private');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('city_town')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamp('lastdate')->nullable();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('lead_source_id')->references('id')->on('lead_sources')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('lead_status_id')->references('id')->on('lead_statuses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['lead_source_id']);
            $table->dropForeign(['lead_status_id']);
            $table->dropForeign(['assigned_to']);
        });
        Schema::dropIfExists('leads');
    }
};
