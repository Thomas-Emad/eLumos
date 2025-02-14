<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index();
            $table->string('title')->nullable();
            $table->string('headline')->nullable();
            $table->string('photo')->nullable();
            $table->foreignIdFor(User::class);
            $table->text('content')->nullable();
            $table->integer('likes')->default(0);
            $table->integer('unlike')->default(0);
            $table->integer('reports')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
