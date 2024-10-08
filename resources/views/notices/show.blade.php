@extends('layouts.app')

@section('content')

<style>
    .custom-dropdown {
        position: relative;
        display: inline-block;
    }

    .custom-dropdown-button {
        background-color: #28a745; /* Bootstrap's success color */
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
    }

    .custom-dropdown-content {
        display: none; /* Hidden by default */
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px; /* Adjust the width as needed */
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        max-height: 200px; /* Set a max height for the dropdown */
        overflow-y: auto; /* Add vertical scrollbar if content overflows */
        padding: 5px 0;
    }

    .custom-dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .custom-dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .custom-dropdown:hover .custom-dropdown-content {
        display: block; /* Show dropdown on hover */
    }
    </style>


<!-- Local Bootstrap CSS -->
<link href="/path/to/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- jsPDF Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<!-- html2canvas Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>


<div class="container-fluid">
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div>
            <h4 class="content-title mb-2">Hi, welcome back!</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Notice Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Notice view</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- main-content-body -->
    <div class="row row-sm">
    <div id="alert_ajaxx" style="display:none"></div>
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <div class="alert alert-success-one alert-dismissible fade show w-100" role="alert" style="display:none">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
        <div class="col-md-12 col-xl-12" id="pdf_sec">
            <div class="card overflow-hidden review-project">
                <div class="card-body p-5">
                    <div class="m-4 d-flex justify-content-between">
                   <div class="text-center w-100">
                        <img src="../img/newlogo.jpg" class="logo-11" />
                       <p><b> No. IP(C4)-12442/2024/Cyb(18)
Cyber Police Headquarters,
Thiruvananthapuram<br></b>
sptele.pol@kerala.gov.in<br>
04712448707<br>
Dated. 03-07-2024</p>
                    </div>

                    </div>

                    <div class="notice-content ps-5 pe-5" id="notice-content">
                        {!! htmlspecialchars_decode($notice->content) !!}
                    </div>




                </div>
            </div>
        </div>
        <a href="{{ route('notices.index') }}" class="btn btn-secondary w-auto me-2">Back to List</a>
                    <a href="{{ route('notices.edit', $notice->id) }}" class="btn btn-success w-auto me-2">Update</a>
                    <a href="#" class="btn btn-primary w-auto me-2" onclick="downloadContent()">Download Content</a>


                       <span class="custom-dropdown w-auto">  <button class="custom-dropdown-button btn btn-success w-auto">Follow Up</button>
                        <div class="custom-dropdown-content">
                            @foreach($users as $user)
                                <a href="#" data-user-id="{{ $user->id }}">{{ $user->name }}</a>
                            @endforeach
                        </div>
</span>
    </div>
    <!-- /row -->
</div>


<!-- Local Bootstrap JS with Popper.js -->
<script src="/path/to/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Bundle with Popper.js -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    document.querySelectorAll('.custom-dropdown-content a').forEach(item => {
        item.addEventListener('click', event => {
            event.preventDefault();

            const userId = event.target.getAttribute('data-user-id');

            fetch(`/notices/{{ $notice->id }}/follow`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Followed user successfully!');
                } else {
                    alert('Failed to follow user.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });

</script>

<script>
    function downloadContent() {
    const { jsPDF } = window.jspdf;

            // Function to temporarily add CSS for h5 elements
            function setTempFontSize() {
            // Create a <style> element
            const style = document.createElement('style');
            style.id = 'temp-font-size-style'; // Add an ID for easy removal
            style.innerHTML = `
                .notice-content h5 {
                    font-size: 30px !important;
                }
            `;
            // Append the <style> element to the <head>
            document.head.appendChild(style);
        }

        // Function to remove the temporary CSS
        function removeTempFontSize() {
            const style = document.getElementById('temp-font-size-style');
            if (style) {
                document.head.removeChild(style);
            }
        }

        // Apply temporary font size
        setTempFontSize();

    // Capture the HTML content with html2canvas
    html2canvas(document.getElementById('pdf_sec')).then(canvas => {
        // alert("hi");
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('p', 'mm', 'a4');
        const imgWidth = 210; // A4 width in mm
        const pageHeight = 295; // A4 height in mm
        const imgHeight = canvas.height * imgWidth / canvas.width;
        let heightLeft = imgHeight;

        let position = 0;

        pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        // Add another page if needed
        while (heightLeft >= 0) {
            position = heightLeft - imgHeight;
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
        }

        pdf.save('notice-content.pdf');


            // Remove the temporary font size style
            removeTempFontSize();
    });
}

</script>

@endsection
