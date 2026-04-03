@php
    $userLanguages = !empty($generalSettings['site_language']) 
        ? [$generalSettings['site_language'] => getLanguages($generalSettings['site_language'])] 
        : [];

    if (!empty($generalSettings['user_languages']) && is_array($generalSettings['user_languages'])) {
        $userLanguages = getLanguages($generalSettings['user_languages']);
    }
@endphp

@if(!empty($userLanguages) && count($userLanguages) > 1)
    <form action="/locale" method="post" class="mr-2 mr-md-3 mb-0 admin-navbar-locale">
        @csrf
        <input type="hidden" name="locale">

        @if(!empty($previousUrl))
            <input type="hidden" name="previous_url" value="{{ $previousUrl }}">
        @endif

        <div class="language-select">
            <div id="localItems"
                 data-selected-country="{{ app()->getLocale() }}"
                 data-countries='{{ json_encode($userLanguages) }}'
            ></div>
        </div>
    </form>
@endif

@if(Auth::user()->isAdmin())
    @if(Auth::user()->isCanadaBranch())
        @php
            $canadaBranch = \App\Models\Branch::where('subdomain', 'canada')->first();
            if ($canadaBranch) {
                session(['admin_selected_branch' => $canadaBranch->id]);
            }
        @endphp
    @else
        <div class="language-select" style="padding-right:5px;border-radius: 10px;width: 10rem;text-align: center;">
            <select name="branch" id="branch" class="form-control branchLangChanger" onchange="location = this.value;">
                @foreach (\App\Models\Branch::get() as $branch)
                    @if($branch)
                        <option value="{{ route('branches.updateBranchSession', $branch->id) }}"
                            {{ session()->get('admin_selected_branch') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
    @endif
@endif



@push('scripts_bottom')
    <link href="/assets/default/vendors/flagstrap/css/flags.css" rel="stylesheet">
    <script src="/assets/default/vendors/flagstrap/js/jquery.flagstrap.min.js"></script>
    <script src="/assets/default/js/parts/top_nav_flags.min.js"></script>
@endpush
