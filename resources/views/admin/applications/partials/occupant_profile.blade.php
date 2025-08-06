@extends('layouts.master')
@section('title', 'Occupant Profile')
@section('content')

<!DOCTYPE html>
<html lang="en-PH">
<head>
    <meta charset="UTF-8">
    <title>Occupant Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Cambria, serif;
            font-size: 11pt;
            margin: 0;
            line-height: 1.5;
        }
        .center {
            text-align: center;
        }
        .form-border {
            border: 1px solid #000;
            padding: 40px;
            margin: 20px auto;
            max-width: 800px;
            background: white;
        }
        p, td, th {
            margin: 0;
        }
        .input-line, .input-wide {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 200px;
            padding-left: 5px;
        }
        .signature{
            text-align: right;
            margin-top: -5px;
            margin-right: 20px;
            font-size: 11pt;
        }
        .signature-input {
            margin-left: auto;
            width: 250px;
            border-bottom: 1px solid #000;
            text-align: center;
            margin-top: 30px;
        }
        .flex-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        @media print {
            body { margin: 0.5in; }
            button, .no-print { display: none !important; }
        }
    </style>
</head>
<body>

</body>
</html>

@endsection

