<div>
    <x-section class="max-w-5xl" title="Import Awards">
        @include('forms.create-award')
    </x-section>

    <x-section class="max-w-5xl" title="Award Index">
        <div class="grid grid-cols-4">
            <div class="col-span-4 mb-2">
                <div class="flex justify-end">
                    <x-button wire:click="truncateAwards" type="button">TRUNCATE</x-button>
                </div>
            </div>
            <div class="col-span-4">
                <x-table>
                    <x-slot:head>
                        <x-table.th>BASE SEN#</x-table>
                        <x-table.th>EMP#</x-table>
                        <x-table.th>DOMICILE</x-table>
                        <x-table.th>FLEET</x-table>
                        <x-table.th>SEAT</x-table>
                        <x-table.th>AWARD DOMICILE</x-table>
                        <x-table.th>AWARD FLEET</x-table>
                        <x-table.th>AWARD SEAT</x-table>
                        <x-table.th>UPGRADE</x-table>
                        <x-table.th>MARCH</x-table>
                    </x-slot:head>
                    <x-slot:body>
                        @forelse ($awards as $award)
                            <tr>
                                <x-table.td>{{ $award->base_seniority }}</x-table>
                                <x-table.td>{{ $award->employee_number }}</x-table>
                                <x-table.td>{{ $award->domicile }}</x-table>
                                <x-table.td>{{ $award->fleet }}</x-table>
                                <x-table.td>{{ $award->seat }}</x-table>
                                <x-table.td>{{ $award->award_domicile }}</x-table>
                                <x-table.td>{{ $award->award_fleet }}</x-table>
                                <x-table.td>{{ $award->award_seat }}</x-table>
                                <x-table.td>{{ $award->is_upgrade ? 'YES' : 'NO' }}</x-table>
                                <x-table.td>{{ Carbon\Carbon::parse($award->month)->format('M Y') }}</x-table>
                            </tr>
                        @empty
                            <tr>
                                <x-table.td>EMPTY</x-table>
                            </tr>
                        @endforelse
                    </x-slot:body>
                </x-table>

                <div class="mt-4">{{ $awards->links() }}</div>

            </div>
        </div>
    </x-section>
</div>