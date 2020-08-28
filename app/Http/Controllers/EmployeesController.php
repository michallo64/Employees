<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Rodenastyle\StreamParser\StreamParser;

class EmployeesController extends Controller
{
    public function home()
    {
        return view('welcome');
    }

    public function index()
    {
        $employees = new Collection();
        $xml = simplexml_load_file('../resources/database.xml');
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        if(!empty($array)){
            if(isset($array['employee']['id'])){
                $employees->add(new Employee($array['employee']));
            }else{
                foreach ($array['employee'] as $employee){
                    $employees->add(new Employee($employee));
                }
            }
        }
        return view('index', compact('employees'));
    }
    public function edit($id){

    }

    public function delete($id){
        $xml = simplexml_load_file('../resources/database.xml');
        foreach ($xml->employee as $employee){
            if($employee->id == $id){
                $dom=dom_import_simplexml($employee);
                $dom->parentNode->removeChild($dom);
            }
        }
        $xml->saveXML('../resources/database.xml');
        return redirect()->back();
    }

    public function create(Request $request){

    }
}

