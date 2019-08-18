<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Charts;

use App\User;

use DB;


class ChartController extends Controller

{

    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */

    public function makeChart($type)

    {

        switch ($type) {

            case 'bar':

                $users = User::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))

                        ->get();

                $chart = Charts::database($users, 'bar', 'highcharts')

                            ->title("Monthly new Register Users")

                            ->elementLabel("Total Users")

                            ->dimensions(1000, 500)

                            ->responsive(true)

                            ->groupByMonth(date('Y'), true);

                break;


            case 'pie':
            $val = array(20,10,5);

                $chart = Charts::create('pie', 'highcharts')

                            ->title('Departments')

                            ->labels(['CSE', 'EEE', 'CE'])

                            ->values($val)

                            ->dimensions(1000,500)


                            ->responsive(false);

                break;


            case 'donut':

                $chart = Charts::create('donut', 'highcharts')

                            ->title('HDTuto.com Laravel Donut Chart')

                            ->labels(['First', 'Second', 'Third'])

                            ->values([5,10,20])

                            ->dimensions(1000,500)

                            ->responsive(true);

                break;


            case 'line':

                $chart = Charts::create('line', 'highcharts')

                            ->title('HDTuto.com Laravel Line Chart')

                            ->elementLabel('HDTuto.com Laravel Line Chart Lable')

                            ->labels(['First', 'Second', 'Third'])

                            ->values([5,10,20])

                            ->dimensions(1000,500)

                            ->responsive(true);

                break;


            case 'area':

                $chart = Charts::create('area', 'highcharts')

                            ->title('HDTuto.com Laravel Area Chart')

                            ->elementLabel('HDTuto.com Laravel Line Chart label')

                            ->labels(['First', 'Second', 'Third'])

                            ->values([5,10,20])

                            ->dimensions(1000,500)

                            ->responsive(true);

                break;


            case 'geo':

                $chart = Charts::create('geo', 'highcharts')

                            ->title('HDTuto.com Laravel GEO Chart')

                            ->elementLabel('HDTuto.com Laravel GEO Chart label')

                            ->labels(['ES', 'FR', 'RU'])

                            ->colors(['#3D3D3D', '#985689'])

                            ->values([5,10,20])

                            ->dimensions(1000,500)

                            ->responsive(true);

                break;


            default:

                # code...

                break;

        }

        return view('chart', compact('chart'));

    }

}
