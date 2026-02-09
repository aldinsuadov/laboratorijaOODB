<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Display statistics page.
     */
    public function index()
    {
        // 1. Top test types (count appointments by test_type)
        $topTestTypes = Appointment::select('test_types.name', DB::raw('count(*) as count'))
            ->join('test_types', 'appointments.test_type_id', '=', 'test_types.id')
            ->groupBy('test_types.id', 'test_types.name')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        // 3. Objavljeni vs neobjavljeni nalazi
        $publishedResults = TestResult::whereNotNull('published_at')->count();
        $unpublishedResults = TestResult::whereNull('published_at')->count();
        
        $resultsStatus = [
            'published' => $publishedResults,
            'unpublished' => $unpublishedResults,
            'total' => $publishedResults + $unpublishedResults,
        ];

        // 4. Prosječno vrijeme od termina do objave nalaza
        // Database-agnostic query that works on both MySQL and PostgreSQL
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'pgsql') {
            // PostgreSQL: 
            // - For hours: Combine date + time into timestamp, then calculate difference
            //   EXTRACT(EPOCH FROM (timestamp - timestamp)) gives seconds, divide by 3600 for hours
            // - For days: date - date gives integer days directly (no EXTRACT needed)
            $averageTimeToPublish = TestResult::select(
                    DB::raw("AVG(EXTRACT(EPOCH FROM (test_results.published_at - (appointments.appointment_date + COALESCE(appointments.appointment_time::time, '00:00:00'::time)))) / 3600) as avg_hours"),
                    DB::raw("AVG((test_results.published_at::date - appointments.appointment_date)) as avg_days")
                )
                ->join('appointments', 'test_results.appointment_id', '=', 'appointments.id')
                ->whereNotNull('test_results.published_at')
                ->first();
        } else {
            // MySQL: Original query
            $averageTimeToPublish = TestResult::select(
                    DB::raw('AVG(TIMESTAMPDIFF(HOUR, CONCAT(appointments.appointment_date, " ", COALESCE(appointments.appointment_time, "00:00:00")), test_results.published_at)) as avg_hours'),
                    DB::raw('AVG(TIMESTAMPDIFF(DAY, appointments.appointment_date, DATE(test_results.published_at))) as avg_days')
                )
                ->join('appointments', 'test_results.appointment_id', '=', 'appointments.id')
                ->whereNotNull('test_results.published_at')
                ->first();
        }

        $avgHours = $averageTimeToPublish && $averageTimeToPublish->avg_hours ? round($averageTimeToPublish->avg_hours, 2) : 0;
        $avgDays = $averageTimeToPublish && $averageTimeToPublish->avg_days ? round($averageTimeToPublish->avg_days, 2) : 0;

        return view('statistics.index', compact(
            'topTestTypes',
            'resultsStatus',
            'avgHours',
            'avgDays'
        ));
    }
}
