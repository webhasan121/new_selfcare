@php
$fields = [
    ['name' => 'subject', 'label' => 'Subject', 'type' => 'text', 'value' => $record?->subject, 'options' => []],
    ['name' => 'connection_id', 'label' => 'Connection', 'type' => 'select', 'value' => $record?->connection_id, 'options' => ($connections ?? collect())->pluck('name', 'id')->all()],
    ['name' => 'category', 'label' => 'Category', 'type' => 'select', 'value' => $record?->category, 'options' => ['connectivity' => 'Connectivity','speed' => 'Speed issue','billing' => 'Billing question','other' => 'Other']],
    ['name' => 'description', 'label' => 'Describe the issue', 'type' => 'textarea', 'value' => $record?->description, 'options' => []],
];
if ($mode === 'show') {
    $fields[] = ['name' => 'status', 'label' => 'Ticket status', 'type' => 'status', 'value' => $record->status, 'options' => []];
}
if ($mode === 'edit' && auth()->user()->hasAnyRole(['admin', 'support_staff'])) {
    $fields[] = ['name' => 'status', 'label' => 'Ticket status', 'type' => 'select', 'value' => $record->status, 'options' => ['open' => 'Open', 'in_progress' => 'In progress', 'resolved' => 'Resolved', 'closed' => 'Closed']];
}
@endphp
<x-care.resource-page module="support" label="Support ticket" icon="help" :mode="$mode" :fields="$fields" :record="$record" :available="$available"/>
