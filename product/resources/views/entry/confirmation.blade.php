<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <form action="{{ route('entry.store') }}" method="POST">
        @csrf
        <div>
            <h2 class="text-xl font-semibold mb-4">入力内容の確認</h2>
            <div>
                <p>お名前</p>
                <p>{{$formEntry['name']}}</p>
                <input type="hidden" name="name" id="name" value="{{ $formEntry['name']}}">
                @error('name')
                <p>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <p>フリガナ</p>
                <p>{{$formEntry['kana_name'] ?? ""}}</p>
                <input type="hidden" name="kana_name" id="kana_name" value="{{ $formEntry['kana_name'] }}">
                @error('kana_name')
                <p>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <p>電話番号</p>
                <input type="hidden" name="phone_number" id="phone_number" value="{{ $formEntry['phone_number'] }}">
                <p>{{$formEntry['phone_number']}}</p>
                @error('phone_number')
                <p>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <p>メールアドレス</p>
                <p>{{$formEntry['email']}}</p>
                <input type="hidden" name="email" id="email" value="{{ $formEntry['email'] }}">
                @error('email')
                <p>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <p>生年月日</p>
                <p>{{$formEntry['birth_day']}}</p>
                <input type="hidden" name="birth_day" id="birth_day" value="{{ $formEntry['birth_day']}}">
                @error('birth_day')
                <p>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <p>その他伝えたいことなど</p>
                <p>{{$formEntry['additional_info']}}</p>
                <input type="hidden" name="additional_info" id="additional_info" value="{{ $formEntry['additional_info']}}">
                @error('additional_info')
                <p>{{ $message }}</p>
                @enderror
            </div>
            <div class="terms">
                <p>利用規約</p>
                {{ $formEntry['agreement'] !== null ? ($formEntry['agreement'] ? '利用規約に同意する' : '利用規約に同意しない') : '未選択' }}
                <input type="hidden" id="agreement" name="agreement" value={{ $formEntry['agreement']}}>
                @error('agreement')
                <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <div>
                    <a href="{{ route('admin.dashboard') }}">戻る</a>
                </div>
                <button type="submit">送信</button>
            </div>
        </div>
    </form>
</x-app-layout>
