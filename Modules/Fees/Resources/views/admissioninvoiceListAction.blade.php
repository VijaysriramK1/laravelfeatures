<x-drop-down>
    @if ((isset($role) && $role == 'admin') || $role == 'lms')
    @if (userPermission('fees.admission-fees-view-payment'))
    <a class="dropdown-item" onclick="admissionviewPaymentDetailModal({{ $row->id }})">@lang('inventory.view_payment')</a>
    @endif
    @if ($balance == 0)
    @if (userPermission('fees.admissionfees-invoice-view'))
                <a class="dropdown-item"
                    href="{{ route('fees.admissionfees-invoice-view', ['id' => $row->id, 'state' => 'view']) }}">@lang('common.view')</a>
            @endif
    @else
    @if ($paid_amount > 0)
    @if (userPermission('fees.admissionfees-invoice-view'))
                    <a class="dropdown-item"
                        href="{{ route('fees.admissionfees-invoice-view', ['id' => $row->id, 'state' => 'view']) }}">@lang('common.view')</a>
                @endif
    @if (userPermission('fees.admin-fees-payment'))
    <a class="dropdown-item"
        href="{{ route('fees.admin-fees-payment', $row->id) }}">@lang('inventory.add_payment')</a>
    @endif
    @else
    @if (userPermission('fees.admissionfees-invoice-view'))
                    <a class="dropdown-item"
                        href="{{ route('fees.admissionfees-invoice-view', ['id' => $row->id, 'state' => 'view']) }}">@lang('common.view')</a>
                @endif
    @if (userPermission('fees.admin-fees-payment'))
    <a class="dropdown-item"
        href="{{ route('fees.admin-fees-payment', $row->id) }}">@lang('inventory.add_payment')</a>
    @endif

    @if (userPermission('admissioninvoice-edit-amount'))
    <a class="dropdown-item"
        href="{{ route('admissioninvoice-edit-amount', $row->id) }}">@lang('common.edit')</a>
    @endif

    @if (userPermission('admissionfees-invoice-delete'))
    <a class="dropdown-item" href="#" onclick="admissionfeesInvoiceDelete({{ $row->id }})">
        @lang('common.delete')
    </a>

    @endif
    @endif
    @endif
    @endif
</x-drop-down>