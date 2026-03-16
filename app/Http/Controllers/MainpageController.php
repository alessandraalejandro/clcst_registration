<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class MainpageController extends Controller
{
    public function getPerson (Request $params) {
    
    if ($params->search_data === "" || $params->search_data === null){
        $persons = DB::table("persons_tbl")
                    ->orderBy('person_id', 'desc')
                    ->paginate(10); // 5 per page
    }
    else{
        $persons = DB::table("persons_tbl")
            ->where("person_lname", 'LIKE', "%{$params->search_data}%")
            ->orWhere("person_fname", 'LIKE', "%{$params->search_data}%")
            ->orWhere("person_mname", 'LIKE', "%{$params->search_data}%")
            ->orderBy('person_id', 'desc')
            ->paginate(10); // 5 per page
    }

    return response()->json($persons);
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
         DB::beginTransaction();

        try {
         $userId = DB::table('users')->insertGetId([
                'name' => $request->input('person_fname') . ' ' . $request->input('person_mname'). ' ' . $request->input('person_lname'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'created_at' => now(),
                'updated_at' => now(),
            ]);


        $person = DB::table('persons_tbl')->insert([
            'account_id' => $userId,
            'person_fname' => $request->input('person_fname'),
            'person_mname' => $request->input('person_mname'),
            'person_lname' => $request->input('person_lname'),
            'person_suffix' => $request->input('person_suffix'),
            'person_bday' => $request->input('person_bday'),
            'person_contact' => $request->input('person_contact'),
        ]);
    
        DB::commit();

        }
        catch (\Exception $e) {

            DB::rollBack();
            $person = false;

        }
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

//     public function getPersonAccess (Request $params) {
    
//     if ($params->search_data === "" || $params->search_data === null){
//         $personAccess = DB::table("persons_permissions")
//                     ->orderBy('id', 'desc')
//                     ->paginate(10); // 5 per page
//     }
//     else{
//         $personAccess = DB::table("persons_permissions")
//             ->where("persons_id", 'LIKE', "%{$params->search_data}%")
//             ->orWhere("roles", 'LIKE', "%{$params->search_data}%")
//             ->orderBy('persons_id', 'desc')
//             ->paginate(10); // 5 per page
//     }

//     return response()->json($personAccess);
// }

    public function editPersonAccess (Request $request) {
            $accountId = DB::table('persons_tbl')
            ->where('account_id', $request->input('account_id'))
            ->first();

            if (!$accountId) {
            return response()->json([
                'status' => 500,
                'message' => 'No account_id found for this person'
            ]);
}

            $personAccess = DB::table('persons_permissions')
            ->updateorInsert(['account_id' => $accountId->account_id],
            [
                'roles' => $request->input('roles'),
                'user_management' => $request->input('user_management'),
                'feedback_management' => $request->input('feedback_management'),
                'appointment_management' => $request->input('appointment_management'),
                'clinic_records' => $request->input('clinic_records'),
                'guidance_records' => $request->input('guidance_records'),
                'pod_records' => $request->input('pod_records'),
                'student_module' => $request->input('student_module'),
                'faculty_module' => $request->input('faculty_module'),
                'guard_module' => $request->input('guard_module'),
            ]);
        
        if($personAccess){
            $status = 200;
        }
        else{
            $status = 500;
        }
        return [
            'data' => $request,
            'status' => $status];
        }

    
    public function getUserAccess ($id) {
        $userAccess = DB::table('persons_permissions')
        ->where("account_id", '=', $id)
        ->first();
    
        return response()->json([
            'data' => $userAccess
        ]);

}

}