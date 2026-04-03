@extends(getTemplate().'.layouts.canada_app')

@push('styles_top')
@endpush 

@section('content')
    <div class="container py-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/en/canada/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
            </ol>
        </nav>

        <h2 class="mb-4">Privacy Policy</h2>

        <p><strong>First: Rights and Intellectual Property:</strong></p>
        <p>
            The Positive Interaction training Center respects the intellectual and property rights of its owners.
            All remote courses are the intellectual property of the trainers. Therefore:
        </p>
        <ol>
            <li>Recording courses without the trainer’s permission is prohibited.</li>
            <li>Publishing files and training materials is prohibited unless authorized by the trainer.</li>
        </ol>
        <p>Violating intellectual property rights can lead to legal consequences, so compliance with the privacy policy is essential.</p>

        <p><strong>Second: Refund Policy:</strong></p>
        <ul>
            <li>
                Participants have the right to a full refund within five working days from the course date, 
                provided that the responsible employee is provided with the payment receipt to safeguard rights.
            </li>
        </ul>

        <p><strong>Third: Course Venue:</strong></p>
        <ul>
            <li>Courses are conducted in dedicated virtual rooms via the Zoom application.</li>
            <li>Participants receive the course link on the day of the event.</li>
            <li>Participants must download Zoom and familiarize themselves with it before the course begins.</li>
        </ul>

        <p><strong>Fourth: Certificate Issuance:</strong></p>
        <ul>
            <li>Certificates are issued through the Minar platform.</li>
            <li>Participants receive instructions to access the platform and print their certificates.</li>
        </ul>

        <p><strong>Fifth: Website Privacy Policy:</strong></p>
        <ul>
            <li>During registration, the site requests your name, phone number, email, and credit card information.</li>
            <li>Important data is kept confidential for participants.</li>
            <li>The site grants visitation rights without registration to explore our courses anonymously.</li>
        </ul>

        <p><strong>Sixth: Importance of Registering Your Data:</strong></p>
        <ul>
            <li>Facilitates communication with participants for mutual benefit.</li>
            <li>Contributes to site development through constructive feedback.</li>
            <li>Enables communication for offers and updates.</li>
            <li>Periodic emails are sent to the registered email address.</li>
            <li>Facilitates order processing, information sending, and updates related to your request.</li>
        </ul>

        <p><strong>Seventh: Protecting Your Information:</strong></p>
        <ul>
            <li>
                Our site operates within a secure server. Credit/sensitive information is encrypted using Secure Sockets Layer (SSL) technology, 
                accessible only to authorized personnel who are bound to keep it confidential.
            </li>
            <li>
                After payment, your private information (credit cards, social security numbers, financial data, etc.) is not stored on our servers.
            </li>
        </ul>
    </div>
@endsection

@push('scripts_bottom')
@endpush
