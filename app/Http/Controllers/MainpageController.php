<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MainpageController extends Controller
{
    public function getPerson () {
    
    $person = DB::table("persons_tbl")->get();

    return $person;

    }
    
    public function editPerson (Request $request) {
    if ($request->input('mode') == 1){
        $person = DB::table('persons_tbl')
        ->where("person_id", '=', $request->input('person_id'))
        ->update([
            'person_fname' => $request->input('person_fname'),
            'person_mname' => $request->input('person_mname'),
            'person_lname' => $request->input('person_lname'),
            'person_suffix' => $request->input('person_suffix'),
            'person_bday' => $request->input('person_bday'),
            'person_contact' => $request->input('person_contact'),
        ]);
    }
    else if ($request->input('mode') == 2){
            $person = DB::table('persons_tbl')
            ->where("person_id", '=', $request->input('person_id'))
            ->delete();
    }
    else {
        $person = DB::table('persons_tbl')->insert([
            'person_fname' => $request->input('person_fname'),
            'person_mname' => $request->input('person_mname'),
            'person_lname' => $request->input('person_lname'),
            'person_suffix' => $request->input('person_suffix'),
            'person_bday' => $request->input('person_bday'),
            'person_contact' => $request->input('person_contact'),
        ]);
}
    
    if($person){
        $status = 200;
    }
    else{
        $status = 500;
    }
    return [
        'data' => $request,
        'status' => $status];
    }
}

