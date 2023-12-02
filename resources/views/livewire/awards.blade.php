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
                        <x-table.th>BASE SEN#</x-table.th>
                        <x-table.th>EMP#</x-table.th>
                        <x-table.th>DOMICILE</x-table.th>
                        <x-table.th>FLEET</x-table.th>
                        <x-table.th>SEAT</x-table.th>
                        <x-table.th>AWARD DOMICILE</x-table.th>
                        <x-table.th>AWARD FLEET</x-table.th>
                        <x-table.th>AWARD SEAT</x-table.th>
                        <x-table.th>NEW HIRE</x-table.th>
                        <x-table.th>UPGRADE</x-table.th>
                        <x-table.th>MONTH</x-table.th>
                        <x-table.th>DELETE</x-table.th>
                    </x-slot:head>
                    <x-slot:body>
                        @forelse ($awards as $award)
                            <tr>
                                <x-table.td>{{ $award->base_seniority }}</x-table.td>
                                <x-table.td>{{ $award->employee_number }}</x-table.td>
                                <x-table.td>{{ $award->domicile }}</x-table.td>
                                <x-table.td>{{ $award->fleet }}</x-table.td>
                                <x-table.td>{{ $award->seat }}</x-table.td>
                                <x-table.td>{{ $award->award_domicile }}</x-table.td>
                                <x-table.td>{{ $award->award_fleet }}</x-table.td>
                                <x-table.td>{{ $award->award_seat }}</x-table.td>
                                <x-table.td>{{ $award->is_new_hire ? 'YES' : 'NO' }}</x-table.td>
                                <x-table.td>{{ $award->is_upgrade ? 'YES' : 'NO' }}</x-table.td>
                                <x-table.td>{{ Carbon\Carbon::parse($award->month)->format('M Y') }}</x-table.td>
                                <x-table.td wire.click.confirm="deleteAward, {{ $award->id }}">
                                    <button type="button" wire:click="deleteAward({{ $award->employee_number }})" wire:confirm.prompt="Are you sure?\n\nType DELETE to confirm|DELETE">
                                        Delete Award 
                                    </button>
                                </x-table.td>
                            </tr>
                        @empty
                            <tr>
                                <x-table.td>EMPTY</x-table.td>
                            </tr>
                        @endforelse
                    </x-slot:body>
                </x-table>

                <div class="mt-4">{{ $awards->links() }}</div>

            </div>
        </div>
    </x-section>

    <x-section class="max-w-5xl" title="API Endpoints">
        <x-api-list>
            <x-slot:items>
                <x-api-li type="Model Response: Employee Parameter" params="award->employee_number" endpoint="v1/awards?employee_number=450765">
                    <pre><x-torchlight-code language='php' contents='views/torchlight/api/awards/model-response.blade.php'/></pre>
                </x-api-li>
            </x-slot:items>
        </x-api-list>
        <x-api-list>
            <x-slot:items>
                <x-api-li type="Collection Response: No Parameters" params="n/a" endpoint="v1/awards">
                    <pre><x-torchlight-code language='php' contents='views/torchlight/api/awards/collection-response.blade.php'/></pre>
                </x-api-li>
            </x-slot:items>
        </x-api-list>
        <x-api-list>
            <x-slot:items>
                <x-api-li type="Collection Response: Domicile Parameter" params="domicile=award->award_domicile" endpoint="v1/awards?domicile=lax">
                    <pre><x-torchlight-code language='php' contents='views/torchlight/api/awards/param-collection-response.blade.php'/></pre>
                </x-api-li>
            </x-slot:items>
        </x-api-list>
        <x-api-list>
            <x-slot:items>
                <x-api-li type="Collection Response: Upgrades Endpoint" params="n/a" endpoint="v1/awards/upgrades">
                    <pre><x-torchlight-code language='php' contents='views/torchlight/api/awards/upgrades/collection-response.blade.php'/></pre>
                </x-api-li>
            </x-slot:items>
        </x-api-list>
        <x-api-list>
            <x-slot:items>
                <x-api-li type="Collection Response" params="n/a" endpoint="v1/pilots/domiciles">
                    <pre><x-torchlight-code language='php' contents='views/torchlight/api/pilots/domiciles/collection-response.blade.php'/></pre>
                </x-api-li>
            </x-slot:items>
        </x-api-list>
    </x-section>
</div>