<?php

use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\Post;
use App\Models\User;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->constrained()->onDelete('cascade');
            $table->foreignIdFor(Category::class, 'category_id')->constrained()->onDelete('cascade');
            $table->foreignIdFor(City::class, 'location_id')->constrained()->onDelete('cascade');
            $table->foreignIdFor(Company::class, 'company_id')->constrained()->onDelete('cascade');
            $table->string('tittle')->nullable();
            $table->text('description')->nullable();
            $table->string('type')->nullable();
            $table->integer('salary')->nullable();
            $table->integer('nrWorkers')->nullable();
            $table->string('expiration_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
