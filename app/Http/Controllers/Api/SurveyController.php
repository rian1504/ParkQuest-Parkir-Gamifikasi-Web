<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    // Mengambil semua data survey
    public function index()
    {
        // Mengambil data survey
        $data = Survey::all();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil Data Survey',
        ], 200);
    }

    // Mendapatkan detail survey
    public function show(Survey $survey)
    {
        // Mengambil id survey
        $surveyId = $survey->id;

        // Mengambil data survey berdasarkan id
        $survey = Survey::with('question')->findOrFail($surveyId);

        if (!$survey) {
            // Mengembalikan response API Gagal
            return response([
                'code' => 404,
                'status' => false,
                'message' => 'Data Survey Tidak Ditemukan',
            ], 404);
        }

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $survey,
            'message' => 'Berhasil Mengambil Data Detail Survey',
        ], 200);
    }

    // Mengirim jawaban survei
    public function submit(Request $request, Survey $survey)
    {
        // Mengambil id survey
        $surveyId = $survey->id;

        // Mengambil id user
        $userId = Auth::user()->id;

        // Validasi input
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|integer',
            'answers.*.answer' => 'required|string',
        ]);

        // Pastikan survei ada
        $survey = Survey::find($surveyId);
        if (!$survey) {
            // Mengembalikan response API Gagal
            return response([
                'code' => 404,
                'status' => false,
                'message' => 'Data Survey Tidak Ditemukan',
            ], 404);
        }

        // Simpan respons survei
        $surveyResponse = SurveyResponse::create([
            'survey_id' => $surveyId,
            'user_id' => $userId,
        ]);

        // Simpan jawaban
        foreach ($validated['answers'] as $answer) {
            Answer::create([
                'survey_response_id' => $surveyResponse->id,
                'question_id' => $answer['question_id'],
                'answer' => $answer['answer'],
            ]);
        }

        // Menambahkan exp user
        $user = User::findOrFail($userId);
        $user->increment('EXP', 15);

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'message' => 'Berhasil Melakukan Survey',
        ], 200);
    }
}
