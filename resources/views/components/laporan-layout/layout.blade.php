<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <style>
        /* A4 Print Styles */
        @page {
            size: A4;
            margin: 0;
            margin-top: 20px;
            padding-top: 20px;
            /* Jarak atas di setiap halaman */
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        /* General Styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            border-collapse: collapse;
        }

        h1 {
            font-size: 23px;
            text-align: center;
            margin-bottom: 20px;
            margin-top: 0;
        }

        .text-center {
            text-align: center;
        }

        thead th {
            background-color: #f2f2f2;
            padding: 12px 8px;
            /* Jarak dalam heading */
        }

        thead {
            margin-bottom: 10px;
            /* Tambahkan jarak di bawah heading */
        }

        .container {
            max-width: 21cm;
            margin: 0 auto;
            padding: 0 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Hindari putusnya baris di tengah */
        tr {
            page-break-inside: avoid;
        }

        thead th {
            text-align: center;
        }

        /* Print button styles */
        #printButton {
            background-color: #ff0000;
            color: white;
            padding: 20px;
            border: none;
            cursor: pointer;
            /* margin-bottom: 20px; */
        }

        @media print {
            #printButton {
                display: none;
            }

            body {
                /* padding: 40px; */
            }

            .container {
                /* padding: 1.5cm; */
            }

            thead {
                display: table-header-group;
            }

            /* Reset margin for repeated headers */
            thead::after {
                margin-top: 0 !important;
            }

            /* Control page breaks */
            tr {
                page-break-inside: avoid;
            }

            /* Adjust spacing for subsequent pages */
            .table-wrapper {
                margin-top: 0;
            }

            /* Remove extra space after table on page breaks */
            table {
                margin-bottom: 0;
            }
        }

        @yield('css')
    </style>
</head>

<body>
    <div class="container">
        <button id="printButton">Print</button>
        @include('components.laporan-layout.header')
        <h1>@yield('title')</h1>

        @yield('content')
    </div>

    <script>
        document.getElementById("printButton").onclick = function() {
            window.print();
        }
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
