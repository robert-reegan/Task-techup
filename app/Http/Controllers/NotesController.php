<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notes;
use Illuminate\Support\Facades\Validator;

class NotesController extends Controller
{


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'attachment' => 'required',
            'note' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'validation errors'], 400);
        }

        $path = "";
        if ($request->hasFile('attachment')) {
            $filenameWithExt = $request->file('attachment')->getClientOriginalName();
        
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        
            $extension = $request->file('attachment')->getClientOriginalExtension();
          
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
          
            $path = $request->file('attachment')->storeAs('public/files', $fileNameToStore);
        }

        $data = [];
        $data['subject'] = $request->post('subject');
        $data['attachment'] = $path;
        $data['task_id'] = $request->post('task_id');
        $data['note'] = $request->post('note');
        $status = Notes::storeData($data);

        if ($status['is_success']) {

            $data = [
                'message' => 'Note successfully added',
                'data' => (object) [],
                'error' => (object) [],

            ];
            return response()->json($data, 200)->setEncodingOptions(JSON_PRETTY_PRINT);
        } else {

            $data = [
                'message' => 'Something went wrong',
                'data' => (object) [],
                'error' => (object) [],

            ];
            return response()->json($data, 400)->setEncodingOptions(JSON_PRETTY_PRINT);
        }
    }
}
