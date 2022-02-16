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
            font-size: 12px;
            padding: 0 2px 0 2px;
        }
        table th {
            border: 1pt solid black;
            text-align: center;
            background-color: rgb(184, 184, 184);
            font-size: 12px;
            padding: 0 2px 0 2px;
        }

        p {
            font-size: 12px;
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
        <h3 style="text-align: center">Internal Memo</h3>
        <br>
        <br>
        <h4>Memo Information :</h4>
        <hr>
        <table>
            <thead>
                <tr>
                    {{-- <th style="width: 10%">Fnc & Acc Manager</th> --}}
                    <th  style="width: 30%" colspan="2">Approval</th>
                    <th  style="width: 30%">Proposed by</th>
                    {{-- <th  style="width: 15%">Director</th>
                    <th  style="width: 15%">President Director</th> --}}
                </tr>
            </thead>
            <tbody>
                <tr>
                    {{-- <td rowspan="2" style="height: 50px"></td> --}}
                    <td>Dept.</td>
                    <td>{{
                            $employeeproposeinfo->proposeemployee
                                        ->position_now
                                        ->position->department
                                        ->department_name
                        }}</td>

                    <td>{{ $employeeproposeinfo->proposeemployee->firstname." ".$employeeproposeinfo->proposeemployee->lastname }}</td>
                    {{-- <td rowspan="2"></td>
                    <td rowspan="2"></td>
                    <td rowspan="2"></td> --}}
                </tr>
                <tr>
                    <td>Doc. No</td>
                    <td>{{$memo->doc_no}}</td>
                    <td style="height: 5%" rowspan="2">
                        <img style="margin:10px" src="data:image/png;base64, {!! $qrcode !!}">
                    </td>
                </tr>
                <tr>
                    {{-- <td>Silvia Usman</td> --}}
                    <td>Propose Date</td>
                    @if ($memo->propose_at == null)
                        <td>-</td>
                    @else
                        <td>{{ date('Y-m-d', strtotime($memo->propose_at)) }}</td>
                    @endif
                    {{-- <td>{{ $employeeproposeinfo->proposeemployee->firstname." ".$employeeproposeinfo->proposeemployee->lastname }}</td> --}}
                    {{-- <td>Andreas Kristian</td>
                    <td>Agustinus Budi Antoro</td>
                    <td>Seo Jisu</td> --}}
                </tr>
                <tr>
                    <td colspan="2">Title</td>
                    <td colspan="1">Final Approval Instruction</td>
                </tr>
                <tr>
                    <td>Purpose</td>
                    <td colspan="1">{{$memo->title}}</td>
                    <td colspan="1"></td>
                </tr>
                <tr>
                    <td>Branch</td>
                    <td colspan="1">{{$employeeInfo->employee->position_now->branch->branch_name}}</td>
                    <td colspan="1"><div style="font-family: ZapfDingbats, sans-serif;">4</div> Approval</td>
                </tr>
                @if ( count($memo->acknowledges) > 0)
                <tr>
                    <td>Send email after memo approved to</td>
                    <td colspan="2">
                        @foreach ($memo->acknowledges as $acknowledge)
                        {{ $acknowledge->employee->firstname." ".$acknowledge->employee->lastname }}
                        @if (!$loop->last)
                            ,
                        @endif
                        @endforeach
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
        @if ( count($memo->approvers) > 0)
        <h4>Approver :</h4>
        <hr>
        <table>
            <thead>
                <tr>
                    @foreach ($memo->approvers as $approver)
                        @if ($approver->employee)
                            @if($memo->propose_at == null)
                                    <th>{{ $approver->employee->position_now->position->position_name }}</th>
                            @else
                                    <th>{{ $approver->employee->emp_history->position->position_name }}</th>
                            @endif
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($memo->approvers as $approver)
                        @if ($approver->employee)
                        <td>{{ $approver->employee->firstname." ".$approver->employee->lastname }}
                            @if ($approver->type_approver == 'acknowledge')
                                (reviewer)
                            @endif
                        </td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    @foreach ($memo->approvers as $approver)
                    @if ($approver->employee)
                        @if($approver->status == 'submit' || $approver->status == 'edit')
                        {{-- <td><div style="font-family: ZapfDingbats, sans-serif;">4</div></td> --}}
                        <td>-</td>
                        @elseif ($approver->status == 'reject' || $approver->status == 'revisi')
                        <td><div style="font-family: ZapfDingbats, sans-serif;">8</div></td>
                        @else
                        <td><div style="font-family: ZapfDingbats, sans-serif;">4</div></td>
                        @endif
                    @endif
                    @endforeach
                </tr>
                <tr>
                    @foreach ($memo->approvers as $approver)
                        @if($approver->employee)
                            @if($approver->status == 'approve' || $approver->status == 'reject' || $approver->status == 'revisi')
                                <td> {{ $approver->msg }} </td>
                            @else
                                <td> - </td>
                            @endif
                        @endif
                    @endforeach
                </tr>
            </tbody>
        </table>
        @endif
        @if ( $memo->background != "<p></p>" && $memo->background != '')
        <h4>Background</h4>
        <hr>
        <p>{!!$memo->background!!}</p>
        <br>
        <br>
        @endif
        @if ( $memo->information != "<p></p>" && $memo->information != '')
        <h4>Information</h4>
        <hr>
        <p>{!!$memo->information!!}</p>
        <br>
        <br>
        @endif
        @if ( $memo->conclusion != "<p></p>" && $memo->conclusion != "")
        <h4>Conclusion</h4>
        <hr>
        <p>{!!$memo->conclusion!!}</p>
        <br>
        <br>
        @endif
        @if ( count($memocost) > 0)
        <h4>Cost/Expenses</h4>
        <hr>
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
        </table>
        {{-- <table style="width: 30%; position: relative; left: 511px;">
                <tbody>
                    <tr>
                        <th style="width: 38%; text-align: left;">Sub Total</th>
                        <td nowrap>
                            <div style="float: left;">Rp</div>
                            <div style="float: right;">{{ number_format($dataTotalCost['sub_total'], 2) }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 38%; text-align: left;">Pph23 (2%)</th>
                        <td nowrap>
                            <div style="float: left;">Rp</div>
                            <div style="float: right;">{{ number_format($dataTotalCost['pph'], 2) }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 38%; text-align: left;">PPN (10%)</th>
                        <td nowrap>
                            <div style="float: left;">Rp</div>
                            <div style="float: right;">{{ number_format($dataTotalCost['ppn'], 2) }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 38%; text-align: left;">Grand Total</th>
                        <td nowrap>
                            <div style="float: left;">Rp</div>
                            <div style="float: right;">{{ number_format($dataTotalCost['grand_total'], 2) }}</div>
                        </td>
                    </tr>
                </tbody>
        </table> --}}
        <br>
        @endif
        @if ( $memo->payment != "<p></p>" && $memo->payment != '')
        <h4>Payment</h4>
        <hr>
        <p>{!!$memo->payment!!}</p>
        <br>
        <br>
        @endif
        @if ( count($dataAttachments) > 0)
        <h4>Attachment</h4>
        <hr>
        <table>
            <thead>
                <tr>
                    <td>file</td>
                    <td>info</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataAttachments as $attachment)
                <tr>
                    <td>{{ $attachment->real_name }}</td>
                    <td>{{ ($attachment->type == 'payment')?'payment attachment':'' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</body>

</html>