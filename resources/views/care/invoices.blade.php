@if ($invoiceRows->isEmpty())
    <div class="care-empty text-center flex flex-col items-center p-[31px_25px_37px] [&_h3]:text-[14px] [&_h3]:font-semibold [&_h3]:text-[#425964] [&_p]:text-[12px] [&_p]:leading-[1.85] [&_p]:text-[#89969c] [&_p]:max-w-[335px] [&_p]:m-[9px_0_17px] phone:p-[27px_20px] dark:[&_h3]:text-[#e2edf2] dark:[&_p]:text-[#a3b6c2] care-empty-compact [&.care-empty-compact]:p-[24px] [&_.care-empty-icon]:w-[43px] [&_.care-empty-icon]:h-[43px] [&_.care-empty-icon]:rounded-[12px] [&_.care-empty-icon]:mb-[10px] [&_.care-empty-icon_.care-icon]:w-[21px]">
        <span class="care-empty-icon grid place-items-center w-[59px] h-[59px] [border:1px_solid_#dfede9] bg-[#f0f8f5] text-[#68a998] rounded-[18px] mb-[16px] [&_.care-icon]:w-[27px] [&_.care-icon]:h-[27px] dark:bg-[#203c40] dark:border-[#36554f] dark:text-[#83cdbd]"><x-care-icon name="bill" /></span>
        <h3>No invoices to show yet</h3>
        <p>When a bill is issued for your connection, you’ll find it here.</p>
    </div>
@else
    <div class="care-table-scroll overflow-x-auto">
        <table class="care-table w-full text-left border-collapse whitespace-nowrap [&_th]:text-[9px] [&_th]:uppercase [&_th]:tracking-[1px] [&_th]:text-[#8b9ca2] [&_th]:bg-[#fafcfc] [&_th]:p-[14px_25px] [&_th]:font-semibold [&_td]:p-[18px_25px] [&_td]:[border-top:1px_solid_#edf1f2] [&_td]:text-[12px] [&_td]:text-[#667d86] [&_strong]:font-semibold [&_strong]:!text-[#354e59] dark:[&_th]:bg-[#11212d] dark:[&_th]:text-[#93afbf] dark:[&_td]:border-[#2b3f4d] dark:[&_td]:text-[#bbcbd5] dark:[&_strong]:!text-[#e0ebf2]">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Connection</th>
                    <th>Due date</th>
                    <th>Billed amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoiceRows as $invoice)
                    <tr>
                        <td><a href="{{ route('billing.show', $invoice->id) }}" class="font-semibold text-teal-700 dark:text-[#8addc8] hover:underline">{{ $invoice->invoice_number }}</a></td>
                        <td>{{ $invoice->connection->name }}</td>
                        <td>{{ $invoice->due_date->format('d M Y') }}</td>
                        <td class="care-money font-semibold !text-[#354e59] dark:!text-[#e0ebf2]">৳{{ number_format($invoice->amount, 2) }}</td>
                        <td><span
                                class="care-badge inline-block text-[9px] font-semibold rounded-[5px] p-[5px_9px] bg-[#f3f1e9] text-[#95814d] whitespace-nowrap dark:bg-[#433c2b] dark:text-[#e9cc87] {{ $invoice->status === 'paid' ? 'care-badge-green [&.care-badge-green]:text-[#25896c] [&.care-badge-green]:bg-[#e8f7ee] dark:[&.care-badge-green]:bg-[#1d443a] dark:[&.care-badge-green]:text-[#83dabc]' : '' }}">{{ ucfirst(str_replace('_', ' ', $invoice->status)) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
