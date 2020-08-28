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
        $employees = $this->parseXml();
        $data = array();
        $data['names'] = array();
        $data['ages'] = array();
        foreach ($employees as $employee) {
            array_push($data['names'], $employee->name);
            array_push($data['ages'], $employee->age);
        }
        return view('welcome', compact('employees'));
    }

    public function index()
    {


        $tempEmployee = new Employee();
        $fillables = $tempEmployee->getFillable();
        $employees = $this->parseXml();
        return view('index', compact('employees', 'fillables'));
    }

    public function edit(Request $request)
    {
        $xml = simplexml_load_file('../resources/database.xml');
        $tempEmployee = new Employee();
        $fill = $tempEmployee->getFillable();
        $data = $request->all();
        foreach ($xml->employees->employee as $employee) {
            if ($employee->attributes()->id == $data['id']) {
                foreach ($fill as $item){
                    $employee->attributes()[$item] = $data[$item];
                }
            }
        }
        $xml->saveXML('../resources/database.xml');
        $notification = array(
            'message' => 'Employee was edited.',
            'alert-type' => 'info',
        );
        return redirect()->back()->with($notification);
    }

    public function delete($id)
    {
        $xml = simplexml_load_file('../resources/database.xml');
        foreach ($xml->employees->employee as $employee) {
            if ($employee->attributes()->id == $id) {
                $dom = dom_import_simplexml($employee);
                $dom->parentNode->removeChild($dom);
            }
        }
        $xml->saveXML('../resources/database.xml');
        $notification = array(
            'message' => 'Employee was deleted.',
            'alert-type' => 'info',
        );
        return redirect()->back()->with($notification);    }

    public function create(Request $request)
    {
        $employee = new Employee($request->all());
        $fill = $employee->getFillable();
        $xml = simplexml_load_file('../resources/database.xml');
        $child = $xml->employees->addChild("employee");
        $employee->id = $xml->employees->employee->count();
        foreach ($fill as $item) {
            $child->addAttribute($item, $employee[$item]);
        }
        $xml->saveXML('../resources/database.xml');
        $notification = array(
            'message' => 'Employee was created.',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);    }

    public function getData($id){
        $xml = simplexml_load_file('../resources/database.xml');
        foreach ($xml->employees->employee as $employee) {
            if ($employee->attributes()->id == $id) {
                return json_encode($employee->attributes());
            }
        }
        return null;
    }

    protected function parseXml(){
        $employees = new Collection();
        $xml = simplexml_load_file('../resources/database.xml');
        $json = json_encode($xml->employees);
        $array = json_decode($json, TRUE);

        if (!empty($array['employee'])) {
            foreach ($array['employee'] as $employee) {
                if(!empty($employee['@attributes'])){
                    $employees->add(new Employee($employee['@attributes']));
                }else{
                    $employees->add(new Employee($employee));
                }
            }
        }
        return $employees;
    }
}

