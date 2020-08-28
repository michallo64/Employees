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
        $tempEmployee = new Employee();
        $fillables = $tempEmployee->getFillable();
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
        return redirect()->back();
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
        return redirect()->back();
    }

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
        return redirect()->back();
    }

    public function getData($id){
        $xml = simplexml_load_file('../resources/database.xml');
        foreach ($xml->employees->employee as $employee) {
            if ($employee->attributes()->id == $id) {
                return json_encode($employee->attributes());
            }
        }
        return null;
    }
}

