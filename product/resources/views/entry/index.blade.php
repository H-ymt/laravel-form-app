<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <h1>Page Title</h1>
    <p>Hello</p>

    @push('scripts')
    @if ($errors->any())
    @endif
    @endpush
</x-app-layout>
