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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('item_id'); 
            $table->unsignedBigInteger('auctioneer_id'); 
            
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('auctioneer_id')->references('id')->on('users')->onDelete('cascade');
        });
        
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
