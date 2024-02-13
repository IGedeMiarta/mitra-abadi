<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export {{ $title ?? '' }} As PDF</title>
    <!-- Include jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .container {

            /* Adjust the maximum width as needed */
            margin: 0 auto;
            /* Center the container horizontally */
            padding: 20px;
            /* Add some padding to the container */
            box-sizing: border-box;/
        }

        .btn-success {
            color: #fff;
            background-color: #28a745;
            border-color: #218838;
        }

        .btn-success:hover {
            color: #fff;
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }
    </style>
</head>

<body>
    <!-- Your table content -->
    <div class="container" id="print">
        <div class="row">
            <center>
                <img src="{{ asset('logo.png') }}" style="width: 100%; max-width: 200px" /><br>
                <strong>Phone: </strong> {{ app_data('phone') }}<br>
                <small>{!! app_data('address') !!}</small>
            </center>
            <br>
            <br>
        </div>
        <div style="margin-bottom: 8px; ">
            <h2 style="text-align: center;">Export {{ $title ?? '' }}</h2>
        </div>
        @yield('content')
        {{-- <button class="btn btn-success btn-sm" onclick="exportToPDF()">Export</button> --}}
    </div>
    <!-- Button to trigger PDF export -->

    <script>
        const tile = addDashesIfSpace("{{ $title ?? 'export' }}");
        exportToPDF()

        function exportToPDF() {
            var element = document.getElementById('print');
            var date = NowDate();
            var opt = {
                margin: 1,
                filename: `${tile}@${date}.pdf`,
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'landscape'
                }
            };
            html2pdf().set(opt).from(element).save();
        }

        function addDashesIfSpace(str) {
            // Use a regular expression to replace spaces with dashes
            return str.replace(/\s+/g, '-');
        }

        function NowDate() {
            var currentDate = new Date();

            // Get the current day, month, and year
            var day = currentDate.getDate();
            var month = currentDate.getMonth() + 1; // Months are zero-based, so add 1
            var year = currentDate.getFullYear();

            // Format the date as a string in "DD/MM/YYYY" format
            var formattedDate = (day < 10 ? '0' : '') + day + '-' + (month < 10 ? '0' : '') + month + '-' + year;
            return formattedDate;
        }
    </script>
</body>

</html>
