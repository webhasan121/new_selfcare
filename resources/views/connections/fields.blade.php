@php
    $fields = [
        [
            'name' => 'name',
            'label' => 'Connection name',
            'value' => $record?->name,
            'placeholder' => 'e.g. Home - Uttara',
            'hint' => 'Give this connection a name you will recognize.',
        ],
        [
            'name' => 'type',
            'label' => 'Connection type',
            'type' => 'select',
            'value' => $record?->type,
            'options' => ['home' => 'Home', 'office' => 'Office'],
            'hint' => 'Choose where this service will be used.',
        ],
        [
            'name' => 'installation_address',
            'label' => 'Installation address',
            'type' => 'textarea',
            'value' => $record?->installation_address,
            'required' => false,
            'placeholder' => 'House / building, road, area and city',
            'hint' => 'Include the floor or apartment number if needed.',
        ],
    ];
    if ($mode === 'create') {
        array_splice($fields, 2, 0, [
            [
                'name' => 'username',
                'label' => 'Username',
                'placeholder' => 'Your connection username',
                'hint' => 'Enter the username supplied by your internet provider.',
            ],
            [
                'name' => 'password',
                'label' => 'Password',
                'type' => 'password',
                'placeholder' => 'Your connection password',
                'hint' => 'Enter the password for this connection.',
            ],
        ]);
    } elseif ($mode === 'show') {
        $fields[] = ['name' => 'username', 'label' => 'Username', 'value' => $record?->username];
    }
    $fields[] = [
        'name' => 'status',
        'label' => 'Service status',
        'type' => 'select',
        'value' => $record?->status ?? 'pending',
        'options' => [
            'pending' => 'Pending',
            'active' => 'Active',
            'suspended' => 'Suspended',
            'inactive' => 'Inactive',
        ],
    ];
@endphp
<x-care.resource-page module="connections" label="Connection" icon="wifi" :mode="$mode" :fields="$fields"
    :record="$record" :available="$available" />
