@php
$fields = [
    ['name' => 'invoice_number', 'label' => 'Invoice number', 'value' => $record?->invoice_number, 'placeholder' => 'e.g. INV-2026-001'],
    ['name' => 'connection_id', 'label' => 'Connection', 'type' => 'select', 'value' => $record?->connection_id, 'options' => $connections->pluck('name', 'id')->all(), 'hint' => 'An issued invoice cannot be moved to a different connection.'],
    ['name' => 'amount', 'label' => 'Billed amount (BDT)', 'type' => 'number', 'value' => $record?->amount, 'step' => '0.01', 'placeholder' => 'e.g. 550.00'],
    ['name' => 'due_date', 'label' => 'Due date', 'type' => 'date', 'value' => $record?->due_date?->format('Y-m-d')],
];
if ($mode === 'show') {
    $fields[] = ['name' => 'status', 'label' => 'Invoice status', 'value' => $record?->status, 'options' => ['unpaid' => 'Unpaid', 'partially_paid' => 'Partially paid', 'paid' => 'Paid', 'cancelled' => 'Cancelled']];
}
@endphp
<x-care.resource-page module="billing" label="Invoice" icon="bill" :mode="$mode" :fields="$fields" :record="$record" :available="$available"/>

