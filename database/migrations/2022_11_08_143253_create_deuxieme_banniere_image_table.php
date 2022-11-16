<?php

use App\Models\DeuxiemeBanniere;
use App\Models\Image;
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
        Schema::create('deuxieme_banniere_image', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Image::class)->constrained();
            $table->foreignIdFor(DeuxiemeBanniere::class)->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('deuxieme_banniere_image');
    }
};
