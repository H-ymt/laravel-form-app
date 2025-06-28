<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="completeTextWrap">
        {{-- <h1 class="completeTitle">ENTRY</h1> --}}
        <p class="completeText">登録が完了しました。担当者より3～5日以内にご連絡を差し上げますので、今しばらくお待ちください。</p>
        <a href="{{ route('entry.index') }}" class="complete__backButton">戻る</a>
    </div>
</x-app-layout>
