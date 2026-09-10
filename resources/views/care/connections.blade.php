<div class="care-connection-list">
    @forelse($connectionRows as $connection)
        @php($subscription = $connection->subscriptions->first())
        <article class="care-connection-row flex items-center gap-[15px] p-[23px_25px] [border-top:1px_solid_#eff2f3] phone:p-[20px_15px] phone:gap-[10px] dark:border-[#293e4c]">
            <span class="care-connection-symbol w-[43px] h-[43px] rounded-[12px] bg-[#ecf6f4] text-[#419885] grid place-items-center shrink-0 phone:w-[34px] phone:h-[34px] dark:bg-[#203c40] dark:border-[#36554f] dark:text-[#83cdbd]"><x-care-icon :name="$connection->type === 'home' ? 'home' : 'box'" /></span>
            <div class="care-connection-info min-w-0 flex-1 [&_h3]:text-[13px] [&_h3]:font-[650] [&_h3]:[overflow-wrap:anywhere] [&_p]:block [&_p]:text-[10px] [&_p]:text-[#8a999e] [&_p]:mt-[6px] [&_small]:block [&_small]:text-[10px] [&_small]:text-[#8a999e] [&_small]:mt-[6px] phone:[&_h3]:text-[12px] dark:[&_h3]:text-[#e2edf2] dark:[&_p]:text-[#a3b6c2] dark:[&_small]:text-[#a3b6c2]">
                <h3><a href="{{ route('connections.show', $connection->id) }}" class="text-teal-700 dark:text-[#8addc8] hover:underline">{{ $connection->name }}</a></h3>
                <p>{{ $subscription?->package?->name ?? 'No current subscription' }}@if ($subscription?->package)
                        · {{ $subscription->package->speed_mbps }} Mbps
                    @endif
                </p>
                @if ($connection->installation_address)
                    <small>{{ $connection->installation_address }}</small>
                    @endif @if ($subscription)
                        <small>Valid until {{ $subscription->end_date->format('d M Y') }}</small>
                    @endif
            </div>
            <div class="care-connection-right flex items-end flex-col gap-[12px] phone:[&_.care-text-link]:text-[10px]"><span
                    class="care-badge inline-block text-[9px] font-semibold rounded-[5px] p-[5px_9px] bg-[#f3f1e9] text-[#95814d] whitespace-nowrap dark:bg-[#433c2b] dark:text-[#e9cc87] {{ $connection->status === 'active' ? 'care-badge-green [&.care-badge-green]:text-[#25896c] [&.care-badge-green]:bg-[#e8f7ee] dark:[&.care-badge-green]:bg-[#1d443a] dark:[&.care-badge-green]:text-[#83dabc]' : '' }}">{{ ucfirst($connection->status) }}</span><a
                    class="care-text-link inline-flex items-center gap-[7px] text-[#138f7f] text-[11px] font-[650] whitespace-nowrap [&_.care-icon]:w-[15px] dark:text-[#68d6bd]" href="{{ route('billing.index', ['connection' => $connection->id]) }}">View
                    bills <span aria-hidden="true">↗</span></a></div>
        </article>
        @empty
            <div class="care-empty text-center flex flex-col items-center p-[31px_25px_37px] [&_h3]:text-[14px] [&_h3]:font-semibold [&_h3]:text-[#425964] [&_p]:text-[12px] [&_p]:leading-[1.85] [&_p]:text-[#89969c] [&_p]:max-w-[335px] [&_p]:m-[9px_0_17px] phone:p-[27px_20px] dark:[&_h3]:text-[#e2edf2] dark:[&_p]:text-[#a3b6c2]"><span class="care-empty-icon grid place-items-center w-[59px] h-[59px] [border:1px_solid_#dfede9] bg-[#f0f8f5] text-[#68a998] rounded-[18px] mb-[16px] [&_.care-icon]:w-[27px] [&_.care-icon]:h-[27px] dark:bg-[#203c40] dark:border-[#36554f] dark:text-[#83cdbd]"><x-care-icon name="wifi" /></span>
                <h3>Your connection belongs here</h3>
                <p>No connections are linked to your account yet. Contact your provider to link your Home or Office service.
                </p><a class="care-text-link inline-flex items-center gap-[7px] text-[#138f7f] text-[11px] font-[650] whitespace-nowrap [&_.care-icon]:w-[15px] dark:text-[#68d6bd]" href="{{ route('support.index') }}">Find help <x-care-icon
                        name="arrow" /></a>
            </div>
        @endforelse
    </div>
