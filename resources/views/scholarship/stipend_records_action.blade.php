<x-drop-down>
    @if ((isset($role) && $role == 'admin') || $role == 'lms')
    @if (userPermission('fees.fees-view-payment'))
    @endif
    @if ($balance == 0)
    @if (userPermission('stipend-records-view'))
    <a class="dropdown-item"
        href="{{ route('stipend-records-view', ['id' => $row->id, 'state' => 'view']) }}">@lang('common.view')</a>
    @endif
    @else
    @if ($paid_amount > 0)
    @if (userPermission('stipend-records-view'))
    <a class="dropdown-item"
        href="{{ route('stipend-records-view', ['id' => $row->id, 'state' => 'view']) }}">@lang('common.view')</a>
    @endif
    @if (userPermission('stipend-records-payment'))
    <a class="dropdown-item"
        href="{{ route('stipend-records-payment', $row->id) }}">@lang('inventory.add_payment')</a>
    @endif
    @else
    @if (userPermission('stipend-records-view'))
    <a class="dropdown-item"
        href="{{ route('stipend-records-view', ['id' => $row->id, 'state' => 'view']) }}">@lang('common.view')</a>
    @endif
    @if (userPermission('stipend-records-payment'))
    <a class="dropdown-item"
        href="{{ route('stipend-records-payment', $row->id) }}">@lang('inventory.add_payment')</a>
    @endif

    @if (userPermission('fees.fees-invoice-edit'))
   
          @endif

    @if (userPermission('stipend-records-delete'))
    <a class="dropdown-item"
        onclick="admissionfeesInvoiceDelete({{ $row->id }})"
        data-bs-toggle="modal"
        data-bs-target="#deleteAdmissionFeesPayment">
        @lang('common.delete')
    </a>
    @endif
    @endif
    @endif
    @endif
</x-drop-down>
