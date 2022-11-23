<?php

namespace App\Http\Controllers;

use App\Models\Toll;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TollController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a record for entry point
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function entry( Request $request ): JsonResponse {
        $request->validate( [
            'entry_road_map_id' => [ 'required', 'integer', 'digits_between:1,7' ],
            'plate_number'      => [ 'required', 'regex:/^[A-Z]{3}-\d{3}$/' ]
        ] );
        $data = [ 'plate_number' => $request->plate_number, 'entry_road_map_id' => $request->entry_road_map_id ];
        Toll::create( $data );

        return \response()->json( [ 'message' => 'Entry successfully', 'data' => null ], 200 );

    }

    /**
     * Store a record for exist point
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function exit( Request $request ): JsonResponse {
        $request->validate( [
            'exit_road_map_id' => [ 'required', 'integer', 'digits_between:1,7' ],
            'plate_number'     => [ 'required', 'regex:/^[A-Z]{3}-\d{3}$/' ]
        ] );

        $toll = Toll::wherePlateNumber( $request->plate_number )
                    ->whereDate( 'created_at', Carbon::today()->toDateString() )
                    ->first();
        if ( $toll ) {
            $data = [ 'exit_road_map_id' => $request->exit_road_map_id ];

            $toll->update( $data );
            $data = [
                'distance_cost' => (double) number_format( $toll->distance_cost, '3' ),
                'discount'      => $toll->discount,
                'sub_total'     => $toll->sub_total,
                'total'         => $toll->total
            ];

            return \response()->json( [ 'message' => 'Exit successfully', 'data' => $data ], 200 );
        }
        abort( 404 );

    }

    /**
     * Display the specified resource.
     *
     * @param Toll $toll
     *
     * @return Response
     */
    public function show( Toll $toll ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Toll $toll
     *
     * @return Response
     */
    public function edit( Toll $toll ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Toll $toll
     *
     * @return JsonResponse
     */
    public function update( Request $request, Toll $toll ) {
        $request->validate( [
            'plate_number' => [ 'required', 'regex:/^[A-Z]{3}-\d{3}$/', 'unique:tolls,plate_number,' . $toll->id ]
        ] );
        $data = [
            'plate_number'      => $request->plate_number,
            'exit_road_map_id'  => $request->exit_road_map_id??$toll->exit_road_map_id,
            'entry_road_map_id' => $request->entry_road_map_id??$toll->entry_road_map_id
        ];
        $toll->update( $data );

        return \response()->json( [ 'message' => 'Record updated successfully', 'data' => $data ], 200 );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Toll $toll
     *
     * @return Response
     */
    public function destroy( Toll $toll ) {
        //
    }
}
