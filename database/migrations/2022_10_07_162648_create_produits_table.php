<?php

use App\Models\Categorie;
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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nom_produit');
            $table->text('description_courte_produit');
            $table->text('description_longue_produit');
            $table->string('url_image_produit');
            $table->decimal('prix_produit');
            $table->foreignIdFor(Categorie::class);
            $table->boolean('isAccueil')->nullable();
            $table->string('url_externe')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produits');
    }
};
