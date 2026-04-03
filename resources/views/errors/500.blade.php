@extends(getTemplate().'.layouts.app')

@section('content')
    <section class="my-50 container text-center">
        <div class="row justify-content-md-center">
            <div class="col col-md-6">
                {{-- صورة الخطأ الافتراضية --}}
                <img src="{{ asset('store/1/default_images/404.svg') }}" class="img-cover" alt="Site Error">
            </div>
        </div>

        {{-- عنوان الخطأ --}}
        <h2 class="mt-25 font-36">Oops! Something went wrong</h2>

        {{-- وصف الخطأ --}}
        <p class="mt-25 font-16">
            The site is temporarily unavailable due to a server issue. <br>
            Please try refreshing the page or come back later.
        </p>

        {{-- زر الرجوع للصفحة الرئيسية --}}
        <a href="{{ url('/') }}" class="btn btn-primary mt-25">Return Home</a>
    </section>

    <style>
        .img-cover {
            max-width: 100%;
            height: auto;
        }

        .font-36 {
            font-size: 36px;
            font-weight: bold;
            color: #1E40AF; /* أزرق داكن */
        }

        .font-16 {
            font-size: 16px;
            color: #1E3A8A; /* أزرق متوسط للنصوص */
        }

        .btn-primary {
            background-color: #3B82F6; /* أزرق ساطع */
            border-color: #3B82F6;
            color: #fff;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2563EB; /* أزرق أغمق عند hover */
            border-color: #2563EB;
            text-decoration: none;
            color: #fff;
        }
    </style>
@endsection
