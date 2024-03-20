<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Certificate of Completion</title>

    <style>
        @font-face {
            font-family: 'washrab';
            font-style: normal;
            font-weight: normal;
            src: url("{{ asset('fonts/washrab.ttf') }}") format('truetype');
        }

        body {
            font-family: 'washrab';
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #000;
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin-top: 0;
        }

        h2 {
            margin-top: 30px;
            margin-bottom: 10px;
        }

        p {
            margin-top: 0;
            margin-bottom: 10px;
        }

        .logo {
            max-width: 200px;
            margin-bottom: 20px;
        }

        .signature {
            text-align: right;
            margin-top: 50px;
        }

        .signature p {
            line-height: 1.5;
            margin: 0;
        }
    </style>
</head>

<body>
    @foreach ($stores as $store)
        <div class="container">
            <img src="/var/www/stem/public/img/stem/stem-logo.png" class="logo">
            <h1>Certificate of Completion</h1>

            <p>This certifies that</p>
            <div>{{ $store['studentName'] }}</div>

            <p>has successfully completed the STEM Training Program</p>
            <p>From: {{ $store['endDate'] }} to {{ $store['issuedDate'] }}</p>

            <div class="signature">
                <p></p>
                <p>{{ $store['yourName'] }}</p>
                <p>{{ $store['yourPosition'] }}</p>
                <p>{{ $store['institution'] }}</p>
            </div>
        </div>
    @endforeach
</body>

</html>
