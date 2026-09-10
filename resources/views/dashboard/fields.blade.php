@php
$fields = [
    ['name' => 'name', 'label' => 'Workspace name', 'type' => 'text', 'value' => $record?->name, 'options' => []],
    ['name' => 'default_view', 'label' => 'Default view', 'type' => 'select', 'value' => $record?->default_view, 'options' => ['all' => 'All connections','home' => 'Home','office' => 'Office']],
];
@endphp
<x-care.resource-page module="dashboard" label="Workspace preference" icon="grid" :mode="$mode" :fields="$fields" :record="$record" :available="$available"/>

