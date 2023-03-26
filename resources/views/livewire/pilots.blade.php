<div>
    <x-section class="max-w-5xl" title="Import Pilots">
        @include('forms.create-pilot')
    </x-section>

    <x-section class="max-w-5xl" title="Pilot Index">
        <div class="grid grid-cols-4 gap-3">
            <div class="col-span-4">
                <x-table>
                    <x-slot:head>
                        <x-table.th>SEN#</x-table>
                        <x-table.th>EMP#</x-table>
                        <x-table.th>DOH</x-table>
                        <x-table.th>SEAT#</x-table>
                        <x-table.th>DOMICILE</x-table>
                        <x-table.th>FLEET</x-table>
                        <x-table.th>ACTIVE</x-table>
                        <x-table.th>RETIRE</x-table>
                    </x-slot:head>
                    <x-slot:body>
                        @forelse ($pilots as $pilot)
                            <tr>
                                <x-table.td>{{ $pilot->seniority_number }}</x-table>
                                <x-table.td>{{ $pilot->employee_number }}</x-table>
                                <x-table.td>{{ Carbon\Carbon::parse($pilot->doh)->format('m/d/Y') }}</x-table>
                                <x-table.td>{{ $pilot->seat }}</x-table>
                                <x-table.td>{{ $pilot->domicile }}</x-table>
                                <x-table.td>{{ $pilot->fleet }}</x-table>
                                <x-table.td>{{ $pilot->active }}</x-table>
                                <x-table.td>{{ Carbon\Carbon::parse($pilot->retire)->format('m/d/Y') }}</x-table>
                            </tr>
                        @empty
                            <tr>
                                <x-table.td>EMPTY</x-table>
                            </tr>
                        @endforelse
                    </x-slot:body>
                </x-table>

                <div class="mt-4">{{ $pilots->links() }}</div>

            </div>
        </div>
    </x-section>
</div>