<html>
<head>
    <title>{{ $pageTitle ?? '' }}{{ !empty($generalSettings['site_name']) ? (' | '.$generalSettings['site_name']) : '' }}</title>
    <link href="/assets/default/css/font.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/default/css/app.css">
</head>
<body class="play-iframe-page">

@if(!empty($iframe))
    {!! $iframe !!}
@else
    <iframe 
        id="scormPlayer" 
        src="{{ $path }}" 
        frameborder="0" 
        allowfullscreen 
        class="interactive-file-iframe">
    </iframe>

    <script>
        const userId = {{ auth()->id() }};
        const fileId = {{ $fileId }};
        const webinarId = {{ $webinarId }};
        const saveUrl = "{{ route('scorm.progress.save') }}";
        const previousProgress = @json($progressData ?? null);

       console.log(">>> SCORM SYSTEM LOADED");
console.log("User ID:", userId);
console.log("File ID:", fileId);
console.log("Webinar ID:", webinarId);
console.log("Save URL:", saveUrl);
console.log("Previous Progress:", previousProgress);

// Listener
window.addEventListener("message", function(event) {
    console.log(">>> Received postMessage event:", event);  // NEW LINE

    if (event.data && event.data.type === 'scorm_progress') {
        console.log("Received SCORM progress:", event.data);

        const payload = {
            user_id: userId,
            file_id: fileId,
            webinar_id: webinarId,
            progress_percent: event.data.progress_percent,
            last_section_completed: event.data.last_section_completed,
            quiz: event.data.quiz
        };

        console.log("Sending payload to server:", payload);

        fetch(saveUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(res => console.log("SCORM saved:", res))
        .catch(err => console.error("SCORM save error:", err));
    }
}, false);


        // Send previous progress to iframe when page loads
        window.addEventListener("load", function() {
            if (previousProgress) {
                const iframe = document.getElementById("scormPlayer");
                console.log(">>> Sending previous progress to iframe:", previousProgress);
                iframe.contentWindow.postMessage({
                    type: 'load_scorm_progress',
                    data: previousProgress
                }, '*');
            }
        });
    </script>
@endif

</body>
</html>
