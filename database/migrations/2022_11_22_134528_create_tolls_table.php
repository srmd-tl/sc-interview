<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTollsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'tolls', function ( Blueprint $table ) {
            $table->id();
            $table->foreignId( 'entry_road_map_id' )
                  ->comment( 'entry point id' );
            $table->foreignId( 'exit_road_map_id' )
                  ->comment( 'exit point id' )
                  ->nullable();

            $table->string( 'plate_number' )
                  ->comment( 'vehicle plate number' );

            $table->double( 'distance_cost' )
                 ->default( 0.0 )
                  ->comment( 'distance cost' );
            $table->integer( 'discount' )
                  ->default( 0 )
                  ->comment( 'discount by days/plate ruleset' );

            $table->double( 'sub_total' )
                  ->default( 0.0 )
                  ->comment( 'subtotal' );
            $table->double( 'total' )
                  ->default( 0.0 )
                  ->comment( 'total bill to charge' );
            $table->timestamps();

            //foreign keys
            $table->foreign( 'entry_road_map_id' )
                  ->on( 'road_maps' )
                  ->references( 'id' )
                  ->onDelete( 'cascade' );
            $table->foreign( 'exit_road_map_id' )
                  ->on( 'road_maps' )
                  ->references( 'id' )
                  ->onDelete( 'cascade' );

        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'tolls' );
    }
}
