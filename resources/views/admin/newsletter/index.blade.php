@extends("admin.index")

@section("title", "nieuwsbrief")

@section("content")
    <div class="container">
        <div class="wrapper">
            <h2>NieuwsBrief</h2>
            <form action="{{ route('newsletter.send') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="pdf">Upload PDF:</label><br>
                <input type="file" id="pdfInput" name="pdf" accept="application/pdf" required>

                <button type="button" id="removePdfBtn" style="margin-left: 10px;">Verwijder PDF</button>
                <br><br>

                <button type="submit">Send PDF</button>
            </form>
        </div>
    </div>
    <script>

        const pdfInput = document.getElementById('pdfInput');
        const removePdfBtn = document.getElementById('removePdfBtn');

        removePdfBtn.addEventListener('click', function (){
            pdfInput.value = '';
        });
    </script>
@endsection
