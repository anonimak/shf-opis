<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,300i,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="{{ public_path('css/main.css') }}" rel="stylesheet">
    <style>
        * { padding: 0; margin: 0; }

        body {
        /*color: #7d7a7a;*/
        /*font-family: 'trebuchet ms', verdana, sans-serif;*/
            font-family: sans-serif;
            margin: 2em 2em 2em 2em;
        }

        table {
            margin-bottom: 1em;
            width:100%;
        }

        table {
            border-collapse: collapse;
            border: 1pt solid black;
        }
        table td {
            border: 1pt solid black;
            text-align: center;
            font-size: 10px;
            padding: 0 2px 0 2px;
        }
        table th {
            border: 1pt solid black;
            text-align: center;
            background-color: rgb(184, 184, 184);
            font-size: 10px;
            padding: 0 2px 0 2px;
        }

        p {
            font-size: 10px;
        }

        hr {
            margin-bottom: 0.5em;
        }

        ol {
            font-size: 12px;
            margin: 0 2em 0 2em;
        }

    </style>

</head>

<body>
    <div>
        <table style="border:none">
            <tbody>
                <tr>
                    <td style="border:none; width:25%; text-align: left">
                        <img src="https://shf.co.id/img/brand.png" alt="" srcset="" width="160px">
                        <p style="margin-top: 2px; font-size: 9px">
                            Gedung Roxy Square Lt. 3 B 001 No. 02 Jl. Kyai Tapa No.1, Tomang, Grogol Petamburan, Jakarta Barat 11440
                        </p>
                    </td>
                    <td style="border:none; width:50%"></td>
                    <td style="border:none; width:25%;vertical-align: top; text-align: left">        
                        <h2>Purchase Order</h2>
                        <p>PO No  :{{ $memo->po_no}}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table style="border:none">
            <tbody>
                <tr>
                    <td style="border:none; width:25%; text-align: left">
                        <h2>Vendor</h2>
                        <p><strong>PT. Fiber Networks Indonesia</strong></p>
                        <p style="margin-top: 8px; font-size: 9px">
                            Perkantoran Tanjung Mas B1/5, Jl. Raya Tanjung Barat, Jakarta Selatan 12530
                        </p>
                    </td>
                    <td style="border:none; width:50%"></td>
                    <td style="border:none; width:25%"> 
                        <br>
                        <table style="border:none";>
                            <tbody>
                                <tr>
                                    <td style="border:none; text-align: left">Date</td>
                                    <td style="border:none">:</td>
                                    <td style="border:none; text-align: left">29-03-2021</td>
                                </tr>
                                <tr>
                                    <td style="border:none; text-align: left">Currency</td>
                                    <td style="border:none">:</td>
                                    <td style="border:none; text-align: left">IDR</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <p style="font-weight: bold">Please supply the following items :</p>
        @if ( count($memocost) > 0)
        <table>
            <thead>
                    @foreach ($memocost as $id => $cost)
                    @if ($id == 1)
                        @break
                    @endif
                    <tr>
                        @foreach($cost as $attr => $value)
                            <th>{{ $attr }}</th>
                        @endforeach
                    </tr>
                    @endforeach

            </thead>
            <tbody>

                    @foreach ($memocost as $cost)
                    <tr>
                        @foreach($cost as $attr => $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                    @endforeach

            </tbody>

                {{-- <tr>
                    <td colspan="4" style="height: 20px"> </td>
                </tr>
                <tr>
                    <th colspan="3">Amount</th>
                    <th>{{$sumtotal}}</th>
                </tr>
                <tr>
                    <th colspan="3">PPN</th>
                    <th>{{$ppn}}</th>

                </tr>
                <tr>
                    <th colspan="3">GRAND TOTAL</th>
                    <th>{{$grandtotal}}</th>
                </tr> --}}
            </tbody>
        </table>
        <br>
        @endif
        @if ( count($memo->approvers) > 0)
        <br>
        <br>
        <div style="width: 100%;">
            <table style="width: 60%; position: absolute; right: 0px;">
                <thead>
                    <tr>
                        @foreach ($memo->approversPo as $approver)
                            @if ($approver->employee)
                            <th>{{ $approver->employee->position_now->position->position_name }}</th>
                            @endif
                        @endforeach
                        <th> Confirm By</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($memo->approversPo as $approver)
                        @if ($approver->employee)
                            @if($approver->status == 'submit' || $approver->status == 'edit')
                            {{-- <td><div style="font-family: ZapfDingbats, sans-serif;">4</div></td> --}}
                            <td  style="height: 40px">-</td>
                            @elseif ($approver->status == 'reject' || $approver->status == 'revisi')
                            <td><div style="font-family: ZapfDingbats, sans-serif;">8</div></td>
                            @else
                            <td><div style="font-family: ZapfDingbats, sans-serif;">4</div></td>
                            @endif
                        @endif
                        @endforeach
                        <td style="height: 40px"></td>
                    </tr>
                    <tr>
                        @foreach ($memo->approversPo as $approver)
                            @if ($approver->employee)
                            <td>{{ $approver->employee->firstname." ".$approver->employee->lastname }}
                                @if ($approver->type_approver == 'acknowledge')
                                    ({{ $approver->type_approver}})
                                @endif
                            </td>
                            @endif
                        @endforeach
                        <td>VENDOR</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
    </div>
</body>

</html>