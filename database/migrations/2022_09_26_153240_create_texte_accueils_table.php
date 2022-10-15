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
        Schema::create('texte_accueils', function (Blueprint $table) {
            $table->id();
            $table->string('titre_accueil');
            $table->text('texte_accueil');
            $table->string('titre_categories');
            $table->foreignIdFor(User::class);
            $table->boolean('online');
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
        Schema::dropIfExists('texte_accueils');
    }
};
