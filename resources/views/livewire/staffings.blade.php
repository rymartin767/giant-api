<div>
    <x-section title="Pilot Months" class="max-w-5xl">
        <div class="mb-3">

            @isset($status)
                <div id="toast-simple" class="flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-white divide-x divide-gray-200 rounded-lg shadow dark:text-gray-400 dark:divide-gray-700 space-x dark:bg-gray-800" role="alert">
                    <svg aria-hidden="true" class="w-5 h-5 text-blue-600 dark:text-blue-500" focusable="false" data-prefix="fas" data-icon="paper-plane" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M511.6 36.86l-64 415.1c-1.5 9.734-7.375 18.22-15.97 23.05c-4.844 2.719-10.27 4.097-15.68 4.097c-4.188 0-8.319-.8154-12.29-2.472l-122.6-51.1l-50.86 76.29C226.3 508.5 219.8 512 212.8 512C201.3 512 192 502.7 192 491.2v-96.18c0-7.115 2.372-14.03 6.742-19.64L416 96l-293.7 264.3L19.69 317.5C8.438 312.8 .8125 302.2 .0625 289.1s5.469-23.72 16.06-29.77l448-255.1c10.69-6.109 23.88-5.547 34 1.406S513.5 24.72 511.6 36.86z"></path>
                    </svg>
                    <div class="pl-4 text-sm font-normal">{{ $status }}</div>
                </div>
            @endisset

        </div>
        <div class="grid grid-cols-4 gap-3">
            @forelse ($months as $key => $value)
            <div class="col-span-1 bg-white p-4">
                <div class="flex flex-col">
                    <div class="text-2xl">{{ $key }}</div>
                    <div>{{ $value['db_date'] }}</div>
                    <div>Has Staffing Report: {{ $value['has_staffing_report'] ? 'YES' : 'NO' }}</div>
                    @if (! $value['has_staffing_report'])
                    <x-button wire:click="storeStaffing()" type="button" class="mt-2">GENERATE REPORT</x-button>
                    @endif
                </div>
            </div>
            @empty

            @endforelse
        </div>
    </x-section>

    <x-section title="Staffing Index" class="max-w-5xl">
        <div class="grid grid-cols-4 gap-3">
            <div class="col-span-4">
                <x-table>
                    <x-slot:head>
                        <x-table.th>List Date</x-table.th>
                        <x-table.th>Total Pilots</x-table.th>
                        <x-table.th>Active Pilots</x-table.th>
                        <x-table.th>Inactive Pilots</x-table.th>
                        <x-table.th>Net Gain/Loss</x-table.th>
                        <x-table.th>YTD Gain/Loss</x-table.th>
                        <x-table.th>Average Age</x-table.th>
                    </x-slot:head>
                    <x-slot:body>
                        @forelse ($staffing as $staff)
                        <tr>
                            <x-table.td>{{ Carbon\Carbon::parse($staff->list_date)->format('Y-m-d') }}</x-table.td>
                            <x-table.td>{{ $staff->total_pilot_count }}</x-table.td>
                            <x-table.td>{{ $staff->active_pilot_count }}</x-table.td>
                            <x-table.td>{{ $staff->inactive_pilot_count}}</x-table.td>
                            <x-table.td>{{ $staff->net_gain_loss }}</x-table.td>
                            <x-table.td>{{ $staff->ytd_gain_loss }}</x-table.td>
                            <x-table.td>{{ $staff->average_age }}</x-table.td>
                        </tr>
                        @empty
                        <tr>
                            <x-table.td>EMPTY</x-table>
                </tr>
                @endforelse
                </x-slot:body>
                </x-table>
            </div>
        </div>
    </x-section>
</div>