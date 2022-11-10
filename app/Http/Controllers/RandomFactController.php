<?php

namespace App\Http\Controllers;
use app\HelperClasses\Curl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RandomFactController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // Function to show random fact
    public function showFact()
    {
        $cUrl = env('FACTAPI') . '/fact/random';
        $randomFact = app('Curl')->getMetaData($cUrl);

        // assign variables to data
        $fact = $randomFact['contents']['fact'];
        $category = $randomFact['contents']['category'];
        $subcategory = $randomFact['contents']['subcategory'];

        return response(compact('fact', 'category', 'subcategory'));
    }


    // Function to show random histotic fact based on the day and month provided by user
    public function showHistoricFact($date)
    {   
        // Remove dash from date and assign variables to data
        $value = explode('-', $date);
        $day = $value[0];
        $month = $value[1];

        $cUrl = env('FACTAPI') .'/fact/onthisday/event?month='. $month . '&day=' . $day;
        $randomHistoricFact = app('Curl')->getMetaData($cUrl);

        // assign variables to data
        $day = $randomHistoricFact['contents']['day'];
        $month = $randomHistoricFact['contents']['month'];
        $year = $randomHistoricFact['contents']['year'];
        $event = $randomHistoricFact['contents']['event'];
        return response(compact('day', 'month', 'year', 'event'));
    }
    

    // Function to complete a PUT request using the new fact provided by user
    protected function createFact(Request $request){
            $formFields = $request->all();
            unset($formFields['_token'], $formFields['_method']);

            $validated = $request->validate([
                'fact' => ['required', 'max:250'],
                'category' => ['required', 'string', 'max:50'],
                'subcategory' => ['required', 'string', 'max:50'],
                'tag' => ['required', 'string', 'max:50'],
            ],
            [
                'fact.required' => 'fact is required', 
                'fact.max' => 'fact is too long',
                'category.required' => 'category is required', 
                'category.max' => 'category is too long',
                'subcategory.required' => 'subcategory is required', 
                'subcategory.max' => 'subcategory is too long',
                'tag.required' => 'subcategory is required', 
                'tag.max' => 'subcategory is too long',
                    
            ]);


            //ensure data is in JSON
            $json_request = json_encode($formFields);
            
            //Put request to API us Curl class
            $cUrl = env('FACTAPI') . '/fact';     

            $response = app('Curl')->curlRequest($cUrl, $json_request, 'PUT');
            $id = $response['response'];
            $newId = explode('"', $id);
            $API_Id = $newId[9];
      
            if($response['status'] == 200){
                $request = 'Your number fact number is: ' .$newId[9];
                return redirect()->back()->with(['request' => $request], compact('API_Id'));
            } else { 
                $error = json_decode($response['response'], true);
                die();
            }

    } 

    protected function showPrivateFact($id)
    {
 
        $cUrl = env('FACTAPI') .'/fact/?id=' . $id;

        $privateFact = app('Curl')->getMetaData($cUrl);
        $fact = $privateFact['contents']['fact'];
        $category = $privateFact['contents']['category'];
        $subcategory = $privateFact['contents']['subcategory'];

        if($privateFact['success']){
            return response(compact('fact', 'category', 'subcategory'));
        }
         else {
            $error = json_decode($privateFact['response'], true);
            die();
        }
    }

    
}