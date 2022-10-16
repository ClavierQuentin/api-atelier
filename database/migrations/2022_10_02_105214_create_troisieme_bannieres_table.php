<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('troisieme_bannieres', function (Blueprint $table) {
            $table->id();
            $table->string('titre_principal');
            $table->string('titre_1');
            $table->string('titre_2');
            $table->string('texte_1');
            $table->string('texte_2');
            $table->string('url_image');
            $table->string('url_image_2');
            $table->foreignIdFor(User::class);
            $table->boolean('online')->nullable();
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
        Schema::dropIfExists('troisieme_bannieres');
    }
};
