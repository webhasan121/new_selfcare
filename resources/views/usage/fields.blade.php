@php
$fields = [
    ['name' => 'connection_id', 'label' => 'Connection', 'type' => 'select', 'value' => $record?->connection_id, 'options' => ($connections ?? collect())->pluck('name', 'id')->all()],
    ['name' => 'start_date', 'label' => 'From date', 'type' => 'date', 'value' => $record?->start_date?->format('Y-m-d'), 'options' => []],
    ['name' => 'end_date', 'label' => 'To date', 'type' => 'date', 'value' => $record?->end_date?->format('Y-m-d'), 'options' => []],
];
@endphp
<x-care.resource-page module="usage" label="Usage report criteria" icon="chart" :mode="$mode" :fields="$fields" :record="$record" :available="$available"/>

