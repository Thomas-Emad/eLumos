<script src="{{ asset('assets/js/pusher.js') }}"></script>

<script>
    const PUSHER_CLUSTER = "{{ config('broadcasting.connections.pusher.options.cluster') }}";
    const PUSHER_KEY = "{{ config('broadcasting.connections.pusher.key') }}";

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = false;

    var pusher = new Pusher(PUSHER_KEY, {
        cluster: PUSHER_CLUSTER,
        encrypted: true,
    });
</script>
