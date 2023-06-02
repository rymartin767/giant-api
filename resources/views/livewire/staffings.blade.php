<div>
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
                        @forelse ($staffing->sortBy('list_date') as $staff)
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

    <x-section class="max-w-5xl" title="API Endpoints">
        <x-api-list>
            <x-slot:items>
                <x-api-li type="Model Response" params="date" endpoint="v1/staffing">
                    <pre><x-torchlight-code language='php' contents='views/torchlight/api/staffings/model-response.blade.php'/></pre>
                </x-api-li>
            </x-slot:items>
        </x-api-list>
    </x-section>
</div>