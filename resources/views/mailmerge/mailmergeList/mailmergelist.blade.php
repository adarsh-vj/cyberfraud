@extends('layouts.app')

@section('content')

<style>
    .tabs-menu1 ul li a {
        padding: 10px 20px 11px 20px;
        display: block;
        color: #282f53;
        text-decoration: none;
    }

    .tabs-menu1 ul li a.active {
        border-bottom: 3px solid #3858f9;
        color: #3858f9; /* Optional: Change color when active */
    }
</style>

<link rel="stylesheet" href="path_to_bootstrap_css">
<link rel="stylesheet" href="path_to_font_awesome">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid">
    <div class="breadcrumb-header justify-content-between">
        <div>
            <h4 class="content-title mb-2">Hi, welcome back!</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Mail Merge List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Mail Merge List</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <!-- Alert container for AJAX responses -->
                    <div id="alert_ajaxx" style="display: none;"></div>

                    <div class="row">
                        <div class="col-7">
                            <h4 class="card-title" style="display: inline;">All Evidence Corresponding to Acknowledgement No: <b style="color: red;">{{ $ack_no }}</b></h4>
                        </div>
                        <div class="col-2">
                            @if ($website->isNotEmpty())
                            <button id="statusBtn" class="btn btn-success" style="margin-left: 10px;">Mail Merge</button>
                            @endif
                        </div>
                        <div class="col-3">

                        </div>
                    </div>

                        <!-- status Modal -->
    <div class="modal fade" id="status-popup" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Mail Merge</h2>
                    <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadOrderForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="statusType" class="form-label">Status:</label>
                            <select id="statusType" class="form-select" name="statusType" required>
                                <option value="">Select Status Type</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="reported">Reported</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="noticeType" class="form-label">Notice Type:</label>
                            <select id="noticeType" class="form-select" name="noticeType" required>
                                <option value="">Select Notice Type</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="button" class="btn btn-success" id="sendMail">Send Mail</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




                    <input type="hidden" id="caseData" value="ncrp">
                    <input type="hidden" id="ack_no" value="{{ $ack_no }}">

                    <div class="table-responsive">
                        <table id="ncrp" class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    {{-- <th>Acknowledgement No</th> --}}
                                    <th>Evidence Type</th>
                                    <th>URL</th>
                                    <th>Mobile</th>
                                    <th>Domain</th>
                                    <th>IP</th>
                                    <th>Registrar</th>
                                    <th>Registry Details</th>
                                    <th>Portal link</th>
                                    <th>Reported Status</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


<script src="path_to_bootstrap_js"></script>



<link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
<script src="{{ asset('js/toastr.js') }}"></script>

<script>
    $(document).ready(function() {
        // Show the upload modal when the button is clicked
        $('#statusBtn').on('click', function() {
            $('#status-popup').modal('show');
        });
    }); // <-- Added closing parenthesis for $(document).ready() function

    function closeModal() {
    $('#status-popup').modal('hide');
    // or use vanilla JavaScript approach
}


</script>

<script>
    $(document).ready(function() {
        $('#statusType').change(function() {
            var selectedStatus = $(this).val();
            var noticeTypeDropdown = $('#noticeType');

            // Clear previous options
            noticeTypeDropdown.empty();

            // Populate options based on selected status
            if (selectedStatus === 'active') {
                noticeTypeDropdown.append('<option value="Notice U/s 91 CrPC & 79(3)(b) of IT Act">Notice U/s 91 CrPC & 79(3)(b) of IT Act</option>');
                noticeTypeDropdown.append('<option value="Notice U/s 91 CrPC">Notice U/s 91 CrPC</option>');
                noticeTypeDropdown.append('<option value="Notice U/s 79(3)(b) of IT Act">Notice U/s 79(3)(b) of IT Act</option>');
                noticeTypeDropdown.append('<option value="For All Notice Type">For All Notice Type</option>');
            } else if (selectedStatus === 'inactive') {
                noticeTypeDropdown.append('<option value="Notice U/s 91 CrPC">Notice U/s 91 CrPC</option>');
            } else if (selectedStatus === 'reported') {
                noticeTypeDropdown.append('<option value="Notice U/s 91 CrPC & 79(3)(b) of IT Act">Notice U/s 91 CrPC & 79(3)(b) of IT Act</option>');
                noticeTypeDropdown.append('<option value="Notice U/s 91 CrPC">Notice U/s 91 CrPC</option>');
                noticeTypeDropdown.append('<option value="Notice U/s 79(3)(b) of IT Act">Notice U/s 79(3)(b) of IT Act</option>');
                noticeTypeDropdown.append('<option value="For All Notice Type">For All Notice Type</option>');
            }
            // You can add more conditions for other status types if needed

        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#sendMail').on('click', function() {
    var statusType = $('#statusType').val();
    var noticeType = $('#noticeType').val();
    var ack_no = $('#ack_no').val();
    var caseData = $('#caseData').val();

    // Validate if both fields are selected
    if (statusType && noticeType) {
        $.ajax({
            type: 'POST',
            url: '{{ route("send-email") }}',
            data: {
                statusType: statusType,
                noticeType: noticeType,
                ack_no: ack_no,
                caseData: caseData,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#alert_ajaxx').html('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                    response.success +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span></button></div>').show();
                $('#status-popup').modal('hide');
                $('#ncrp').DataTable().ajax.reload();
            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Error sending email.';
                $('#alert_ajaxx').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                    errorMessage +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span></button></div>').show();
                console.error('Error sending email:', error);
                $('#status-popup').modal('hide');
            }
        });
    } else {
        alert('Please select both Status Type and Notice Type.');
    }
});
    });
</script>



<script>
    $(document).ready(function() {
        // Initialize DataTable for #ncrp
        var tableNew = $('#ncrp').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('get.mailmergelist.ncrp') }}",
                data: function(d) {
                    // d.website_id = $('#website_id').val();
                    d.ack_no = $('#ack_no').val();
                }
            },
            columns: [
                { data: 'id' },
                // { data: 'acknowledgement_no' },
                { data: 'evidence_type' },
                { data: 'url' },
                { data: 'mobile' },
                { data: 'domain' },
                { data: 'ip' },
                { data: 'registrar' },
                { data: 'registry_details' },
                { data: 'portal_link' },
                { data: 'mail_status' },
                { data: 'status' },
            ],
            order: [0, 'desc'],
            ordering: true
        });
    });
</script>


<script>
    // Function to handle the onchange event of radio buttons
    function toggleReportStatus(radio) {
        var id = radio.getAttribute('data-id');
        var statusValue = radio.value;

        // Get CSRF token from meta tag
        var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

        // AJAX request to update the reported status
        $.ajax({
            url: '/update-reported-status/' + id,
            type: 'POST',
            data: {
                status: statusValue
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
            },
            success: function(response) {
                // Update UI or handle success response
                console.log('Status updated successfully.');
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error('Error updating status:', error);
            }
        });
    }
</script>




@endsection
