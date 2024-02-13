<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>{{ $title ?? '' }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }

        .col {
            float: left;
            width: 50%;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

<body>

    <div class="invoice-box" id="print">
        <table cellpadding="0" cellspacing="0" style="width: 100%;">
            <div class="row">
                <div class="col">
                    <img src="{{ asset('logo.png') }}" style="width: 100%; max-width: 200px" /><br>
                </div>
                <div class="col" style="text-align: end;">
                    <strong>Phone: </strong> {{ app_data('phone') }}<br>
                    <small>{!! app_data('address') !!}
                    </small>
                </div>
            </div>
            <hr>
            <tr class="top">
                <td colspan="3" style="width: 100%; text-align: end">
                    <table style="width: 100%;">
                        <tr>
                            <td class="title" style="width: 30%;">
                                {{-- <img src="{{ asset('logo.png') }}" style="width: 100%; max-width: 300px" /> --}}
                            </td>
                            <td style="width: 30%;"></td>
                            <td style="width: 40%; text-align: end">
                                <strong> Invoice #{{ $order->Invoice }}<br /></strong>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="3">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 30%;">
                                <strong> Invoice To: </strong><br>
                                <span>{{ $order->customers->name }}</span><br />
                                {{ $order->customers->phone }}
                                <br>
                                {{ $order->customers->address }}
                            </td>
                            <td style="width: 30%;"></td>
                            <td style="width: 40%; text-align: end">
                                Created: <strong>{{ df($order->created_at) }}</strong><br />
                                Due: <strong>{{ due($order->created_at) }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <small>
                <tr class="heading">
                    <td style="width: 50%;">Bank Transfer</td>
                    <td style="width: 30%;"></td>
                    <td style="width: 50%;">Rek.</td>
                </tr>
                @foreach (app_data('bank_account') as $bank)
                    <tr class="details">
                        <td style="width: 30%;">{{ $bank['bank'] }}</td>
                        <td style="width: 30%;"></td>
                        <td style="width: 40%;">{{ $bank['no'] }} <br><small>{{ $bank['detail'] }}</small></td>
                    </tr>
                @endforeach

                <tr class="heading">
                    <td style="width: 30%;">Item</td>
                    <td style="width: 30%;text-align: start;">Qty</td>
                    <td style="width: 40%;">Price</td>
                </tr>
                @foreach ($order->details as $item)
                    <tr class="item">
                        <td style="width: 30%;">{{ $item->product->product_name }}</td>
                        <td style="width: 30%; text-align: start;">{{ $item->qty }}</td>
                        <td style="width: 40%;">{{ nb($item->price) }}</td>
                    </tr>
                @endforeach
                <tr class="total">
                    <td style="width: 30%;"></td>
                    <td style="width: 30%;">Total: </td>
                    <td style="width: 40%;">{{ nb($order->amount) }}</td>
                </tr>
        </table>
        </small>

        {{-- <hr> --}}
        Notes: <br>

        <small>
            {!! app_data('invoice_note') !!}
        </small>


    </div>
    {{-- <script>
        const tile = addDashesIfSpace("Invoice#{{ $order->Invoice }}");
        exportToPDF()

        function exportToPDF() {
            var element = document.getElementById('print');
            var date = NowDate();
            var opt = {
                margin: 1,
                filename: `${tile}.pdf`,
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
                    orientation: 'portrait'
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
    </script> --}}

</body>

</html>
