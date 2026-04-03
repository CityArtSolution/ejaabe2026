@extends(getTemplate().'.layouts.egy_app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
body {
    font-family: 'Cairo', sans-serif !important;
}
thead {
    background: #1363a1;
    color: #fff;
}
    .mb-1 {
        margin-bottom: 0.25rem;
    }
    .table td {
        vertical-align: middle;
    }
    .original-price {
        text-decoration: line-through;
        color: red;
            font-weight: bold;
        font-size: 0.9em;
        font-family: sans-serif;
    }
    .discounted-price {
        color: green;
        font-weight: bold;
        padding-right: 5px;
        font-family: sans-serif;
           font-size: 0.9em;
    }
    button.btn.btn-info.btn-sm {
    background: #d78d36;
}

select#category {
    font-family: inherit;
}
a.btn.btn-info.btn-sm {
    background: #f3a140;
}
</style>
    <style>
    
    .table {
    border-collapse: collapse !important;
}

.table th,
.table td {
    border: 1px solid #444444 !important; /* 👈 أخف من الأسود */
}

/* تحسين التباين مع الصفوف المظللة */
.table-striped tbody tr:nth-of-type(even) {
    background-color: #f2f2f2 !important;
}

    .table-striped tbody tr:nth-of-type(even) {
        background-color: #d6d6d6 !important; /* أو جرّب: #d6d6d6، #cccccc */
    }
        hr.my-1 {
    border-top: 1px dashed #888;
    margin: 4px 0;
}

    </style>

@endpush

@section('content')
    <div class="container mt-30">
        <section class="mt-lg-50 pt-lg-20 mt-md-40 pt-md-40">
        @php
            $categories_filter=\App\Models\Category::whereNotIn('id', [612, 613])->/*->where('branch_id',session()->get('branch'))->*/orderBy('order','asc')->get();
            $selectedCategory = session()->get('selectedCategory') ?? '';
            $selectedDuration=session()->get('selectedDuration') ?? '';
        @endphp
        <div id="topFilters" class="shadow-lg border border-gray300 rounded-sm p-10 p-md-20">
            <div class="row align-items-center">
                <div class="col-lg-4 d-flex align-items-center">
                    <div class="checkbox-button primary-selected">
                        <form action="/{{app()->getLocale()}}/cet-course/plan/egy" method="get">
                            <select class="form-control primary_input mb_20  cats" name="categoryID" id="category">
                                <option value="">{{ __('public.Choose Category') }}</option>
                                @foreach($categories_filter as $cat)
                                <option value="{{ $cat->id }}" {{ $selectedCategory == $cat->id ? 'selected' : '' }}>{{ $cat->title }}</option>
                                @endforeach
                            </select>
                    </div>
                </div>
              <div class="col-lg-4 d-flex align-items-center">
                <div class="form-group">
                    <select name="ndays" id="ndaysFilter" class="form-control">
                        <option value="">{{ trans('public.Duration In days') }}</option>
                        @foreach ($uniqueNdDays as $ndays)
                        <option value="{{ $ndays }}" {{ request('ndays') == $ndays ? 'selected' : '' }}>{{ $ndays }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-4 d-flex align-items-center">
                <div class="search-input bg-white p-10 flex-grow-1">
                    <div class="form-group d-flex align-items-center m-0">
                        <input type="text" name="course_title" class="form-control border-0" placeholder="{{ trans('webinars.course') }}"/>
                        <button type="submit" class="btn btn-primary rounded-pill">{{ trans('home.find') }}</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
        <div class="row mt-20">
            <div class="col-12 col-lg-12">
                <div class="table-responsive">
                <!--<table class="table table-bordered table-hover">-->
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{trans('public.Title')}}</th>
                            <th>{{trans('public.Date')}}</th>
                            <th>{{trans('public.Time')}}</th>
                            <th style="width:7rem;text-align: center;">{{trans('public.Price')}}<br>{{trans('public.egy')}}</th>
                            <th style="width: 150px;">{{trans('public.Location')}}</th>
                            <th  style="width: 150px;">{{trans('public.Language')}}</th>
                            <th style="text-align: center; width: 10px;">{{trans('public.Duration')}}&nbsp;({{trans('public.Days')}})</th>
                            <th>{{trans('public.details')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($webinars as $loopIndex => $webinar)
                    @php $details = json_decode($webinar->details, true); @endphp
                    @foreach ($details as $i => $detail)
                        <tr>
                            @if ($i === 0)
                            <td rowspan="{{ count($details) }}">{{ $loopIndex + 1 }}</td>
                            <td rowspan="{{ count($details) }}">{{ $webinar->title }}</td>
                            @endif
                            <td>
                {{$detail['date']}}
            </td>
                            <td class="text-center" style="width:150px;">
                {{ $detail['start_time'] ?? '---' }} – {{ $detail['end_time'] ?? '---' }}
            </td>
                            <td class="text-center" style="width:7rem;">
                @php
                    $price = $detail['price'];
                    $discount = $webinar->discount_rate ?? 0;
                @endphp
                @if ($discount > 0)
                    <span class="text-decoration-line-through small me-1">
                        {{ number_format($price, 2) }}
                    </span>
                    {{ number_format($price * (1 - $discount/100), 2) }}
                @else
                    {{ number_format($price, 2) }}
                @endif
            </td>
                            <td style="width:150px;">{{ $detail['location'] ?? '—' }}</td>
                            <td style="width:150px;">
                @switch($detail['lang'])
                    @case('AR') {{ trans('public.Arabic') }} @break
                    @case('EN') {{ trans('public.English') }} @break
                    @default      {{ trans('public.Bilanguage') }}
                @endswitch
            </td>
                            <td class="text-center" style="width:10px;">{{ $detail['ndays'] }}</td>
                            @if ($i === 0)
                            <td rowspan="{{ count($details) }}">
                                <a href="/{{ app()->getLocale() }}/course/details/egy/{{ $webinar->slug }}"class="btn btn-info btn-sm">{{ trans('public.details') }}</a>
                            </td>
                            @endif
                    @endforeach
                    @endforeach
                    </tbody>
                </table>
</div>
</div>
</div>
            <div class="mt-50 pt-30">
                {{ $webinars->appends(request()->input())->links('vendor.pagination.panel') }}
            </div>
        </section>
    </div>

@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>

    <script src="/assets/default/js/parts/categories.min.js"></script>
@endpush
