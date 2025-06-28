<?php

namespace App\Http\Controllers;

use App\Models\FormEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{


    public function dashboard()
    {
        $formEntrys = FormEntry::where("is_output", false)->paginate(20, ['*'], 'form_entry');
        $formExportedEntrys = FormEntry::where('is_output', true)->orderBy('applied_at', 'desc')->paginate(20, ['*'], 'form_exported_entry');
        return view("admin/dashboard", ['formEntrys'  => $formEntrys, 'formExportedEntrys' => $formExportedEntrys]);
    }

    public function exportCsv(Request $request, $type)
    {
        try {
            if ($type === 'unexported') {
                $formEntrys = FormEntry::where("is_output", false)->get();
            } elseif ($type === 'exported') {
                $formEntrys = FormEntry::where("is_output", true)->get();
            }
            $today = date('Ymd');
            $filename = "cs3_form{$today}.csv";
            // カラムの作成
            $head = [
                '応募日時',
                'お名前',
                'フリガナ',
                '電話番号',
                'メールアドレス',
                '生年月日',
                'その他伝えたいことなど',
                '性別',
                '住所',
                '仕事NO'
            ];
            //csv用のデータリスト
            $csvFormEntrys = [];


            //CSV出力用にデータを加工
            foreach ($formEntrys as $formEntry) {
                $csvFormEntry = [
                    'applied_at' => $formEntry->applied_at,
                    'name' => $formEntry->name,
                    'kana_name' => $formEntry->kana_name,
                    'phone_number' => $formEntry->phone_number,
                    'email' => $formEntry->email,
                    'birth_day' => $formEntry->birth_day,
                    'additional_info' => $formEntry->additional_info,
                    'gender' => $formEntry->gender,
                    'address' => $formEntry->address,
                    'job_number' => $formEntry->job_number,
                ];
                array_push($csvFormEntrys, $csvFormEntry);
            }

            // 書き込み用ファイルを開く
            $f = fopen($filename, 'w');
            if ($f) {
                // カラムの書き込み
                mb_convert_variables('SJIS', 'UTF-8', $head);
                fputcsv($f, $head);
                // データの書き込み
                foreach ($csvFormEntrys  as $csvFormEntry) {
                    mb_convert_variables('SJIS', 'UTF-8', $csvFormEntry);
                    fputcsv($f, $csvFormEntry);
                }
            }
            // ファイルを閉じる
            fclose($f);

            // HTTPヘッダ
            header("Content-Type: application/octet-stream");
            header('Content-Length: ' . filesize($filename));
            header('Content-Disposition: attachment; filename=' . $filename);
            readfile($filename);
            FormEntry::where("is_output", false)->update(["is_output" => true]);
            $formEntrys = FormEntry::where("is_output", false)->paginate(20, ['*'], 'form_entry');
            $formExportedEntrys = FormEntry::where("is_output", true)->paginate(20, ['*'], 'form_exported_entry');
            // return view("admin/dashboard", ['formEntrys'  => $formEntrys, 'formExportedEntrys' => $formExportedEntrys]);
        } catch (\Exception $e) {
            return back()->with('error', '申し訳ありません。処理中にエラーが発生しました。もう一度お試しください。');
        }
    }

    public function deleteExportedForms()
    {
        try {
            DB::transaction(function () {
                FormEntry::where("is_output", true)->delete();
            });
            return redirect(route('admin.dashboard'))->with('success', '出力済みデータを全て削除しました。');
        } catch (\Exception $e) {
            return back()->with('error', '申し訳ありません。処理中にエラーが発生しました。もう一度お試しください。');
        }
    }
}
