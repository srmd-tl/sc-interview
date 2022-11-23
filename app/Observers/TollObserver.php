<?php

namespace App\Observers;

use App\Models\Toll;

class TollObserver {
    public $afterCommit = true;
    /**
     * Handle the Toll "updated" event.
     *
     * @param Toll $toll
     *
     * @return void
     */
    public function updated( Toll $toll ) {
        if ( $toll->exit_road_map_id ) {
            $totalDistance = Toll::calculateDistance( $toll->entryPoint->distance, $toll->exitPoint->distance );
            if ( $totalDistance ) {
                $distanceRate     = $totalDistance * Toll::perKmRate();
                $subTotal         = $distanceRate + Toll::BASE_RATE;
                $discountRate     = Toll::discountRate( $toll->plate_number );
                if($distanceRate>0)
                {
                    $amountToDiscount = $subTotal * ( $discountRate / 100 );
                }
                else
                {
                    $amountToDiscount=0;
                }
                $total            = $subTotal - $amountToDiscount;

                $toll->discount      = $discountRate;
                $toll->distance_cost = $distanceRate;
                $toll->sub_total     = $subTotal;
                $toll->total         = $total;
                //To avoid dead loop,saving it silently.
                $toll->saveQuietly();
            }
        }
    }
}
