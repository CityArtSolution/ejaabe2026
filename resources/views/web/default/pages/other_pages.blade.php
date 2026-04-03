@extends(
    str_contains(request()->url(), 'egy') 
        ? getTemplate().'.layouts.egy_app' 
        : (str_contains(request()->url(), 'uae') 
            ? getTemplate().'.layouts.uae_app' 
            : getTemplate().'.layouts.app')
)

<style>/* From Uiverse.io by gharsh11032000 */ 
.card {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 320px;
  border-radius: 24px;
  line-height: 1.6;
  transition: all 0.48s cubic-bezier(0.23, 1, 0.32, 1);
}

.content {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 24px;
  padding: 36px;
  border-radius: 22px;
  color: #ffffff;
  overflow: hidden;
  background: #0a3cff;
  transition: all 0.48s cubic-bezier(0.23, 1, 0.32, 1);
}

.content::before {
  position: absolute;
  content: "";
  top: -4%;
  left: 50%;
  width: 90%;
  height: 90%;
  transform: translate(-50%);
  background: #ced8ff;
  z-index: -1;
  transform-origin: bottom;

  border-radius: inherit;
  transition: all 0.48s cubic-bezier(0.23, 1, 0.32, 1);
}

.content::after {
  position: absolute;
  content: "";
  top: -8%;
  left: 50%;
  width: 80%;
  height: 80%;
  transform: translate(-50%);
  background: #e7ecff;
  z-index: -2;
  transform-origin: bottom;
  border-radius: inherit;
  transition: all 0.48s cubic-bezier(0.23, 1, 0.32, 1);
}

.content svg {
  width: 48px;
  height: 48px;
}

.content .para {
  z-index: 1;
  opacity: 1;
  font-size: 18px;
  transition: all 0.48s cubic-bezier(0.23, 1, 0.32, 1);
}

.content .link {
  z-index: 1;
  color: #fea000;
  text-decoration: none;
  font-family: inherit;
  font-size: 16px;
  transition: all 0.48s cubic-bezier(0.23, 1, 0.32, 1);
}

.content .link:hover {
  text-decoration: underline;
}

.card:hover {
  transform: translate(0px, -16px);
}

.card:hover .content::before {
  rotate: -8deg;
  top: 0;
  width: 100%;
  height: 100%;
}

.card:hover .content::after {
  rotate: 8deg;
  top: 0;
  width: 100%;
  height: 100%;
}

.cart-banner {
        height: 200px; /* Adjust as needed */
        padding: 40px 0; /* Adjust padding for better spacing */
        background-color: #0a3cff; /* Optional: Add background color */
    }

    .cart-banner h1 {
        font-size: 24px; /* Adjust title size if needed */
    }
    
  /* General container for styling */
.post-show {
    font-family: 'Arial', sans-serif;
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* H1 Styling - Main Title */
.post-show h1 {
    font-size: 40px;
    font-weight: 700;
    color: #2c3e50;
    text-align: center;
    margin-bottom: 25px;
    text-transform: uppercase;
    position: relative;
    padding-bottom: 10px;
}

.post-show h1::after {
    content: '';
    width: 50px;
    height: 4px;
    background: #3498db;
    display: block;
    margin: 10px auto 0;
    border-radius: 2px;
}

/* H2 Styling - Subheadings */
.post-show h2 {
    font-size: 28px;
    font-weight: bold;
    color: #34495e;
    padding-left: 12px;
    border-left: 5px solid #3498db;
    margin-top: 20px;
    margin-bottom: 15px;
}

/* Paragraph Styling */
.post-show p {
    font-size: 18px;
    line-height: 1.8;
    color: #555;
    text-align: justify;
    margin-bottom: 15px;
    padding: 10px;
    background: #f9f9f9;
    border-radius: 5px;
    box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
}

/* Unordered List */
.post-show ul {
    padding-left: 0;
    margin-top: 15px;
}

/* List Items */
.post-show li {
    font-size: 18px;
    line-height: 1.8;
    padding: 12px;
    background: #ecf0f1;
    margin-bottom: 8px;
    border-left: 5px solid #2ecc71;
    border-radius: 5px;
    transition: all 0.3s ease-in-out;
    list-style: none;
    display: flex;
    align-items: center;
}

.post-show li::before {
    content: "✔";
    color: #2ecc71;
    font-weight: bold;
    margin-right: 10px;
}

.post-show li:hover {
    background: #d5f5e3;
    transform: scale(1.02);
}

/* Blockquote for Emphasis */
.post-show blockquote {
    font-size: 20px;
    font-style: italic;
    color: #7f8c8d;
    border-left: 5px solid #e74c3c;
    padding-left: 15px;
    margin: 20px 0;
    background: #fdf2f2;
    padding: 15px;
    border-radius: 5px;
}

</style>
@section('content')
   <section class="cart-banner position-relative text-center">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-12 col-md-9 col-lg-7">
                <h1 class="font-30 text-white font-weight-bold">{{ $page->title }}</h1>
            </div>
        </div>
    </div>
</section>


    <section class="container mt-10">
    <div class="row">
        <div class="col-12">
            <div class="post-show">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</section>


@endsection

@push('scripts_bottom')

@endpush
