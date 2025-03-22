@php
    use Illuminate\Support\Str;
    use Modules\RolePermission\Entities\Permission;
    use Modules\RolePermission\Entities\AssignPermission;

    $school_config = schoolConfig();

    $check_role_based_module_permission = AssignPermission::where('role_id', Auth::user()->role_id)
        ->where('school_id', Auth::user()->school_id)
        ->pluck('permission_id');

    $get_authorized_parent_modules_details = Permission::whereIn('id', $check_role_based_module_permission)
        ->where('school_id', Auth::user()->school_id)
        ->where('type', 1)
        ->where('parent_route', null)
        ->orderBy('position', 'asc')
        ->get();

    $get_authorized_sub_modules_details = Permission::whereIn('id', $check_role_based_module_permission)
        ->where('school_id', Auth::user()->school_id)
        ->where('type', '!=', 3)
        ->orderBy('position', 'asc')
        ->get();

    $get_parent_route = Request::segment(1);
    $current_route_details = Route::currentRouteName();

@endphp

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SG Academy Sidebar</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- sidebar part here -->
    
        <nav id="sidebar" class="sidebar">
            <ul class="sidebar_menu list-unstyled" id="sidebar_menu">
                <div class="sidebar-header update_sidebar">
                    <a id="close_sidebar" class="text-decoration-none d-lg-none">
                        <i class="ti-close"></i>
                    </a>
                </div>

                    @foreach ($get_authorized_parent_modules_details as $authorized_modules_values)
                        @if (!empty(validRouteUrl($authorized_modules_values->route)))
                            <li>
                                <a class="text-decoration-none {{ validRouteUrl($current_route_details) == validRouteUrl($authorized_modules_values->route) ? 'active' : '' }}"
                                    href="{{ validRouteUrl($authorized_modules_values->route) }}"
                                    class="text-decoration-none">

                                    <div class="nav_icon_small">
                                        <span class="{{ $authorized_modules_values->icon }}"></span>
                                    </div>

                                    <div class="nav_title">
                                        @if (Lang::has('communicate.' . $authorized_modules_values->lang_name))
                                            <span>{{ __('communicate.' . $authorized_modules_values->lang_name) ?? $authorized_sub_modules_values->name }}</span>
                                        @else
                                            <span>{{ __($authorized_modules_values->lang_name) ?? $authorized_sub_modules_values->name }}</span>
                                        @endif
                                    </div>
                                </a>
                            </li>
                        @else
                            <li
                                class="nav-item {{ $get_parent_route == $authorized_modules_values->route ? 'mm-active' : '' }}">
                                <a href="javascript:void(0)" class="text-decoration-none nav-link has-arrow"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseMenu_{{ $authorized_modules_values->id }}"
                                    aria-expanded="false">
                                    <div class="nav_icon_small">
                                        <span class="{{ $authorized_modules_values->icon }}"></span>
                                    </div>
                                    <div class="nav_title">
                                        @if (Lang::has('communicate.' . $authorized_modules_values->lang_name))
                                            <span>{{ __('communicate.' . $authorized_modules_values->lang_name) ?? $authorized_sub_modules_values->name }}</span>
                                        @else
                                            <span>{{ __($authorized_modules_values->lang_name) ?? $authorized_sub_modules_values->name }}</span>
                                        @endif
                                    </div>
                                </a>
                                <ul class="collapse {{ $get_parent_route == $authorized_modules_values->route ? 'mm-show show' : '' }}"
                                    id="collapseMenu_{{ $authorized_modules_values->id }}">

                                    @foreach ($get_authorized_sub_modules_details as $authorized_sub_modules_values)
                                        @if ($authorized_modules_values->route == $authorized_sub_modules_values->parent_route)
                                            @if (!empty(validRouteUrl($authorized_sub_modules_values->route)))
                                                <li class="nav-item">
                                                    <a class="text-decoration-none nav-link {{ validRouteUrl($current_route_details) == validRouteUrl($authorized_sub_modules_values->route) ? 'active' : '' }}"
                                                        href="{{ validRouteUrl($authorized_sub_modules_values->route) }}">
                                                        @if (Lang::has('communicate.' . $authorized_sub_modules_values->lang_name))
                                                            <span>{{ __('communicate.' . $authorized_sub_modules_values->lang_name) ?? $authorized_sub_modules_values->name }}</span>
                                                        @else
                                                            <span>{{ __($authorized_sub_modules_values->lang_name) ?? $authorized_sub_modules_values->name }}</span>
                                                        @endif
                                                    </a>
                                                </li>
                                            @else
                                                <!-- empty -->
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach


            </ul>
        </nav>

    <!-- sidebar part end -->
    @push('script')
        <script>
            $(document).ready(function() {
                var sections = [];
                $('.menu_seperator').each(function() {
                    sections.push($(this).data('section'));
                });

                jQuery.each(sections, function(index, section) {
                    if ($('.' + section).length == 0) {
                        $('#seperator_' + section).addClass('d-none');
                    } else {
                        $('#seperator_' + section).removeClass('d-none');
                    }
                });
            })
        </script>
    @endpush
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
