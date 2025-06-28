<x-app-layout>
    <x-slot name="header">
        <!-- Logo -->
        <div class="shrink-0 flex items-center">

        </div>
    </x-slot>

    @php
    $hasEntriesValue = !$formExportedEntrys->isEmpty();
    @endphp

    @if (session('error'))
    <p class="text-danger mt-3">
        {{ session('error') }}
    </p>
    @endif
    @if (session('success'))
    <p class="text-danger mt-3">
        {{ session('success') }}
    </p>
    @endif
    <div class="dashboard">
        <div class="form-buttons container-width">
            <form id="export" method="POST" class="export">
                <button type="submit" class="button button--primary button--md no-round">CSV出力</button>
                @csrf
            </form>
            <form id="deleteForm" action="{{ route('admin.delete.exported.forms') }}" method="POST" class="export">
                <button type="button" class="button button--primary button--md no-round redButton" onclick="confirmDelete()">一括削除
                </button>
                @csrf
            </form>
        </div>
        <div class="container-width tabWrapper">
            <div class="tab">
                <button class="tabButton unexported js-tabButton" onclick="toggleTab('unexported')">未出力データ</button>
                <button class="tabButton exported js-tabButton" onclick="toggleTab('exported')">出力済みデータ</button>
            </div>
            <div id="unexported_formEntrys" class="is-active">
                <div class="tableWrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="name">お名前</th>
                                <th class="tel">電話番号</th>
                                <th class="mail">メールアドレス</th>
                                <th class="birth">生年月日</th>
                                <th>その他伝えたいこと</th>
                                <th class="entryDate">応募日時</th>
                            </tr>
                        </thead>
                        @foreach ( $formEntrys as $formEntry)
                        <tbody>
                            <tr class="[&>td]:text-center">
                                <td>{{$formEntry->user_id}}</td>
                                <td>{{$formEntry->name}}</td>
                                <td>{{$formEntry->phone_number}}</td>
                                <td>{{$formEntry->email}}</td>
                                <td>{{$formEntry->birth_day}}</td>
                                <td class="additional_text">{{$formEntry->additional_info}}</td>
                                <td>{{$formEntry->applied_at}}</td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
                @if (!empty($formEntrys))
                {{ $formEntrys->links('vendor.pagination.tailwind') }}
                @endif
            </div>

            <div id="exported_formEntrys" style="display: none;">
                <div class="tableWrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="name">お名前</th>
                                <th class="tel">電話番号</th>
                                <th class="mail">メールアドレス</th>
                                <th class="birth">生年月日</th>
                                <th>その他伝えたいこと</th>
                                <th class="entryDate">応募日時</th>
                            </tr>
                        </thead>
                        @foreach ( $formExportedEntrys as $formExportedEntry)
                        <tbody>
                            <tr>
                                <td>{{$formExportedEntry->user_id}}</td>
                                <td>{{$formExportedEntry->name}}</td>
                                <td>{{$formExportedEntry->phone_number}}</td>
                                <td>{{$formExportedEntry->email}}</td>
                                <td>{{$formExportedEntry->birth_day}}</td>
                                <td class="additional_text">{{$formExportedEntry->additional_info}}</td>
                                <td>{{$formExportedEntry->applied_at}}</td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
                @if (!empty($formExportedEntrys))
                {{ $formExportedEntrys->links('vendor.pagination.tailwind') }}
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    let currentTab = 'unexported';

    function toggleTab(tab) {
        document.addEventListener('click', function(event) {
            currentTab = tab;
            localStorage.clear()
            localStorage.setItem("selectedTag", tab);
            if (tab === 'unexported') {
                document.getElementById('unexported_formEntrys').style.display = 'block';
                document.getElementById('unexported_formEntrys').classList.add('is-active');
                document.getElementById('exported_formEntrys').classList.remove('is-active');
                document.getElementById('exported_formEntrys').style.display = 'none';
            } else {
                document.getElementById('unexported_formEntrys').style.display = 'none';
                document.getElementById('unexported_formEntrys').classList.remove('is-active');
                document.getElementById('exported_formEntrys').classList.add('is-active');
                document.getElementById('exported_formEntrys').style.display = 'block';
            }
        })
    }

    window.addEventListener("load", function() {
        const selectedTag = localStorage.getItem("selectedTag");
        currentTab = selectedTag;
        console.log(selectedTag);
        if (selectedTag) {
            if (selectedTag === 'unexported') {
                document.getElementById('unexported_formEntrys').style.display = 'block';
                document.getElementById('unexported_formEntrys').classList.add('is-active');
                document.getElementById('exported_formEntrys').classList.remove('is-active');
                document.getElementById('exported_formEntrys').style.display = 'none';
            } else {
                document.getElementById('unexported_formEntrys').style.display = 'none';
                document.getElementById('unexported_formEntrys').classList.remove('is-active');
                document.getElementById('exported_formEntrys').classList.add('is-active');
                document.getElementById('exported_formEntrys').style.display = 'block';
            }
        }
    });



    document.getElementById("export").onsubmit = function(event) {
        event.preventDefault();
        console.log(exportUrl());
        this.action = exportUrl();
        this.target = "_blank"; // 新しいタブで開く
        this.submit();

        setTimeout(() => {
            location.reload(true);
        }, 3000); // 3秒後にリロード
    };

    function exportUrl() {
        let exportUrl = "{{ route('admin.csv', ['type' => ':type' ]) }}".replace(':type', currentTab);;
        return exportUrl;
    }

    function confirmDelete() {
        const hasEntries = {
            !!json_encode($hasEntriesValue) !!
        };
        if (!hasEntries) {
            alert('現在、削除対象のデータは存在しません。');
            return;
        }
        // OKを押したときだけ送信
        if (confirm('削除してもよろしいですか？')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>