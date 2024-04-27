<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Member Card</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        .main {
            width: 346px;
            height: 214px;
            margin: auto;
            margin-bottom: 30px;
            position: relative;
        }

        .background-image {
            width: 345px;
            height: 212px;
            border-radius: 6px;
            position: relative;
            border: 1px solid gray;
            position: absolute;
        }

        .main-data {
            width: 345px;
            height: 212px;
            position: absolute;
        }

        .right-div,
        .left-div {
            position: absolute;
            float: left;
            width: 172px;
            height: 212px;
        }

        .logo {
            position: absolute;
            margin: 25px 0 0 18px;
        }

        .info {
            position: absolute;
            padding: 0 12px;
            height: 120px;
            margin-top: 72px;
        }

        .capitalize {
            text-transform: capitalize;
        }

        .register-hr {
            border-bottom: 1px solid black;
            width: 80px;
        }

        .back-div {
            padding: 10px;
            position: absolute;
            height: 194px;
            margin-left: 120px;
            width: 208px;
            display:
        }

        table th,
        td {
            margin: 0;
            padding: 0;
            padding-left: 8px;
            font-size: 12px;
        }

        table,
        tr,
        th,
        td {
            /* border: 1px solid black; */
            /* border-spacing: 0;
            border-collapse: collapse; */
        }
    </style>
</head>

<body>
    @foreach ($members as $member)
        <div>
            <div class="main">
                <img class="background-image" src="{{ public_path('dist/img/card/Front.png') }}" alt="">
                <div class="main-data">
                    <div class="left-div" style="font-size:15px; line-height: 1.5;">
                        <div class="info">
                            <table>
                                <tr>
                                    <td style="vertical-align:top">Nama</td>
                                    <td style="vertical-align:top">:</td>
                                    <td width="90">{{ $member->name }}</td>
                                </tr>
                                <tr>
                                    <td>NIM</td>
                                    <td>:</td>
                                    <td>{{ $member->npm }}</td>
                                </tr>
                                <tr>
                                    <td>Prodi</td>
                                    <td>:</td>
                                    <td>{{ $member->subject->name }}</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:top">Alamat</td>
                                    <td style="vertical-align:top">:</td>
                                    <td width="90"><div style="height: 2.7em; overflow: hidden">{{ $member->address }}</div></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="right-div">
                        <img style="padding-left: 50px; width:75px; height: 75px; margin-left:8.7px; margin-top:67px; margin-bottom: 15.5px; object-fit:cover;"
                            src="{{ public_path('dist/img/avatar/') . $member->avatar }}" alt="">
                        <span style="font-size: 10px; font-weight: bold; color: white; margin-left: 90px;">{{ date('d/m/Y', strtotime('+4 years', strtotime($member->created_at))) }}</span>
                    </div>
                </div>

            </div>
        </div>
        <div>
            <div class="main"><img class="background-image" src="{{ public_path('dist/img/card/Back.png') }}"
                    alt=""></div>
        </div>
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>
