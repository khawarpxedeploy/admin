@php
$locale = \App::currentLocale();
@endphp
<div class="dropdown ml-lg-auto">
    <a href="#" class="btn btn-default dropdown-toggle " data-toggle="dropdown" id="navbarDropdownMenuLink2">
        @switch($locale)
            @case('en')
                <img class="flag-icons" src="{{ asset('argon') }}/img/icons/flags/US.png" /> English
            @break
            @case('fr')
                <img class="flag-icons" src="{{ asset('argon') }}/img/icons/flags/FR.png" /> Français
            @break
            @case('de')
                <img class="flag-icons" src="{{ asset('argon') }}/img/icons/flags/DE.png" /> German
            @break

            @default
                <img class="flag-icons" src="{{ asset('argon') }}/img/icons/flags/US.png" /> English
        @endswitch
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
        @if ($locale != 'en')
            <li>
                <a class="dropdown-item" href="{{ url('/lang/en') }}">
                    <img class="flag-icons" src="{{ asset('argon') }}/img/icons/flags/US.png" /> English
                </a>
            </li>
        @endif
        @if ($locale != 'fr')
            <li>
                <a class="dropdown-item" href="{{ url('/lang/fr') }}">
                    <img class="flag-icons" src="{{ asset('argon') }}/img/icons/flags/FR.png" /> Français
                </a>
            </li>
        @endif
        @if ($locale != 'de')
            <li>
                <a class="dropdown-item" href="{{ url('/lang/de') }}">
                    <img class="flag-icons" src="{{ asset('argon') }}/img/icons/flags/DE.png" /> German
                </a>
            </li>
        @endif
    </ul>
</div>
