@extends(getTemplate().'.layouts.canada_app')

@push('styles_top')
<style>
  section {
    font-size: 0.9rem; /* حجم الخط أصغر قليلاً */
    line-height: 1.4;
    margin-bottom: 1.5rem;
  }
  section h2 {
    font-size: 1.2rem; /* عنوان أقل قليلاً من العنوان الافتراضي */
    margin-bottom: 0.5rem;
  }
  section ol {
    padding-left: 1.2rem;
  }
  section p {
    margin-top: 0.5rem;
  }
</style>
@endpush 

@section('content')
    <div class="container py-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/en/canada/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Technical support policy </li>
            </ol>
        </nav>

        <h2 class="mb-4">Technical support policy</h2>


        <section>
  <h2>User Responsibilities:</h2>
  <ol>
    <li>Clearly articulate the problem to the technical and educational support representative through the available channels.</li>
    <li>Adhere to conversational etiquette.</li>
    <li>Show respect and refrain from any form of misconduct.</li>
    <li>Avoid engaging in political or religious discussions.</li>
    <li>Provide available evidence related to the problem, if any.</li>
  </ol>
</section>

<section>
  <h2>Technical or Academic Support Representative Responsibilities:</h2>
  <ol>
    <li>Professionally respond to user inquiries within the expected timeframe for each channel.</li>
    <li>Adhere to conversational etiquette.</li>
    <li>Show respect and refrain from any form of misconduct.</li>
    <li>Avoid engaging in political or religious discussions.</li>
  </ol>
</section>

<section>
  <h2>Support Request Procedure:</h2>
  <p>
    In the event of any issue with users of the e-learning system, they should use any available channel to communicate with the academic or technical support team. Clearly explain the problem, provide evidence or documentation if available, and await a response within one working day. If there is no response from the support team after one working day, users must contact the system administrator.
  </p>
  <p>
    For support, contact: <a href="mailto:fosan@ejaabi.com">fosan@ejaabi.com</a>
  </p>
</section>

    </div>
@endsection

@push('scripts_bottom')
@endpush
