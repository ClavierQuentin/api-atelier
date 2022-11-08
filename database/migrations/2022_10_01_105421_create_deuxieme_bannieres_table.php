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
        Schema::create('deuxieme_bannieres', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('texte');
            $table->foreignIdFor(User::class)->constrained();
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
        Schema::dropIfExists('deuxieme_bannieres');
    }
};
