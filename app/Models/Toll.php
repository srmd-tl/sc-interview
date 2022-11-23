<?php

namespace App\Models;

use App\Observers\TollObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Toll extends Model {
    use HasFactory;

    const BASE_RATE = 20;
    const CHARGE_PER_KM = 0.2;
    protected $guarded = [];

    /**
     * Return discount percentage
     *
     * @param string $plateNum
     *
     * @return int
     */
    public static function discountRate( string $plateNum ): int {

        if ( self::isNationalHoliday() ) {
            return 50;
        }
        //to separate digit part.
        $plateNum = explode( '-', $plateNum )[1];
        $dayName  = Carbon::today()->shortDayName;
        if ( ( $dayName == 'Mon' || $dayName == 'Wed' ) && ! ( self::isOdd( (int) $plateNum ) ) ) {
            return 10;
        } else if ( ( $dayName == 'Tue' || $dayName == 'Thu' ) && ( self::isOdd( (int) $plateNum ) ) ) {
            return 10;
        } else {
            return 0;
        }
    }

    /**
     * Is national holidays
     * @return bool
     */
    public static function isNationalHoliday() {
        $date = Carbon::today()->format( 'm-d' );
        if ( $date == "3 - 23" || $date == "08 - 14" || $date == "12 - 25" ) {
            return true;
        }

        return false;
    }

    /**
     * check if odd or not
     *
     * @param int $num
     *
     * @return bool
     */
    public static function isOdd( int $num ): bool {
        return ( $num % 2 ) != 0;
    }

    public static function calculateDistance( $entryDistance, $exitDistance ) {
        return $exitDistance - $entryDistance;

    }

    /**
     * @return float
     */
    public static function perKmRate(): float {
        return self::isWeekend() ? 1.5 : self::CHARGE_PER_KM;
    }

    /**
     * Is Sat/Sun
     * @return bool
     */
    public static function isWeekend(): bool {
        return Carbon::now()->isWeekend();
    }


    //Relations

    public function entryPoint(): BelongsTo {
        return $this->belongsTo( RoadMap::class, 'entry_road_map_id' );
    }

    public function exitPoint(): BelongsTo {
        return $this->belongsTo( RoadMap::class, 'exit_road_map_id' );
    }


}
