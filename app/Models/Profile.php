<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('bio')->nullable();
            $table->timestamps();
        });
    }


    // Existing Profile model code

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
