<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Phpml\Classification\SVC;
use Phpml\ModelManager;
use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\Classification\NaiveBayes;
use Phpml\Classification\Ensemble\RandomForest;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use File;



class PredictionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->modelManager = new modelManager();
        $this->global_path =  null;
    }

    public function index()
    {
        //
        $data = [
            'count_user' => User::latest()->count(),
            'menu'       => 'menu.v_menu_admin',
            'content'    => 'content.prediction',
            'title'    => 'Aircraft Landing Detection',
            'test_input' => []

        ];

//        $test_input = [3, 4, 5,6];
//        $predicted_value = [];
//        $test_targets = [];
//        $test_input = [];


        return view('layouts.v_template', $data);

    }

    public function ml_input_train(Request $request)
    {
        ini_set('max_execution_time', 1800);

        $this->validate($request, [
            'select_file' => 'required|mimes:csv,txt'
        ]);
        $path = $request->file('select_filphpe')->getRealPath();

        $row = 1;
        $arr_index =0;
        $train_input[] = [];
        $targets = [];
        try{
            if (($handle = fopen($path, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    #print_r($num);
                    #print_r($data);
                    $row++;
                    if($row == 2){
                        continue;
                    }
                    for ($c=0; $c < $num; $c++) {
                        #array_push($data[$arr_index][$c],$data[$c] );
                        if($c==($num-1))
                            $targets[] = $data[$c];
                        else
                            $train_input[$arr_index][] = $data[$c];

                    }
                    $arr_index++;

                }
                //            echo json_encode($train_input);
                //            echo json_encode($targets);

                #print_r($arr);
                fclose($handle);
            }

            $regression = new SVC(Kernel::RBF);
//            $regression = new RandomForest();
            $regression->train($train_input, $targets);
//            $res = $regression->predict(["70","1730","0"]);

            //        $filepath = '/path/to/store/the/model';


            #$filepath = 'C:\Users\100641313\ml_x.tmp';
//            $filepath = Storage::path('ml_x_svm.tmp');
            $filepath = Storage::path('ml_x_svm_4000.tmp');
            print_r($filepath);
            $this->modelManager->saveToFile($regression, $filepath);
            print_r("sus");

            $this->global_path = $filepath;
        } catch (\Error $errors) {
            return back()->withErrors($errors->getMessage());
        } catch (\Illuminate\Database\QueryException $errors) {
            return back()->withErrors($errors->getMessage());
        }

        $data = [
            'count_user' => User::latest()->count(),
            'menu'       => 'menu.v_menu_admin',
            'content'    => 'content.prediction',
            'title'    => 'Aircraft Landing Detection',


        ];

        return back()->with('success', 'ML Model is trained successfully.');

    }

    public function ml_input_test(Request $request)
    {   ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 60);
//        print($this->global_path);
//        date_default_timezone_set('US/Eastern');
//        $date = new DateTime();

        $this->validate($request, [
            'select_file' => 'required|mimes:csv,txt'
        ]);
        $path = $request->file('select_file')->getRealPath();
        #$data = [];
        $row = 1;
        $arr_index =0;
        $test_input[] = [];
        $test_targets = [];

        try{
            if (($handle = fopen($path, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    #print_r($num);
                    #print_r($data);
                    $row++;
                    if($row == 2){
                        continue;
                    }
                    for ($c=0; $c < $num; $c++) {
                        #array_push($data[$arr_index][$c],$data[$c] );
                        if($c==($num-1))
                            $test_targets[] = $data[$c];
                        else
                            $test_input[$arr_index][] = $data[$c];

                    }
                    $arr_index++;

                }
                $filepath = Storage::path('ml_x_rf.tmp');
                $restoredClassifier = $this->modelManager->restoreFromFile($filepath);

                $test_count = count($test_input);
                $test_input1 = $test_input;

                for ($c=0; $c < $test_count; $c++) {
                    array_shift($test_input1[$c]);
                    $predicted_value [] = $restoredClassifier->predict($test_input1[$c]);
                }


                fclose($handle);
            }

        } catch (\Error $errors) {
            return back()->withErrors($errors->getMessage());
        } catch (\Illuminate\Database\QueryException $errors) {
            return back()->withErrors($errors->getMessage());
        }

//        if (count(array_unique($predicted_value)) === 1 && end($predicted_value) === 'TRUE') {
//            $status = 'Normal Flight';
//        }else{
//            $status = 'Abnormal Flight';
//        }

        $process = new Process(['python', 'C:\Users\100641313\PhpstormProjects\laravel-8-boilerplate\resources\scripts\detection.py']);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

//        $status = ($process->getOutput());
        $status = [ ['000de98b-62bf-47e7-b19a-b63a9920dba8', 'Abnormal'], ['02b3425f-3d7f-48d9-97ab-aaae212a494c', 'Abnormal'], ['02cb4a06-1936-4292-af97-cb54b2cded57', 'Abnormal']];
//        $status = [ ['000de98b-62bf-47e7-b19a-b63a9920dba8', 'Abnormal']];
//        $status = [ ['02b3425f-3d7f-48d9-97ab-aaae212a494c', 'Abnormal']];
//        $status = [ ['02cb4a06-1936-4292-af97-cb54b2cded57', 'Abnormal']];
//        $status[] = [False, False, False];

        $data = [
            'count_user' => User::latest()->count(),
            'menu'       => 'menu.v_menu_admin',
            'content'    => 'content.prediction',
            'title'    => 'Aircraft Landing Detection',
            'predicted_value' => $predicted_value,
            'test_targets' =>$test_targets,
            'test_input'=> $test_input,
            'status' =>$status



        ];


//        print_r($status);

//        print_r($normal);
        return view('layouts.v_template', $data)->with('success', 'Results are predicted.');;
//        print_r($data);

//        return back()->with('data', $data);
//        return view('content.prediction', $data);


    }

    public function gmap_landingdata(){

        $process = new Process(['python', 'C:\Users\100641313\PhpstormProjects\laravel-8-boilerplate\resources\scripts\runway.py']);
        $process->run();


// executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }


        return \File::get(public_path() . '/four_runway.html');

        #return back()->with('success', 'Successfully created mapping');


    }


    public function single_landingdata(Request $request){

        $param1 = $_GET['param1'];

        $process = new Process(['python', 'C:\Users\100641313\PhpstormProjects\laravel-8-boilerplate\resources\scripts\landing_route.py', $param1]);
        $process->run();


// executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }


        return \File::get(public_path() . '/runway_landing1.html');

        #return back()->with('success', 'Successfully created mapping');


    }










    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
