<html>
<head>
    <style>
        .page-break {
            page-break-after: always;
        }

        table {
            width: 100%;
        }

        table tr {
            border: 1px solid black;
        }

        table tr th {
            border-bottom: 1px solid black;
        }

        table tr td {
            border-bottom: 1px solid black;
        }

        @media print {
            @page {
                size: 330mm 427mm;
                margin: 14mm;
            }

            .container {
                width: 1170px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <h3>Project: {{ $quotation->projectQuotations[0]->project['title'] }}</h3>
        </div>
        <div class="col-sm-4">
            <h3>Status: {{ $quotation->status['title'] }}</h3>
        </div>

    </div>
    <table>
        <tr>
            <th>
                component
            </th>
            <th>
                Description
            </th>
            <th>
                Comment
            </th>
            <th>
                Min
            </th>
            <th>
                Max
            </th>
            <th>
                Department
            </th>
        </tr>


        @foreach($quotation->projectQuotations[0]->quotationEstimates as $estimates)
            <tr>
                <td>
                    {{ $estimates->quotationTask->title }}
                </td>
                <td>
                    {{ $estimates->quotationTask->description }}
                </td>
                <td>
                    {{ $estimates['comment'] }}
                </td>
                <td>
                    {{ $estimates['min_estimate'] }}min
                </td>
                <td>
                    {{ $estimates['max_estimate'] }}min
                </td>
                <td>
                    {{ $estimates->department['name'] }}
                </td>
            </tr>
        @endforeach
    </table>
{{--    <div class="page-break"></div>--}}
</div>
</body>
</html>

