<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Notes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::with('notes')->get();
        return response()->json($tasks, 200)->setEncodingOptions(JSON_PRETTY_PRINT);
    }

    public function search(Request $request)
    {
        $tasks = Task::filter($request->all());
        return response()->json($tasks, 200)->setEncodingOptions(JSON_PRETTY_PRINT);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'due_date' => 'required',
            'status' => 'required|in:New,Incomplete,Complete',
            'priority' => 'required|in:Pending,Wait,Active',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'validation errors'], 400);
        }

        $data = [];
        $data['subject'] = $request->post('subject');
        $data['description'] = $request->post('description');
        $data['start_date'] = date('Y-m-d', strtotime($request->post('start_date')));
        $data['due_date'] = date('Y-m-d', strtotime($request->post('due_date')));
        $data['status'] = $request->post('status');
        $data['priority'] = $request->post('priority');
        $status = Task::storeData($data);

        if ($status['is_success']) {

            $last_inserted_id = $status['data']['id'];
            if (isset($request->notes) && $request->notes != "") {
                $notes = json_decode($request->notes, true);
                if (count($notes) > 0) {
                    foreach ($notes as $post) {
                        $data = [];
                        $data['subject'] = $post['subject'];
                        $data['attachment'] = '';
                        $data['task_id'] = $last_inserted_id;
                        $data['note'] = $post['note'];
                        $status = Notes::storeData($data);
                    }
                }
            }
            $data = [
                'message' => 'Task successfully added',
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
