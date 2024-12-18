<div class="p-4 md:p-5 text-gray-700 body">
    <h4 class="font-bold text-lg">This is a picture of the certificate:</h4>
    <div class="w-full rounded-xl">
        <x-certificate user_name="{{ $certificate->user_name }}" course_title="{{ $certificate->course_title }}"
            completed_at="{{ $certificate->completed_at }}" completed_year="{{ $certificate->completed_year }}"
            id="{{ $certificate->id }}" qrCode="{{ $qrCode }}" />
    </div>
    <hr class="mt-2 h-.5 block bg-gray-200">
    <div class="my-2">
        <ol>
            <li><b>Certificate ID: </b><span>{{ $certificate->id }}</span></li>
            <li><b>Course start date: </b><span>{{ $certificate->start_date }}</span></li>
            <li><b>Course completion date: </b><span>{{ $certificate->completed_at }}</span></li>
        </ol>
    </div>
    <hr class="mt-2 h-.5 block bg-gray-200">
    <h4 class="font-bold text-lg">What are you waiting for? Share your joy with others:</h4>
    <div class="flex items-center gap-2">
        <div class="w-full">
            <x-input-copy id="copy-link-certificate" value='{{ $certificate->url_share }}' />
        </div>
        <button type="button" id="generate-pdf"
            class="py-2 px-4 text-white font-bold bg-amber-700 hover:bg-amber-800 duration-200 cursor-pointer rounded-xl">Download</button>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script>
    document.getElementById('generate-pdf').addEventListener('click', () => {
        const {
            jsPDF
        } = window.jspdf;

        const content = document.getElementsByClassName('content-pdf')[0];
        const pdf = new jsPDF();

        pdf.html(content, {
            callback: function(pdf) {
                pdf.save('document.pdf');
            },
            x: 10,
            y: 10,
            width: 180,
            windowWidth: 800
        });
    });
</script>
