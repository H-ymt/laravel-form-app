<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormEntryRequest;
use App\Mail\AdminFormEntryRegisteredMail;
use App\Mail\FormEntryRegisteredMail;
use App\Models\FormEntry;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Symfony\Component\Mailer\Transport\SendmailTransport;

class EntryController extends Controller
{
    function index()
    {
        return view("entry.index");
    }

    public function store(FormEntryRequest $request)
    {
        try {
            // トランザクションを使用してDBへの書き込み
            DB::transaction(function () use ($request) {
                // フォームデータを保存
                $birthDay = Carbon::parse($request->birth_day)->format('Y/m/d');
                // バースデーの日付を正しいフォーマットに変換
                $newFormEntry = FormEntry::create([
                    'name' => $request->name,
                    'kana_name' => $request->kana_name,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'birth_day' => $birthDay,
                    'additional_info' => $request->additional_info,
                    'applied_at' => Carbon::now(),
                    'job_number' => 'csh1lp_nomura',
                ]);

                // セッションにフォームエントリデータを保存
                $request->session()->put("form_entry", $newFormEntry);

                // ユーザーIDを設定
                $user_Id = str_pad($newFormEntry->id, 3, '0', STR_PAD_LEFT);
                $newFormEntry->user_id = $user_Id;
                $newFormEntry->save();
                $this->sendMail($newFormEntry);
            });
            // 成功時にリダイレクト
            return redirect('entry/complete');
        } catch (\Exception $e) {
            return back()->with('error', '申し訳ありません。処理中にエラーが発生しました。もう一度お試しください。');
        }
    }

    private function sendMail($formEntry)
    {
        $adminEmails = ['iwaki@hiryu.co.jp'];
        Mail::to($formEntry->email)->send(new FormEntryRegisteredMail($formEntry));
        foreach($adminEmails as $adminEmail){
            Mail::to($adminEmail)->send(new AdminFormEntryRegisteredMail($formEntry));
        }

    }



    public function confirmation(FormEntryRequest $request)
    {
        return view('entry.confirmation', ['formEntry'  => $request->validated()]);
    }

    public function complete()
    {
        return view('entry/complete');
    }
}
